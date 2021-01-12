@extends('layouts.dashboard.app')

@section('title')
	Edit Movie
@endsection

@section('content')


	<h2>Edit Movie</h2>
	 <nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
	    <li class="breadcrumb-item"><a href="{{ route('dashboard.movies.index') }}">Movies</a></li>
	    <li class="breadcrumb-item active" aria-current="page">Edit Movie</li>
	  </ol>
	</nav>

	<div class="tile md-4">

		<div class="row">

			<div class="col-md-6">

                <form
                    id="movie_properties"
                    action="{{ route('dashboard.movies.update', $movie->id) }}"
                    method="post"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('put')
                    @include('dashboard.partials.errors')


                    {{-- name --}}

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="movie_name" value="{{ old('name', $movie->name) }}" class="form-control" >
                    </div>

                    {{-- description --}}

                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" value="{{ old('description', $movie->description) }}" class="form-control">
                    </div>

                    {{-- poster --}}

                    <div class="form-group">
                        <label>Poster</label>
                        <input type="file" name="poster" value="{{ old('poster') }}" class="form-control">
                        <img src="{{ $movie->poster_path }}" style="width: 255px; height: 378px" alt="">
                    </div>

                    {{-- image --}}

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="images" value="{{ old('image') }}" class="form-control" multiple>
                        <img src="{{ $movie->image_path }}" style="width: 255px; height: 378px" alt="">
                    </div>

                    {{-- categories --}}
                    <div class="form-group">
                        <label for="">Categories</label>
                        <select name="categories[]" id="" multiple class="form-control">

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ in_array($category->id, old('categories', $movie->categories->pluck('id')->toArray())) ? 'selected' : ''}}
                                >
                                    {{ $category->name  }}
                                </option>

                            @endforeach

                        </select>
                    </div>


                    {{-- year --}}

                    <div class="form-group">
                        <label>Year</label>
                        <input type="text" name="year" value="{{ old('year', $movie->year) }}" class="form-control">
                    </div>

                    {{-- rate --}}

                    <div class="form-group">
                        <label>Rate</label>
                        <input type="number" value="{{ old('rate', $movie->rate) }}" min="1" max="5" name="rate" class="form-control">
                    </div>

                    <div class="form-group">
                        <button type="submit" id="movie-submit-btn" class="btn btn-info">Publish</button>
                    </div>
                </form>

			</div>

		</div>

	</div>

@endsection
