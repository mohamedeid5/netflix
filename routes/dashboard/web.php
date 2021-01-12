<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::prefix('dashboard')
		   ->name('dashboard.')
		   ->middleware(['auth', 'role:Superadmin'])
		   ->group(function() {

		// welcome routes

		Route::get('/', 'WelcomeController@index')->name('welcome');

        // resources routes

		Route::resources([

		    'categories'    => 'CategoryController',
		    'movies'        => 'MovieController',
            'roles'         => 'RoleController',
            'users'         => 'UserController'
        ]);


        // settings route

        Route::get('settings/social-login', 'SettingController@social_login')->name('settings.social_login');

        Route::get('settings/social-links', 'SettingController@social_links')->name('settings.social_links');

        Route::post('settings', 'SettingController@store')->name('settings.store');


        Route::get('/test', function() {

            echo Storage::url('images');

        }); // end /test route


	});
