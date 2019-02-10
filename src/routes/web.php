<?php

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

use App\Events\BookUploadEvent;
use App\Models\Book\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    event(new BookUploadEvent(Book::findOrFail(1)));
    Log::info($_SERVER['HTTP_USER_AGENT'] ?? '');
    return view('home');
});
