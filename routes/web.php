<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicChannelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-public-channel', [PublicChannelController::class, 'show']);
Route::post('/test-public-channel', [PublicChannelController::class, 'test'])->name('test-public-channel');
Route::get('/check-public-channel', [PublicChannelController::class, 'check']);
