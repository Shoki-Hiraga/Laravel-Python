<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PythonController extends Controller
{
    public function index()
    {
        // Pythonスクリプトのパス
        $pythonTitlePath = base_path('app/python-dev/python-title.py');
        // Pythonスクリプトを実行し、出力を取得
        $python_title_output = shell_exec("python $pythonTitlePath");

        $pythonH1Path = base_path('app/python-dev/python-h1.py');
        $python_h1_output = shell_exec("python $pythonH1Path");

        // ビューに出力を渡す
        return view('main.index', [
            'python_title' => $python_title_output,
            'python_h1' => $python_h1_output
    ]);
    }
}
