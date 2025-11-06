<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PythonController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PurchaseResultsImageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ---- Public pages ----
Route::get('/', function () {
    return view('main.index'); // ← TOPはこっちを採用
})->name('TOP');

Route::get('/test', [PythonController::class, 'index'])->name('test');

Route::get('/aws_tran', function () {
    return view('main.AWS_transfer');
})->name('aws_tran');

Route::get('/aws_opt', function () {
    return view('main.AWS_optimization');
})->name('aws_opt');

Route::get('/q_top', function () {
    return view('main.q_top');
})->name('q_top');

Route::get('/q_top/historia-article', function () {
    return view('main.q_historia');
})->name('historia_article');

// ---- Form ----
Route::get('/form', [FormController::class, 'showForm'])->name('form');
Route::post('/form', [FormController::class, 'submitForm']);

// ---- Image Processing ----
Route::get('/images', [ImageController::class, 'index'])->name('images');
Route::post('/images/upload', [ImageController::class, 'upload']);
Route::post('/images/process', [ImageController::class, 'process']);
Route::get('/images/download/{id}', [ImageController::class, 'download']);
Route::delete('/images/{id}', [ImageController::class, 'destroy'])->name('images.destroy');

// ---- Purchase Result Image ----
Route::get('/purchase-results-images', [PurchaseResultsImageController::class, 'index'])->name('purchase_results_images.index');
Route::get('/purchase-results-images/create', [PurchaseResultsImageController::class, 'create'])->name('purchase_results_images.create');
Route::get('/purchase-results-images/{id}/download', [PurchaseResultsImageController::class, 'download'])->name('purchase_results_images.download');
Route::delete('/purchase-results-images/{id}', [PurchaseResultsImageController::class, 'destroy'])->name('purchase_results_images.destroy');
Route::post('/purchase-results-images', [PurchaseResultsImageController::class, 'store'])->name('purchase_results_images.store');

// ---- Auth Required (Breeze) ----
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
