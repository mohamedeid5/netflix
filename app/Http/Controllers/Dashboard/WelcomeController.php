<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Movie;
use App\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index() {

       // dd(auth()->user()->roles);

        $users_count  = User::whereRole('user')->count();
        $movies_count = Movie::count();
        $categories_count = Category::count();

    	return view('dashboard.welcome', compact('users_count', 'movies_count', 'categories_count'));
    }
}
