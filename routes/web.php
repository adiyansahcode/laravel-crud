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

Route::get('/home', 'HomeController@index')->name('home.index');
Route::redirect('/', '/home');

Route::resources(
    [
        'book' => 'BookController',
        'publisher' => 'PublisherController',
    ]
);

Route::get('/book/author/select', 'BookController@authorSelectData')->name('author.select');
Route::get('/book/publisher/select', 'BookController@publisherSelectData')->name('publisher.select');
Route::get('/book/language/select', 'BookController@languageSelectData')->name('language.select');
Route::get('/book/category/select', 'BookController@categorySelectData')->name('category.select');
