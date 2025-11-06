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

        // app/Python 以下の全ディレクトリを再帰的に探索
        $dir = new RecursiveDirectoryIterator(app_path('Python'));
        $iterator = new RecursiveIteratorIterator($dir);

        foreach ($iterator as $file) {
            if ($file->getExtension() === 'py') {
                // 例:　GA4_scraping/script.py のように相対パス化する
                $relativePath = str_replace(app_path('Python') . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $files[] = $relativePath;
            }
        }

        return view('python.runner', compact('files'));
    }

    public function execute(Request $request)
    {
        $filename = $request->input('file');

        $filePath = app_path("Python/" . $filename);  // relative path に対応

        if (!file_exists($filePath)) {
            return back()->with('error', 'ファイルが存在しません');
        }

        // Python 実行
        $process = new Process(['python3', $filePath]);
        $process->run();

        return redirect()->route('python.runner')
            ->with('output', $process->getOutput())
            ->with('selected_file', $filename);
    }
}
