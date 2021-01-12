@extends('layouts.app')

@section('content')

    <section id="banner">

        @include('layouts._nav')

        <div class="movies owl-carousel owl-theme">

            @foreach($latest_movies as $movie)

                <div class="movie text-white d-flex justify-content-center align-items-center">

                    <div class="movie__bg" style="background: linear-gradient(rgba(0,0,0, 0.6), rgba(0,0,0, 0.6)), url('{{ $movie->poster_path }}') center/cover no-repeat;"></div>

                    <div class="container">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="d-flex justify-content-between">
                                    <h1 class="movie__name fw-300">{{ $movie->name }}</h1>
                                    <span class="movie__year align-self-center">{{ $movie->year }}</span>
                                </div>

                                <div class="d-flex movie__rating my-1">
                                    <div class="d-flex">

                                        @for($i = 0;$i < $movie->rate;$i++)
                                            <span class="fa fa-star text-primary mr-2"></span>
                                        @endfor

                                    </div>
                                    <span class="align-self-center">{{ $movie->rate }}</span>
                                </div>

                                <p class="movie__description my-2">{{ $movie->description }}</p>

                                <div class="movie__cta my-4">
                                    <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-primary text-capitalize mr-0 mr-md-2">
                                        <span class="fa fa-play"></span>
                                        watch now
                                    </a>
                                 @auth()
                                    <button  class="btn btn-outline-light text-capitalizefar ">
                                        <span class="far fa-heart {{ $movie->is_favored ? 'fw-900' : '' }} movie-{{ $movie->id }} movie__fav-button"
                                              data-url="{{ route('movies.toggle_favorite', $movie->id) }}"
                                              data-movie-id="{{ $movie->id }}"
                                        >

                                        </span>
                                        add to favorite
                                    </button>
                                 @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-light text-capitalize"><span class="fa fa-heart"></span> add to favorite</a>
                                 @endauth
                                </div>
                            </div><!-- end of col -->

                            <div class="col-6 mt-2 mx-auto col-md-4 col-lg-3  ml-md-auto mr-md-0">
                                <img src="{{ $movie->poster_path }}" class="img-fluid" alt="">
                            </div>
                        </div><!-- end of row -->

                    </div><!-- end of container -->

                </div><!-- end of movie -->
            @endforeach

        </div><!-- end of movies -->

    </section><!-- end of banner section-->

    <section class="listing py-2">

        <div class="container">

            @foreach($categories as $category)

            <div class="row my-4">
                <div class="col-12 d-flex justify-content-between">
                    <h3 class="listing__title text-white fw-300">{{ $category->name }}</h3>
                    <a href="{{ route('movies.index', ['category_name' => $category->name]) }}" class="align-self-center text-capitalize text-primary">see all</a>
                </div>
            </div><!-- end of row -->




            <div class="movies owl-carousel owl-theme">

                @foreach($category->movies as $movie)

                <div class="movie p-0">
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

            </div><!-- end of row -->



            @endforeach

        </div><!-- end of container -->

    </section><!-- end of listing section -->



    @include('layouts._footer')

@endsection
