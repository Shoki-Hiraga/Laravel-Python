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

    public function process(Request $request)
    {
        $images = Image::all();

        $pythonBin = '/home/chasercb750/anaconda3/envs/rembg-env/bin/python3';
        $scriptPath = base_path('app/python-dev/image_bokashi.py');

        // ぼかし強度（必ず奇数に補正）
        $blur = intval($request->input('blur', 309));
        if ($blur % 2 === 0) {
            $blur += 1;
        }
        if ($blur < 1 || $blur > 999) {
            $blur = 309;
        }

        $log = [];

        foreach ($images as $img) {
            $inputPath = storage_path('app/' . $img->file_path);
            $outputPath = storage_path('app/processed_' . basename($img->file_path));

            // Pythonスクリプト呼び出し（blur引数を追加）
            $cmd = "$pythonBin \"$scriptPath\" \"$inputPath\" \"$outputPath\" \"$blur\"";

            $output = [];
            $returnVar = 0;
            exec($cmd . ' 2>&1', $output, $returnVar);

            $log[] = "【画像】" . $img->original_name;
            $log[] = "コマンド: $cmd";
            $log[] = "リターンコード: $returnVar";
            $log[] = "------ 実行ログ ------";
            $log = array_merge($log, $output);
            $log[] = "----------------------";

            if ($returnVar !== 0 || !file_exists($outputPath)) {
                $log[] = "❌ 処理に失敗しました。";
            } else {
                $log[] = "✅ 処理成功 → " . $outputPath;
            }

            $log[] = ""; // 区切り
        }

        return view('main.image', [
            'images' => Image::all(),
            'log' => $log,
        ]);
    }

    public function download($id)
    {
        $image = Image::findOrFail($id);
        $processedPath = storage_path('app/processed_' . basename($image->file_path));

        if (!file_exists($processedPath)) {
            Log::warning("⚠️ ダウンロードファイルが存在しません", [
                'path' => $processedPath,
                'image_id' => $image->id,
            ]);

            return redirect('/images')->with('status', '処理済み画像が見つかりませんでした。もう一度「実行」してください。');
        }

        Storage::delete($image->file_path);
        $image->delete();

        return response()->download($processedPath)->deleteFileAfterSend(true);
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        // ストレージから削除
        if (Storage::exists($image->file_path)) {
            Storage::delete($image->file_path);
        }
        
        // processedファイルもあれば削除（念のため）
        $processedPath = storage_path('app/processed_' . basename($image->file_path));
        if (file_exists($processedPath)) {
            unlink($processedPath);
        }

        // DBから削除
        $image->delete();

        // どのページから削除しても、必ず画像一覧ページ '/images' に戻す
        return redirect('/images')->with('status', '画像を削除しました。');
    }

}
