<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@section('header')

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @section('title')
    <title>Nosotros | Invernadero</title>
    @show
    <!-- CSS  -->
    @yield('materialize')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="{{ asset('css/style.css')}}" type="text/css" rel="stylesheet" media="screen,projection" />
    @section('css')
    @show
</head>
@show

<body>
    @section('navbar')
    <nav class="white z-depth-3" role="navigation">
        <div class="nav-wrapper container">
            <a id="logo-container" href="{{url('/')}}" class="brand-logo">Invernadero</a>
            <ul class="right hide-on-med-and-down">
                <li><a href="{{url('/')}}">Inicio</a></li>
                <li><a href="{{url('/nosotros')}}">Nosotros</a></li>
                @guest
                <li>
                    <a class="nav-link navbar-brand" href="{{ route('login') }}">Iniciar sesión</a>
                </li>
                @if (Route::has('register'))
                <li>
                    <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                </li>
                @endif
                @else
                <li>
                    <a class="nav-link" href="{{ url('/admin') }}">Ajustes</a>
                    <ul id='dropdown1' class='dropdown-content'>
                        <li><a href="#!">one</a></li>
                        <li><a href="#!">two</a></li>
                        <li class="divider" tabindex="-1"></li>
                        <li><a href="#!">three</a></li>
                        <li><a href="#!"><i class="material-icons">view_module</i>four</a></li>
                        <li><a href="#!"><i class="material-icons">cloud</i>five</a></li>
                      </ul>
                </li>
                <li>
                    <div aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>

            <ul id="nav-mobile" class="sidenav">
                @guest
                <li>
                    <div class="user-view">
                        <div class="background">
                            <img src="{{asset('imgs/background3.jpg')}}" />
                        </div>
                        <a href="#user"><img class="circle" src="{{asset('imgs/background3.jpg')}}" /></a>
                        <a href="#name"><span class="white-text name"> Invitado</span></a>
                        <a href="#email"><span class="white-text email"> </span></a>
                    </div>
                </li>
                <li><a href="{{route('login')}}">Iniciar sesión</a></li>
                <li class="divider"></li>
                <li><a href="{{url('/')}}">Inicio</a></li>
                <li><a href="{{url('/nosotros')}}">Nosotros</a></li>
                @else
                <li>
                    <div class="user-view">
                        <div class="background">
                            <img src="{{asset('imgs/background3.jpg')}}" />
                        </div>
                        <a href="#user"><img class="circle" src="{{asset('imgs/background3.jpg')}}" /></a>
                        <a href="#name"><span class="white-text name"> {{ Auth::user()->name }}</span></a>
                        <a href="#email"><span class="white-text email"> {{ Auth::user()->email }}</span></a>
                    </div>
                </li>
                <li><a href="{{url('/')}}">Inicio</a></li>
                <li><a href="{{url('/nosotros')}}">Nosotros</a></li>
                <li class="divider"></li>
            <li><a href="{{url('/admin')}}">Ajustes</a></li>
                <div aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </div>
                </li>
                @endguest

            </ul>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
    </nav>
    @show

    @section('content')
    @show

    <!-- Si el contenido no cambia es posible ocupar yield y se manda a llamar desde la vista que hereda con yield('nombre') -->
    @section('footer')
    <footer class="page-footer teal">
        <div class="container">
            <div class="container padding-1 center">
                El Salvador, CA. <br>
                Copyright © 2020. Todos los derechos reservados. <br>
                ITCA-FEPADE.
            </div>
        </div>
    </footer>
    @show

    @yield('materialize-js')
    <!--  Scripts-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src=" {{ asset('js/init.js') }}"></script>
    @section('js')
    @show
</body>

</html>
