<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use App\Jobs\StreamMovie;
use Illuminate\Http\Request;
use App\Movie;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MovieController extends Controller

{

    public function __construct()
    {
        $this->middleware('permission:read-movies')->only('index');
        $this->middleware('permission:create-movies')->only(['create', 'store']);
        $this->middleware('permission:update-movies')->only(['edit', 'update']);
        $this->middleware('permission:delete-movies')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = Category::all();

        $movies = Movie::whenSearch(request()->search)
               // ->with('permissions')
               // ->withCount('users')
                  ->with('categories')
                  ->whenCategory(request()->category)
                  ->paginate(5);

        return view('dashboard.movies.index', compact('movies', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::all();

        $movie = Movie::create([]);

        return view('dashboard.movies.create', compact('movie', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $movie = Movie::findOrFail($request->movie_id);
        $movie->update([
            'name' => $request->name,
            'path' => $request->file('movie')->store('movies'),
        ]);

      //  $this->dispatch(new StreamMovie($movie));
        StreamMovie::dispatch($movie);

        return $movie;
    }

    /**
     * Display the specified resource.
     *
     * @param Movie $movie
     * @return Movie
     */
    public function show(Movie $movie)
    {
       return $movie;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $movie = Movie::find($id);

        $categories = Category::all();

        return view('dashboard.movies.edit', compact('movie', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {

        $data = $request->validate([
            'name'        => 'required|unique:movies,name,' . $movie->id,
            'description' => 'required|min:3',
            'images'      => 'sometimes',
            'poster'      => 'sometimes|image',
            'rate'        => 'sometimes',
            'year'        => 'sometimes'
        ]);

        if($request->poster)
        {
            $this->deletePreviousImage('poster', $movie);

            $poster = Image::make($request->poster)
                            ->resize(255, 378)
                            ->encode();

            Storage::disk('local')->put('public/images/' . $request->poster->hashName(), (string)$poster, 'public');

            $data['poster'] = $request->poster->hashName();

        }

        if($request->images)
        {

            $this->deletePreviousImage('image', $movie);

            $image = Image::make($request->images)
                ->encode('',50);
            Storage::disk('local')->put('public/images/' . $request->images->hashName(), (string)$image, 'public');

            $data['images'] = $request->images->hashName();
        }

        $movie->update($data);

        $movie->categories()->sync($request->categories);

        session()->flash('success', 'movie updated successfully');

        return redirect()->route('dashboard.movies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Movie $movie
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Movie $movie)
    {

        Storage::disk('local')->delete('public/images/' . $movie->poster);
        Storage::disk('local')->delete('public/images/' . $movie->image);
        Storage::disk('local')->delete($movie->path);


        Storage::disk('local')->deleteDirectory('public/movies/' . $movie->id);

        $movie->delete();
        session()->flash('success', 'movie deleted successfully');
        return redirect()->route('dashboard.movies.index');
    }

    private function deletePreviousImage($image_type, $movie)
    {
        if($image_type == 'poster') {

            Storage::disk('local')->delete('public/images/' . $movie->poster);

            return false;
        }

        Storage::disk('local')->delete('public/images/' . $movie->image);

    }
}
