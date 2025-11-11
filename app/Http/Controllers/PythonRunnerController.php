<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class PythonRunnerController extends Controller
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
            if ($this->isRunning($pid)) {
                return redirect()->route('python.log', $relative);
            }
        }

        // ✅ 新規実行のみ初期化（touch と同じ）
        @touch($logPath);

        // ✅ Linux 用 nohup 実行（PID を取得）
        $cmd = "nohup python3 -u \"{$scriptPath}\" >> \"{$logPath}\" 2>&1 & echo $!";
        $pid = trim(shell_exec($cmd));

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

            // ✅ ファイル末尾から最大 30KB を読み込む（Windows と同じ）
            fseek($fp, -30000, SEEK_END);
            $log = fread($fp, 30000);

            fclose($fp);
        }

        // ✅ 文字コード変換（SJIS / CP932 → UTF-8）
        $log = mb_convert_encoding($log, 'UTF-8', 'CP932,SJIS-win,ASCII');

        $isRunning = false;
        if (file_exists($pidPath)) {
            $pid = trim(file_get_contents($pidPath));
            $isRunning = $this->isRunning($pid);
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
        if (!$this->isRunning($pid)) {
            unlink($pidPath);
            return back()->with('success', "既に停止していました (PID: {$pid})");
        }

        // ✅ kill（強制停止）
        exec("kill -9 {$pid}");

        unlink($pidPath);

        return back()->with('success', "スクリプトを停止しました (PID: {$pid})");
    }


    private function isRunning($pid)
    {
        $pid = intval($pid);
        $result = trim(shell_exec("ps -p {$pid} -o pid="));

        return $result == $pid;
    }
}
