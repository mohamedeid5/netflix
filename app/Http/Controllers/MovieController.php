<?php

namespace App\Http\Controllers;

use App\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{

    public function index()
    {

        $movies = Movie::whenCategory(request()->category_name)->whenFavorite(request()->favorites)->paginate(10);

        return view('movies.index', compact('movies'));

    } // end of index

    public function show(Movie $movie)
    {
        $related_movies = Movie::where('id', '!=', $movie->id)
            ->whereHas('categories', function($query) use ($movie) {
                return $query->whereIn('category_id', $movie->categories->pluck('id')->toArray());
            })->get();

        return view('movies.show', compact('movie', 'related_movies'));
    } // end of show


    public function increment_movies(Movie $movie)
    {
        $movie->increment('views', 1);

    } // end increment_movies

    public function toggleFavorite(Movie $movie)
    {
        if($movie->is_favored)
        {
            $movie->users()->detach(auth()->user()->id);
        } else {

            $movie->users()->attach(auth()->user()->id);
        }
    } // end toggle favorite

}
