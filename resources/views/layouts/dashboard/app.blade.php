<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title> Dashboard | @yield('title', 'Dashboard') </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_files/css/main.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- noty --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/noty/noty.css') }}">
    <script type="text/javascript" src="{{ asset('plugins/noty/noty.min.js') }}"></script>

      @stack('css')

  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->

   @include('layouts.dashboard._header')

    <!-- Sidebar menu-->
    @include('layouts.dashboard._aside')
    <main class="app-content">
      @yield('content')
      @include('dashboard.partials.session')

    </main>
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset("dashboard_files/js/jquery-3.3.1.min.js") }}"></script>
    <script src="{{ asset("dashboard_files/js/popper.min.js") }}"></script>
    <script src="{{ asset("dashboard_files/js/bootstrap.min.js") }}"></script>
    <script src="{{ asset("dashboard_files/js/main.js") }}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('dashboard_files/js/plugins/pace.min.js') }}"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="{{ asset('dashboard_files/js/plugins/chart.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dashboard_files/js/custom/movie.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    </script>

    <script type="text/javascript">
      $(document).ready(function(){
        $(document).on('click', '.delete', function(e) {
          e.preventDefault();

          var that = $(this);

            var n = new Noty({
                text: 'confirm deleting category',
                killer: true,
                buttons: [
                  Noty.button('Yes', 'btn btn-success', function() {
                      that.closest('form').submit();
                  }),

                  Noty.button('No', 'btn btn-danger', function() {
                    n.close();
                  })
                ]
            });

            n.show();
        });
      });
    </script>

  </body>
</html>
