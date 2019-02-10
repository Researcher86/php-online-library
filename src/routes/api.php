<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('genres', 'GenresController@getAll');
Route::get('books', 'BooksController@index');
Route::get('books/genres/{id}', 'BooksController@getBooksByGenre');
Route::get('books/{id}', 'BooksController@show');
Route::post('books/{bookId}/rating/{rating}', 'BooksController@addRating');
//Route::post('article', 'ArticleController@store');
//Route::put('article', 'ArticleController@store');
//Route::delete('article/{id}', 'ArticleController@destroy');