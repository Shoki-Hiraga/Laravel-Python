<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return view('main.image', compact('images'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg',
        ]);

        foreach ($request->file('images') as $image) {
            $path = $image->store('uploads');
            Image::create([
                'original_name' => $image->getClientOriginalName(),
                'file_path' => $path,
            ]);
        }

        return redirect('/images')->with('status', '画像をアップロードしました');
    }

    public function process()
    {
        $images = Image::all();

        $pythonBin = '/home/chasercb750/anaconda3/bin/python3';
        $scriptPath = base_path('app/python-dev/image_bokashi.py');

        foreach ($images as $img) {
            $inputPath = storage_path('app/' . $img->file_path);
            $outputPath = storage_path('app/processed_' . basename($img->file_path));

            // コマンド実行（stderrもキャプチャ）
            $cmd = "$pythonBin \"$scriptPath\" \"$inputPath\" \"$outputPath\"";
            $output = [];
            $returnVar = 0;
            exec($cmd . ' 2>&1', $output, $returnVar);

            if ($returnVar !== 0) {
                Log::error("❌ Pythonスクリプト実行エラー", [
                    'command' => $cmd,
                    'output' => $output,
                    'return_code' => $returnVar,
                ]);
                return redirect('/images')->with('status', '画像処理中にエラーが発生しました。ログをご確認ください。');
            }

            // ファイル生成チェック
            if (!file_exists($outputPath)) {
                Log::error("❌ 処理済みファイルが見つかりません", [
                    'expected_path' => $outputPath,
                ]);
                return redirect('/images')->with('status', '処理済み画像ファイルが生成されませんでした。');
            }
        }

        return redirect('/images')->with('status', '✅ 画像処理が完了しました');
    }

    public function download($id)
    {
        $image = Image::findOrFail($id);
        $processedPath = storage_path('app/processed_' . basename($image->file_path));

        // 処理済みファイルの存在確認
        if (!file_exists($processedPath)) {
            Log::warning("⚠️ ダウンロードファイルが存在しません", [
                'path' => $processedPath,
                'image_id' => $image->id,
            ]);

            return redirect('/images')->with('status', '処理済み画像が見つかりませんでした。もう一度「実行」してください。');
        }

        // 元画像削除 + DB削除
        Storage::delete($image->file_path);
        $image->delete();

        return response()->download($processedPath)->deleteFileAfterSend(true);
    }
}
