@extends('layouts.app')

@section('content')

    <section class="listing text-white" style="height: 100vh;padding: 7% 0;">

        @include('layouts._nav')

        <div class="container">

            <div class="row">

                <div class="col">

                    <h2 class="fw-300">{{ request('category_name') ?? 'Favorite Movies'  }}</h2>

                </div>

            </div> <!-- end of row -->

            <div class="row my-3">

                @foreach($movies as $movie)

                <div class="movie p-0 col-md-3">
                    <img src="{{ $movie->poster_path }}" class="img-fluid" alt="">

                    <div class="movie__details text-white">

                        <div class="d-flex justify-content-between">
                            <p class="mb-0 movie__name">{{ $movie->name }}</p>
                            <p class="mb-0 movie__year align-self-center">{{ $movie->year }}</p>
                        </div>

                        <div class="d-flex movie__rating">
                            <div class="mr-2">
                                <i class="fa fa-star text-primary mr-1"></i>
                                <i class="fa fa-star text-primary mr-1"></i>
                                <i class="fa fa-star text-primary mr-1"></i>
                                <i class="fa fa-star text-primary mr-1"></i>
                            </div>
                            <span>4.7</span>
                        </div>

                        <div class="movie___views">
                            <p>Views: {{ $movie->views }}</p>
                        </div>

                        <div class="d-flex movie__cta">
                            <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-primary text-capitalize flex-fill mr-2"><i class="fa fa-play"></i> watch now</a>
                            @auth()
                                <i class="far fa-heart {{ $movie->is_favored ? 'fw-900' : '' }} fa-1x align-self-center movie__fav-button movie-{{ $movie->id }}"
                                   data-url="{{ route('movies.toggle_favorite', $movie->id) }}"
                                   data-movie-id="{{ $movie->id }}"
                                >

                                </i>
                            @else
                                <a href="{{ route('login') }}"><i class="far fa-heart fa-1x align-self-center movie__fav-button"></i></a>
                            @endauth
                        </div>

                    </div><!-- end of movie details -->

                </div><!-- end of col -->

                @endforeach

            </div> <!-- end of row -->

        </div> <!-- end of container -->

    </section> <!-- end of section -->

@endsection
