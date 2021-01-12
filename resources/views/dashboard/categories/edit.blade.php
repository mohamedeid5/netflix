@extends('layouts.dashboard.app')

@section('title')
	Edit Category
@endsection

@section('content')


	<h2>Edit Category</h2>
	 <nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
	    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Categories</a></li>
	    <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
	  </ol>
	</nav>

	<div class="tile md-4">
		<div class="row">
			<div class="col-md-6">
				<form action="{{ route('dashboard.categories.update', $category->id) }}" method="post">
					@csrf
					@method('put')
					@include('dashboard.partials.errors')
				
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-info">update</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection