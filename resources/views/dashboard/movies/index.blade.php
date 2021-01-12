@extends('layouts.dashboard.app')

@section('title')
	Movies
@endsection

@section('content')


<h2>Movies</h2>
 <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Movies</li>
    {{-- <li class="breadcrumb-item active" aria-current="page">Data</li> --}}
  </ol>
</nav>

<div class="tile mb-4">
	<div class="row">

		<div class="col-12">
			<form action="" method="">
				<div class="row">

					<div class="col-md-4">
						<div class="form-group">
							<input type="text" name="search" autofocus value="{{ request('search') }}" class="form-control" placeholder="serach">
						</div>
					</div> <!-- end of col -->

                    <div class="col-md-4">
                        <select class="form-control" name="category">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == request()->category ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div> <!-- end of col -->

					<div class="col-md-4">
						<button type="submit" class="btn btn-info">search</button>
						@if(auth()->user()->hasPermission('create-movies'))
						<a href="{{ route('dashboard.movies.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>Add Movie</a>
						@endif
					</div> <!-- end of col -->


				</div> <!-- end of row -->
			</form> <!-- end of form -->
		</div> <!-- end of col-12 -->

	</div> <!-- end of row -->

	<div class="row">
		<div class="col-md-12">
			@if($movies->count() == 0)

				<h3 style="font-weight: 400">there's no movies</h3>

			@else
				<table class="table table-hover">
				<thead>
					<tr>
                        <th>
                            <input type="checkbox" name="" id="select_all">
                        </th>
						<th>#</th>
						<th>name</th>
						<th>description</th>
						<th>views</th>
                        <th>categories</th>
						<th>rate</th>
						<th>year</th>
						<th>updated At</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>

                        @foreach($movies as $movie)
                            <tr>
                                <td>
                                    <input type="checkbox" name="delete_all[]">
                                </td>
                                <td>{{ $movie->id }}</td>
                                <td>{{ $movie->name }}</td>
                                <td>{{ Str::limit($movie->description, 20) }}</td>
                                <td>{{ $movie->views }}</td>
                                <td>
                                    @foreach($movie->categories as $category)
                                        <h5 style="display: inline-block;"><span class="badge badge-primary">{{ $category->name }}</span></h5>
                                    @endforeach
                                </td>
                                <td>{{ $movie->rate }}</td>
                                <td>{{ $movie->year }}</td>
                                <td>{{ $movie->updated_at }}</td>
                                <td>
                                    @if(auth()->user()->hasPermission('update-movies'))
                                   <a class="btn btn-sm btn-info" href="{{ route('dashboard.movies.edit', $movie->id) }}">Edit</a>
                                    @endif
                                    @if(auth()->user()->hasPermission('delete-movies'))
                                    <form action="{{ route('dashboard.movies.destroy', $movie->id) }}" method="post" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash" ></i>Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

				</tbody>
			</table>

			{{ $movies->appends(request()->query())->links() }}
			@endif
		</div>
	</div>

</div> <!-- end of tile -->


@endsection
