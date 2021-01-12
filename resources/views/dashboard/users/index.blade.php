@extends('layouts.dashboard.app')

@section('title')
	Users
@endsection

@section('content')


<h2>Users</h2>
 <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Users</li>
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
						<div class="form-group">
							<select name="role_id" class="form-control">
								<option>All Roles</option>
								@foreach($roles as $role)

								<option value="{{ $role->id }}" {{ $role->id == request()->role_id ? 'selected' : '' }}>{{ $role->name }}</option>

								@endforeach
							</select>
						</div>
					</div> <!-- end of col -->

					<div class="col-md-4">
						<button type="submit" class="btn btn-info">search</button>
						@if(auth()->user()->hasPermission('create-users'))
						<a href="{{ route('dashboard.users.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>Add User</a>
						@endif
					</div> <!-- end of col -->

				</div> <!-- end of row -->
			</form> <!-- end of form -->
		</div> <!-- end of col-12 -->

	</div> <!-- end of row -->

	<div class="row">
		<div class="col-md-12">
			@if($users->count() == 0)

				<h3 style="font-weight: 400">there's no users</h3>

			@else
				<table class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>name</th>
						<th>email</th>
						<th>roles</th>
						<th>Created At</th>
						<th>Edited At</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					@foreach($users as $user)
						<tr>
							<td>{{ $user->id }}</td>
							<td>{{ $user->name }}</td>
							<td>{{ $user->email }}</td>
							<td>
								@foreach($user->roles as $role)

									<h5 style="display: inline-block;"><span class="badge badge-primary">{{ $role->name }}</span></h5>

								@endforeach
							</td>
							<td>{{ $user->created_at }}</td>
							<td>{{ $user->updated_at }}</td>
							<td>
								@if(auth()->user()->hasPermission('update-users'))
									<a class="btn btn-primary btn-sm" href="{{ route('dashboard.users.edit', $user->id) }}">
										<i class="fa fa-edit"></i>
										Edit
									</a>
								@endif
								@if(auth()->user()->hasPermission('delete-users'))
								<form action="{{ route('dashboard.users.destroy', $user->id) }}" method="post" style="display: inline-block;">
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

			{{ $users->appends(request()->query())->links() }}
			@endif
		</div>
	</div>

</div> <!-- end of tile -->


@endsection