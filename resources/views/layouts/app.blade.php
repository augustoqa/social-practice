<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ Auth::user() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <title>SocialApp</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-socialapp">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fa-solid fa-address-book text-primary mr-1"></i>
                SocialApp
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
{{--                    <li class="nav-item active">--}}
{{--                        <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="#">Link</a>--}}
{{--                    </li>--}}
                </ul>
                <ul class="navbar-nav ml-auto">
                    @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                    </li>
                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="document.getElementById('logout').submit()">Cerrar sesión</a>
                        </div>
                    </li>
                    <form method="post" action="{{ route('logout') }}" id="logout">
                        @csrf
                    </form>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main id="app" class="py-4">
        @yield('content')
    </main>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
