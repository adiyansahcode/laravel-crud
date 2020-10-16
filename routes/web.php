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

Route::redirect('/', 'home');

Route::resources([
    'book' => 'BookController',
]);

Route::get('/book/{id}/images', 'BookController@images')->name('book.images')->where('id', '[0-9]+');
Route::put('/book/{id}/images', 'BookController@imagesUpload')->name('book.images.upload')->where('id', '[0-9]+');
Route::get('/book/author/select', 'BookController@authorSelectData')->name('author.select');
Route::get('/book/publisher/select', 'BookController@publisherSelectData')->name('publisher.select');
Route::get('/book/language/select', 'BookController@languageSelectData')->name('language.select');
Route::get('/book/category/select', 'BookController@categorySelectData')->name('category.select');
