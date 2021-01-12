<nav class="navbar navbar-expand-lg navbar-dark fixed-top">

    <div class="container">

        <a class="navbar-brand" href="{{ route('welcome') }}">Netflix<span class="text-primary font-weight-bold">ify</span></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <form action="" class="col-12 col-md-6 p-0 mt-1">
                <div class="input-group">
                    <input type="search" class="form-control bg-transparent border-0" placeholder="Search for your favorite movies" aria-label="Search for your favorite movies" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-white border-0" id="basic-addon2"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </form><!-- end of form -->

            <ul class="navbar-nav ml-auto">
                @auth

                    <li class="nav-item">
                        <a href="{{ route('movies.index', ['favorites' => 1]) }}" class="nav-link text-white" style="position:relative;">
                            <i class="fa fa-heart"></i>
                            <span class="bg-primary text-white flex justify-content-center align-items-center"
                                style="position: absolute; top: 0; right: -15px;width: 30px; height: 20px; border-radius: 50px;"
                                  id="fav-count"
                                  data-fav-count="{{ auth()->user()->movies_count }}"
                            >
                                {{ auth()->user()->movies_count > 9 ? '9+' : auth()->user()->movies_count }}
                            </span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle  text-white" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </a>

                        <div class="dropdown-menu">
                            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Superadmin'))
                            <a class="dropdown-item" id="logout" href="{{ route('dashboard.welcome') }}">
                                Dashboard
                            </a>
                            @endif
                            <div role="separator" class="dropdown-divider"></div>
                            <a class="dropdown-item" id="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>logout
                                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                    @csrf
                                </form>
                            </a>
                        </div>
                    </li>

                @else
                    <a href="{{ route('login') }}" class="btn btn-primary mb-2 mb-md-0 mr-0 mr-md-2">Login</a>
                    <a href="{{ route('register')  }}" class="btn btn-outline-light">Register</a>
                @endauth
            </ul>

        </div><!-- end of collapse -->

    </div><!-- end of container fluid-->

</nav><!-- end of nav -->
