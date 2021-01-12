@extends('layouts.dashboard.app')

@section('title')
    Social Login
@endsection

@section('content')


    <h2>Settings</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Social Settings</li>
        </ol>
    </nav>

    <div class="tile md-4">

        <div class="row">

            <div class="col-md-6">

                <form action="{{ route('dashboard.settings.store') }}" method="post">
                    @csrf
                    @method('post')
                    @include('dashboard.partials.errors')

                    @php
                        $social_sites = ['Facebook', 'Google'];
                    @endphp

                    @foreach($social_sites as $social_site)
                        {{-- client id --}}

                        <div class="form-group">
                            <label>{{ $social_site }} client id</label>
                            <input type="text" name="{{$social_site}}_client_id" class="form-control" value="{{ setting($social_site.'_client_id') }}">
                        </div>

                        {{-- client secret --}}

                        <div class="form-group">
                            <label>{{ $social_site }} client secret</label>
                            <input type="text" name="{{$social_site}}_client_secret" class="form-control" value="{{ setting($social_site.'_client_secret') }}">
                        </div>

                        {{-- redirect url --}}

                        <div class="form-group">
                            <label>{{ $social_site }} redirect url</label>
                            <input type="text" name="{{$social_site}}_redirect_url" class="form-control" value="{{ setting($social_site.'_redirect_url') }}">
                        </div>

                    @endforeach

                    <div class="form-group">
                        <button type="submit" class="btn btn-info">Add</button>
                    </div>
                </form>

            </div>

        </div>

    </div>

@endsection
