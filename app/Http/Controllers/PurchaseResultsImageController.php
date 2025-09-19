<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseResultsImage;

class PurchaseResultsImageController extends Controller
{
    public function create()
    {
        return view('purchase_results_images.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_results_id' => 'required|integer',
            'k_number' => 'required|string|max:255',
            'image' => 'required|image|max:10240', // 10MB = 10240KB
        ]);

        $path = $request->file('image')->store('purchase_results_images', 'public');

        PurchaseResultsImage::create([
            'purchase_results_id' => $request->purchase_results_id,
            'k_number' => $request->k_number,
            'image_path' => $path,
        ]);

        return redirect()->back()->with('success', '画像を保存しました！');
    }
}
