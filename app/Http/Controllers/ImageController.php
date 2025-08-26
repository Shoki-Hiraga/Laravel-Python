<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

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

        foreach ($images as $img) {
            $inputPath = storage_path('app/' . $img->file_path);
            $outputPath = storage_path('app/processed_' . basename($img->file_path));

            $cmd = "~/anaconda3/bin/python3 image_bokashi.py \"$inputPath\" \"$outputPath\"";
            exec($cmd);
        }

        return redirect('/images')->with('status', '画像処理が完了しました');
    }

    public function download($id)
    {
        $image = Image::findOrFail($id);
        $processedPath = storage_path('app/processed_' . basename($image->file_path));

        // 元画像削除処理
        Storage::delete($image->file_path);
        $image->delete();

        return response()->download($processedPath)->deleteFileAfterSend(true);
    }
}
