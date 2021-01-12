@extends('layouts.dashboard.app')

@section('title')
	Add Category
@endsection

@section('content')


	<h2>Add Category</h2>
	 <nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
	    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">Categories</a></li>
	    <li class="breadcrumb-item active" aria-current="page">Add Category</li>
	  </ol>
	</nav>

	<div class="tile md-4">
		<div class="row">
			<div class="col-md-6">
				<form action="{{ route('dashboard.categories.store') }}" method="post">
					@csrf
					@method('post')
					@include('dashboard.partials.errors')
				
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" value="{{ old('name') }}">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-info">Add</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection