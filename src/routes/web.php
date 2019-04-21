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
use App\Events\SendEmailEvent;
use App\Events\SendSmsEvent;
use App\Models\Book\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Auth::routes();

//Route::get('/', function () {
//    return view('home');
//});

Route::get('/', 'HomeController@index');
Route::get('books', 'Book\BooksController@search');
Route::get('books/genres/{id}', 'Book\BooksController@getBooksByGenre');
Route::get('books/{id}', 'Book\BooksController@show');
Route::post('books/{bookId}/rating/{rating}', 'Book\BooksController@addRating');
//Route::post('article', 'ArticleController@store');
//Route::put('article', 'ArticleController@store');
//Route::delete('article/{id}', 'ArticleController@destroy');