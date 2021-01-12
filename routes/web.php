<?php

use Illuminate\Support\Facades\Auth;

// home route
Route::get('/', 'WelcomeController@index')->name('welcome');


// movies routes
Route::resource('movies', 'MovieController')->only(['show', 'index']);
Route::post('movies/{movie}/increment_views', 'MovieController@increment_movies')->name('movies.increment');
Route::post('movies/{movie}/toggle_favorite', 'MovieController@toggleFavorite')->name('movies.toggle_favorite');

//auth routes
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('test', function (){

    dd(setting('Facebook_link'));
});


// social login routes
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->where('provider', 'facebook|google');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->where('provider', 'facebook|google');


