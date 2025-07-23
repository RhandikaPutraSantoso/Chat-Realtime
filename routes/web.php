<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Http;

// Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Halaman dashboard (harus login & email terverifikasi)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profil user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Chat route (hanya untuk user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    

    Route::get('/chat/messages/{receiverId}', [ChatController::class, 'fetchMessages'])->name('chat.messages');
    Route::delete('/chat/message/{id}', [ChatController::class, 'deleteMessage'])->name('chat.message.delete');

});
    


// Autentikasi bawaan breeze
require __DIR__.'/auth.php';
