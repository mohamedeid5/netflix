@extends('layouts.dashboard.app')

@section('title')
	Add User
@endsection

@section('content')


	<h2>Add User</h2>
	 <nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
	    <li class="breadcrumb-item"><a href="{{ route('dashboard.users.index') }}">Users</a></li>
	    <li class="breadcrumb-item active" aria-current="page">Add User</li>
	  </ol>
	</nav>

	<div class="tile md-4">

		<div class="row">

			<div class="col-md-6">

				<form action="{{ route('dashboard.users.store') }}" method="post">
					@csrf
					@method('post')
					@include('dashboard.partials.errors')
				
					{{-- name --}}

					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" value="{{ old('name') }}">
					</div>

					{{-- email --}}

					<div class="form-group">
							<label>Email</label>
						<input type="text" name="email" class="form-control" value="{{ old('email') }}">
					</div>	

					{{-- password --}}

					<div class="form-group">
							<label>Password</label>
						<input type="password" name="password" class="form-control">
					</div>

					{{-- password confirmation --}}

					<div class="form-group">
							<label>Password Confirmation</label>
						<input type="password" name="password_confirmation" class="form-control">
					</div>			

					{{-- roles --}}	

					<div class="form-group">
						<label>Roles</label>
						<select name="role_id" class="form-control">
							<option></option>
							@foreach($roles as $role)

								<option value="{{ $role->id }}" {{ $role->id == old('role_id') ? 'selected' : '' }}>{{ $role->name }}</option>

							@endforeach
						</select>
					</div>	

					<div class="form-group">
						<button type="submit" class="btn btn-info">Add</button>
					</div>
				</form>

			</div>

		</div>

	</div>

@endsection