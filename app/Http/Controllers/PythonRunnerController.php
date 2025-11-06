<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
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

                // Windows/Linux どちらでも動作するようにパスを統一
                $filepath = str_replace('\\', '/', $file->getPathname());
                $basedir  = str_replace('\\', '/', app_path('Python'));

                // app/Python/ 以降を取得
                $relative = str_replace($basedir . '/', '', $filepath);

                $files[] = $relative;
            }
        }

        return view('python.runner', compact('files'));
    }

    public function execute(Request $request)
    {
        $relative = $request->file;
        $scriptPath = app_path('Python/' . $relative);
        $scriptName = str_replace(['/', '\\', '.py'], '_', $relative);

        $logPath = storage_path("logs/{$scriptName}.log");
        $pidPath = storage_path("logs/{$scriptName}.pid");

        // ✅ 二重実行防止
        if (file_exists($pidPath)) {
            $pid = trim(file_get_contents($pidPath));
            if ($this->isRunning($pid)) {
                return back()->with('error', "すでに実行中です（PID: {$pid}）");
            }
        }

        // ✅ 実行前にログ初期化
        file_put_contents($logPath, '');

        // ✅ 実行
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

        $log = file_exists($logPath) ? file_get_contents($logPath) : '';
        $pid = file_exists($pidPath) ? trim(file_get_contents($pidPath)) : null;

        $isRunning = $pid && $this->isRunning($pid);

        return view('python.log', compact('relative', 'log', 'isRunning'));
    }

    public function stop($relative)
    {
        $scriptName = str_replace(['/', '\\', '.py'], '_', $relative);
        $pidPath = storage_path("logs/{$scriptName}.pid");

        if (!file_exists($pidPath)) return back()->with('error', 'PID無し');

        $pid = trim(file_get_contents($pidPath));

        exec("kill -9 {$pid}");
        unlink($pidPath);

        return back()->with('success', '停止しました');
    }

    private function isRunning($pid)
    {
        return $pid && trim(shell_exec("ps -p {$pid} -o pid=")) == $pid;
    }
}
