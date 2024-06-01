<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicChannelController;
use App\Http\Controllers\PrivateChannelController;
use App\Http\Controllers\PresenceChannelController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/test-public-channel', [PublicChannelController::class, 'show']);
Route::post('/test-public-channel', [PublicChannelController::class, 'test'])->name('test-public-channel');
Route::get('/check-public-channel', [PublicChannelController::class, 'check']);

Route::middleware('auth')->group(function () {
    Route::get('/test-private-channel', [PrivateChannelController::class, 'show']);
    Route::post('/test-private-channel', [PrivateChannelController::class, 'test'])->name('test-private-channel');
    Route::get('/check-private-channel', [PrivateChannelController::class, 'check']);
});

Route::middleware('auth')->group(function () {
    Route::get('/presence-channel-chat', [PresenceChannelController::class, 'show']);
    Route::post('/presence-channel-chat', [PresenceChannelController::class, 'send'])->name('presence-channel-chat');
});
