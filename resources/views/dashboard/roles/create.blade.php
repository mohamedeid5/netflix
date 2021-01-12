@extends('layouts.dashboard.app')

@section('title')
	Add Role
@endsection

@section('content')


	<h2>Add Role</h2>
	 <nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
	    <li class="breadcrumb-item"><a href="{{ route('dashboard.roles.index') }}">Roles</a></li>
	    <li class="breadcrumb-item active" aria-current="page">Add Role</li>
	  </ol>
	</nav>

	<div class="tile md-4">

		<div class="row">

			<div class="col-md-6">

				<form action="{{ route('dashboard.roles.store') }}" method="post">
					@csrf
					@method('post')
					@include('dashboard.partials.errors')

					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" value="{{ old('name') }}">
					</div>

					<div class="form-group">
						<h4>Permssions</h4>

						<table class="table table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Model</th>
									<th>Permissons</th>
								</tr>
							</thead>

							<tbody>
								@php

                                    // return models
									$models = array_keys(config('laratrust_seeder.role_structure.superadmin'))

								@endphp


								@foreach($models as $index => $model)
									<tr>
										<td>{{ $index+1 }}</td>
										<td>{{ $model }}</td>
										<td>
											@php

												$permission_maps = ['create', 'read', 'update', 'delete'];

											@endphp

                                            @if($model == 'settings')
                                                @php

                                                    $permission_maps = ['create', 'read'];

                                                @endphp
                                            @endif
											<select name="permissions[]" class="form-control select2" multiple>

												@foreach($permission_maps as $permission_map)

													<option value="{{ $permission_map . '-'. $model }}"
                                                        {{ in_array($permission_map . '-'. $model, old('permissions', [])) ? 'selected' : '' }}>
														{{ $permission_map }}
													</option>

												@endforeach

											</select>
										</td>
									</tr>
								@endforeach
							</tbody>

						</table>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-info">Add</button>
					</div>
				</form>

			</div>

		</div>

	</div>

@endsection
