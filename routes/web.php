<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PythonController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ImageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('main.index');
})->name('TOP');

Route::get('/test', [PythonController::class, 'index'])
->name('test');

Route::get('/q_top', function () {
    return view('main.q_top');
})->name('q_top');

Route::get('/q_top/historia-article', function () {
    return view('main.q_historia');
})->name('historia_article');

Route::get('/form', [FormController::class, 'showForm'])->name('form');
Route::post('/form', [FormController::class, 'submitForm']);

Route::get('/images', [ImageController::class, 'index'])
->name('images');

Route::post('/images/upload', [ImageController::class, 'upload']);
Route::post('/images/process', [ImageController::class, 'process']);
Route::get('/images/download/{id}', [ImageController::class, 'download']);
Route::delete('/images/{id}', [ImageController::class, 'destroy'])->name('images.destroy');
