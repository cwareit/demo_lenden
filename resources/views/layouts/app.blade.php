<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <!-- Scripts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>



    <div id="app">
        @include('includes.navbar')

        <main class="py-4">

        <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">


@if(Session::has('pass'))
        <div class="alert alert-success alert-dismissible fade show fw-bold border-0" role="alert">
{{session('pass')}}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elseif(Session::has('fail'))


@endif


            <div class="card border-0 ">
                <div class="card-header fw-bold bg-warning border-0">
                    @yield('card-header')
                
                <span class=" float-end">
                        @yield('sub-links')
</span>
                </div>

                <div class="card-body border-bottom border-warning">

                @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>





 
        </main>
    </div>
</body>
</html>
