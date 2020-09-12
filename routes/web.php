<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

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
    return view('home');
})->name('home');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::redirect('/', '/home');

Route::resources([
    'book' => 'BookController',
]);

Route::get('/book/author/select', 'BookController@authorSelectData')->name('author.select');
Route::get('/book/publisher/select', 'BookController@publisherSelectData')->name('publisher.select');
Route::get('/book/language/select', 'BookController@languageSelectData')->name('language.select');
Route::get('/book/category/select', 'BookController@categorySelectData')->name('category.select');

// Route::get('/book/list', 'BookController@index')->name('book.list');
// Route::post('/book/list-data-json', 'BookController@listDatajson')->name('book.list.json');
// Route::get('/book/show/{id}', 'BookController@index')->name('book.show')->where('id', '[0-9]+');
// Route::get('/book/create', 'BookController@create')->name('book.create');
// Route::post('/book/store', 'BookController@store')->name('book.store');
// Route::get('/book/edit/{id}', 'BookController@edit')->name('book.edit')->where('id', '[0-9]+');
// Route::put('/book/update/{id}', 'BookController@update')->name('book.update')->where('id', '[0-9]+');
// Route::delete('/book/delete/{id}', 'BookController@destroy')->name('book.delete')->where('id', '[0-9]+');
