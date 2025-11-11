<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class PythonRunnerWindowsController extends Controller
{
    public function index()
    {
        $files = [];

        $dir = new RecursiveDirectoryIterator(app_path('Python'));
        $iterator = new RecursiveIteratorIterator($dir);

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'py') {
                $filepath = str_replace('\\', '/', $file->getPathname());
                $basedir  = str_replace('\\', '/', app_path('Python'));
                $relative = str_replace($basedir . '/', '', $filepath);
                $files[] = $relative;
            }
        }

        return view('python.runner', compact('files'));
    }

    public function execute(Request $request)
    {
        $relative = $request->file;
        $scriptPath = app_path("Python/{$relative}");
        $scriptName = str_replace(['/', '\\', '.py'], '_', $relative);

        $logPath = storage_path("logs/{$scriptName}.log");
        $pidPath = storage_path("logs/{$scriptName}.pid");

        // ✅ PID が存在し、動いていれば → すでに実行中
        if (file_exists($pidPath)) {
            $pid = trim(file_get_contents($pidPath));
            if ($this->isProcessRunning($pid)) {
                return redirect()->route('python.log', $relative);
            }
        }

        // ✅ 新規実行のみ初期化
        @touch($logPath);   // ← これならロックされてても OK

        // ✅ PowerShell Start-Process で PID を取得
        $ps = 'powershell -Command '
            . '"$p = Start-Process python '
            . ' -ArgumentList \'-u "' . $scriptPath . '"\' '
            . ' -RedirectStandardOutput \'' . $logPath . '\' '
            . ' -RedirectStandardError \'' . $logPath . '\' '
            . ' -PassThru; '
            . 'Write-Output $p.Id"';

        $pid = trim(shell_exec($ps));
        file_put_contents($pidPath, $pid);

        return redirect()->route('python.log', $relative);
    }


    public function log($relative)
    {
        $scriptName = str_replace(['/', '\\', '.py'], '_', $relative);

        $logPath = storage_path("logs/{$scriptName}.log");
        $pidPath = storage_path("logs/{$scriptName}.pid");

        $log = '';

        if (file_exists($logPath)) {
            $fp = fopen($logPath, 'r');

            // ✅ ファイル末尾から読む（最大30KB = 約3000行想定）
            fseek($fp, -30000, SEEK_END);   // ← サイズ大きければ後ろだけ読む
            $log = fread($fp, 30000);

            fclose($fp);
        }

        $log = mb_convert_encoding($log, 'UTF-8', 'CP932,SJIS-win,ASCII');

        $isRunning = false;
        if (file_exists($pidPath)) {
            $pid = trim(file_get_contents($pidPath));

            $isRunning = $this->isProcessRunning($pid);
        }

        return view('python.log', compact('relative', 'log', 'isRunning'));
    }

    public function stop($relative)
    {
        $scriptName = str_replace(['/', '\\', '.py'], '_', $relative);
        $pidPath = storage_path("logs/{$scriptName}.pid");

        if (!file_exists($pidPath)) {
            return back()->with('error', 'PIDファイルが存在しません。再実行してください。');
        }

        $pid = trim(file_get_contents($pidPath));

        // ✅ プロセスが動いているかチェック
        if (!$this->isProcessRunning($pid)) {
            unlink($pidPath);
            return back()->with('success', "既に停止していました (PID: {$pid})");
        }

        // ✅ taskkill（子プロセスも含めて強制停止）
        exec("taskkill /PID {$pid} /T /F");

        unlink($pidPath);

        return back()->with('success', "スクリプトを停止しました (PID: {$pid})");
    }

    private function isProcessRunning($pid)
    {
        $pid = intval($pid);
        exec("tasklist /FI \"PID eq {$pid}\" 2>NUL", $output);

        // “情報:“ の行は除外して判定
        return count($output) > 1 && !str_contains($output[1], '情報:') && !str_contains($output[1], 'No tasks are running');
    }
}
