@extends('layouts.dashboard.app')

@section('title')
	Add Movie
@endsection

@push('css')

    <style>
        #movie-upload-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 25vh;
            flex-direction: column;
        }
    </style>

@endpush

@section('content')


	<h2>Add Movie</h2>
	 <nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
	    <li class="breadcrumb-item"><a href="{{ route('dashboard.movies.index') }}">Movies</a></li>
	    <li class="breadcrumb-item active" aria-current="page">Add Movie</li>
	  </ol>
	</nav>

    <div class="row">

        <div class="col-md-12">

            <div class="tile md-4">

                <div
                     id="movie-upload-wrapper"
                     style="height:25vh; border: 1px solid black; cursor: pointer;display: {{ $errors->any() ? 'none' : 'flex' }}"
                     onclick="document.getElementById('input-file').click()">

                    <i class="fa fa-video-camera fa-2x"></i>
                    <p>upload</p>
                </div>

                <input type="file"
                       name=""
                       data-movie-id="{{ $movie->id }}"
                       data-url="{{ route('dashboard.movies.store') }}"
                       id="input-file"
                       style="display: none">

				<form
                    id="movie_properties"
                    action="{{ route('dashboard.movies.update', $movie->id) }}"
                    method="post" style="display: {{ $errors->any() ? 'block' : 'none' }}"
                    enctype="multipart/form-data"
                >
					@csrf
					@method('put')
					@include('dashboard.partials.errors')



                    {{-- progress bar --}}

                    <label id="movie-upload-text" style="display: {{ $errors->any() ? 'none' : 'block' }}">Uploading</label>
                    <div class="form-group" style="display: {{ $errors->any() ? 'none' : 'block' }}">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" id="movie-upload-progress">

                            </div>
                        </div>
                    </div>

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
                        <input type="file" name="poster" class="form-control">
                    </div>

                    {{-- image --}}

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="images" value="{{ old('images') }}" multiple class="form-control">
                    </div>


                    {{-- categories --}}
                    <div class="form-group">
                        <label for="">Categories</label>
                        <select name="categories[]" id="" multiple class="form-control">

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ in_array($category->id, old('categories', [])) ? 'selected' : ''}}
                                >
                                    {{ $category->name  }}
                                </option>

                            @endforeach

                        </select>
                    </div>


                    {{-- year --}}

                    <div class="form-group">
                        <label>Year</label>
                        <input type="text" name="year" value="{{ old('year') }}" class="form-control">
                    </div>

                    {{-- rate --}}

                    <div class="form-group">
                        <label>Rate</label>
                        <input type="number" value="{{ old('rate') }}" min="1" max="5" name="rate" class="form-control">
                    </div>

                    <div class="form-group">
						<button type="submit" id="movie-submit-btn" style="display: {{ $errors->any() ? 'block' : 'none' }}" class="btn btn-info">Publish</button>
					</div>
				</form>

			</div>

		</div>

	</div>

@endsection
