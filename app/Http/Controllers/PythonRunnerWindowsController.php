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

        file_put_contents($logPath, ''); // ログ初期化

        // ✅ Windows のバックグラウンド実行
        $cmd = "start /B python \"{$scriptPath}\" >> \"{$logPath}\" 2>&1";
        shell_exec($cmd);

        // WindowsではPID取得不可、仮で 'win' と入れておく
        file_put_contents($pidPath, 'win');

        return redirect()->route('python.log', $relative);
    }

    public function log($relative)
    {
        $scriptName = str_replace(['/', '\\', '.py'], '_', $relative);

        $logPath = storage_path("logs/{$scriptName}.log");

        $log = file_exists($logPath) ? file_get_contents($logPath) : '';

        // ✅ Windows → SJIS → UTF-8 にして文字化け対策
        $log = mb_convert_encoding($log, 'UTF-8', 'CP932,SJIS-win,ASCII');

        return view('python.log', [
            'relative' => $relative,
            'log' => $log,
            'isRunning' => false  // Windowsでは停止管理しない
        ]);
    }

    public function stop()
    {
        return back()->with('error', 'Windowsでは停止処理に対応していません');
    }
}
