<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfProtectorController;
use App\Http\Controllers\EmailFormatterController;

Route::get('/email-formatter', [EmailFormatterController::class, 'index'])->name('email-formatter.index');
Route::post('/email-formatter/preview', [EmailFormatterController::class, 'preview'])->name('email-formatter.preview');
Route::post('/email-formatter/send', [EmailFormatterController::class, 'send'])->name('email-formatter.send');


Route::get('/', function () {
    return view('welcome');

});

Route::get('/pdf-protector', [PdfProtectorController::class, 'index'])->middleware(['auth'])->name('pdf-protector');
Route::post('/pdf-protector', [PdfProtectorController::class, 'protect'])->middleware(['auth']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';