<?php

use App\Http\Controllers\AdminRouteController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ProfileController;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
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
})->name('Ana Sayfa');

Route::get('/about', [RouteController::class, 'about'])->name('Hakkımızda');
Route::get('/gallery', [RouteController::class, 'gallery'])->name('Görseller');
Route::get('/announcements', [RouteController::class, 'announcements'])->name('Duyurular');
Route::get('/contact', [RouteController::class, 'contact'])->name('İletişim');

require __DIR__ . '/auth.php';
