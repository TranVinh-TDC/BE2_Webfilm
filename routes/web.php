<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
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


//User
Route::middleware('auth')->group(function () {
    Route::put('/users/update-profile', 'UserController@update')->name('users.update-profile');
});
//Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/categories', 'CategoryController');
    Route::resource('/films', 'FilmController');
    Route::get('/trash-films', 'FilmController@trash_film')->name('films.trash');
    Route::put('/restore-films/{id}', 'FilmController@restore')->name('films.restore');
    Route::get('/users/profile', 'UserController@edit')->name('users.edit-profile');
    Route::resource('/types', 'TypeController');
    Route::resource('/nations', 'NationController');
    Route::resource('/links', 'LinktrailerController');
    Route::resource('/casts', 'CastController');
    Route::resource('/images', 'ImageController');
    Route::get('/users', 'UserController@index')->name('users.index');
    Route::post('/make-admin/{id}', 'UserController@makeAdmin')->name('make-admin');
    ///////Search
    Route::get('/search/film', 'SearchController@search_film')->name('search.films');
    Route::get('/search/user', 'SearchController@search_user')->name('search.users');
    Route::get('/search/type', 'SearchController@search_types')->name('search.types');
    Route::get('/search/nation', 'SearchController@search_nation')->name('search.nations');
    Route::get('/search/link', 'SearchController@search_link')->name('search.links');
    Route::get('/search/image', 'SearchController@search_image')->name('search.images');
    Route::get('/search/category', 'SearchController@search_categories')->name('search.categories');
    Route::get('/search/cast', 'SearchController@search_cast')->name('search.casts');
}); 

//login facebook, google.
Route::prefix('login')->group(function () {
    Route::get('/google', [App\Http\Controllers\Auth\LoginController::class, 'redirecToGoogle'])->name('login.google');
    Route::get('/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);

    Route::get('/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirecTofacebook'])->name('login.facebook');
    Route::get('/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback']);
});

//user not login
//---------------------------------------------------------------------------------
Route::get('/', 'MovieController@index')->name('movies.index');
Route::get('/movies/{id}', 'MovieController@show')->name('movies.show');

/////home login
Auth::routes(["verify" => true]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

///Actor
Route::get('/actors', 'ActorsController@index')->name('actors.index');
Route::get('/actors/page/{page?}', 'ActorsController@index');

Route::get('/actors/{id}', 'ActorsController@show')->name('actors.show');
///TV show

Route::get('/tv', 'TvController@index')->name('tv.index');
Route::get('/tv/{id}', 'TvController@show')->name('tv.show');
//----------------------------------------------------------------------------------