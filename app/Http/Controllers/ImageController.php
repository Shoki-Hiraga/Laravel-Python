<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    // 画像アップロード処理
    public function upload(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|max:5120', // 各画像は最大5MB
        ]);

        foreach ($request->file('images') as $image) {
            $image->storeAs('public/uploads', $image->getClientOriginalName());
        }

        return response()->json(['message' => 'アップロード成功']);
    }

    // Pythonスクリプト実行＆加工済み画像をダウンロードさせる
    public function process(Request $request)
    {
        $filename = 'IMG_1629.jpg'; // 固定名（変更が必要ならパラメータで受け取るように拡張可能）
        $inputPath = storage_path('app/public/uploads/' . $filename);
        $outputPath = storage_path('app/public/processed/' . pathinfo($filename, PATHINFO_FILENAME) . '_processed.jpg');

        // ディレクトリが無ければ作成
        if (!file_exists(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        // Pythonスクリプト呼び出し
        $python = escapeshellcmd('~/anaconda3/bin/python');
        $script = base_path('python/image_bokashi.py');

        // 実行
        $cmd = "$python $script \"$inputPath\" \"$outputPath\"";
        exec($cmd, $output, $return_var);

        if ($return_var !== 0 || !file_exists($outputPath)) {
            return response()->json(['error' => '画像処理に失敗しました'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    // ビュー表示用
    public function show()
    {
        return view('main.image');
    }
}
