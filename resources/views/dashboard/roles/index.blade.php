@extends('layouts.dashboard.app')

@section('title')
	Roles
@endsection

@section('content')


<h2>Roles</h2>
 <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Roles</li>
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
						<button type="submit" class="btn btn-info">search</button>
						@if(auth()->user()->hasPermission('create-roles'))
						<a href="{{ route('dashboard.roles.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>Add Role</a>
						@endif
					</div> <!-- end of col -->

				</div> <!-- end of row -->
			</form> <!-- end of form -->
		</div> <!-- end of col-12 -->

	</div> <!-- end of row -->

	<div class="row">
		<div class="col-md-12">
			@if($roles->count() == 0)

				<h3 style="font-weight: 400">there's no caregories</h3>

			@else
				<table class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>name</th>
						<th>Permissions</th>
						<th>Count</th>
						<th>Created At</th>
						<th>Edited At</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					@foreach($roles as $role)
						<tr>
							<td>{{ $role->id }}</td>
							<td>{{ $role->name }}</td>
							<td>
								@foreach($role->permissions as $permission)

								<h5 style="display: inline-block;"><span class="badge badge-primary">{{ $permission->name }}</span></h5>

								@endforeach
							</td>
							<td>{{ $role->users_count }}</td>
							<td>{{ $role->created_at }}</td>
							<td>{{ $role->updated_at }}</td>
							<td>
								@if(auth()->user()->hasPermission('update-roles'))
									<a class="btn btn-primary btn-sm" href="{{ route('dashboard.roles.edit', $role->id) }}">
										<i class="fa fa-edit"></i>
										Edit
									</a>
								@endif
								@if(auth()->user()->hasPermission('delete-roles'))
								<form action="{{ route('dashboard.roles.destroy', $role->id) }}" method="post" style="display: inline-block;">
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

			{{ $roles->appends(request()->query())->links() }}
			@endif
		</div>
	</div>

</div> <!-- end of tile -->


@endsection