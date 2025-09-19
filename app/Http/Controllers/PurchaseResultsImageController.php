<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PurchaseResultsImage;

class PurchaseResultsImageController extends Controller
{
    public function create()
    {
        return view('purchase_results_images.purch_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_results_id' => 'required|integer',
            'k_number' => 'required|string|max:255',
            'image' => 'required|image|max:102400', // 100MB
        ]);

        $file = $request->file('image');
        $originalName = $file->getClientOriginalName(); // 元のファイル名を取得
        $path = $file->storeAs('purchase_results_images', $originalName, 'public');

        PurchaseResultsImage::create([
            'purchase_results_id' => $request->purchase_results_id,
            'k_number' => $request->k_number,
            'image_path' => $path,
        ]);

        return redirect()->route('purchase_results_images.index')->with('success', '画像を保存しました！');
    }

    public function index()
    {
        // ページネーション（1ページ50件）
        $images = PurchaseResultsImage::latest()->paginate(50);

        return view('purchase_results_images.purch_index', compact('images'));
    }
    public function download($id)
    {
        $image = PurchaseResultsImage::findOrFail($id);
        return Storage::disk('public')->download($image->image_path);
    }

    public function destroy($id)
    {
        $image = PurchaseResultsImage::findOrFail($id);

        // ストレージから削除
        Storage::disk('public')->delete($image->image_path);

        // DBから削除
        $image->delete();

        return redirect()->route('purchase_results_images.index')->with('success', '画像を削除しました！');
    }
}
