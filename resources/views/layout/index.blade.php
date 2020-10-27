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
                <li><a href="{{url('/')}}"><i class=" large material-icons">home</i></a></li>
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
                @if(count(Auth::user()->stationsSuscribed) > 0)
                <li>
                    <a class='dropdown-trigger nav-link' href='#' data-target='dropdownNoti'><i
                            class="material-icons">notifications</i>
                    </a>
                </li>
                <ul id="dropdownNoti" class="dropdown-content">
                    <table class="responsive-table striped" style="padding: 0px; margin:0px;">
                        <tbody>
                            <tr>
                                <td colspan="3" class="center">
                                    <h5><strong>Notificaciones</strong></h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="http://localhost:8000/storage/e38qbMsvTpyi9QLvxWhfJcYOuAAtFMTgzGhqRL7E.jpeg"
                                        alt="" height="60px" width="80px"
                                        style="margin-left: 10px; top: 0px; border-radius: 10px;">
                                </td>
                                <td>
                                    <strong>Invernadero</strong><br>
                                    Temp: 15.0 <br>
                                    Radiación: 20 <br>
                                    Humedad: 30
                                    <a href="#" class="red white-text" style="border-radius: 10px; width: 101px;">No
                                        válidos</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="http://localhost:8000/storage/e38qbMsvTpyi9QLvxWhfJcYOuAAtFMTgzGhqRL7E.jpeg"
                                        alt="" height="60px" width="80px"
                                        style="margin-left: 10px; top: 0px; border-radius: 10px;">
                                </td>
                                <td>
                                    <strong>Invernadero</strong><br>
                                    Temp: 15.0 <br>
                                    Radiación: 20 <br>
                                    Humedad: 30
                                    <a href="#" class="green white-text"
                                        style="border-radius: 10px; width: 95px;">Correctos</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="http://localhost:8000/storage/e38qbMsvTpyi9QLvxWhfJcYOuAAtFMTgzGhqRL7E.jpeg"
                                        alt="" height="60px" width="80px"
                                        style="margin-left: 10px; top: 0px; border-radius: 10px;">
                                </td>
                                <td>
                                    <strong>Invernadero</strong><br>
                                    Temp: 15.0 <br>
                                    Radiación: 20 <br>
                                    Humedad: 30
                                    <a href="#" class="green white-text"
                                        style="border-radius: 10px; width: 95px;">Correctos</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    </a>
                </ul>
                <li>
                    <a class="nav-link" href="{{ url('/admin') }}"><i class="material-icons">settings</i>
                    </a>
                </li>
                @endif
                <li>

                    <a class='dropdown-trigger nav-link' href='#' data-target='dropdown1'><i
                            class="material-icons">arrow_drop_down</i> </a>
                </li>
                <ul id='dropdown1' class='dropdown-content'>
                    <li><a class="black-text" href="{{url('/nosotros')}}"><i
                                class="material-icons">people</i>Nosotros</a>
                    </li>
                    <li>
                        <a class="nav-link black-text" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                            <i class="material-icons">arrow_back</i> Cerrar sesión
                        </a>
                    </li>
                </ul>
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
                <li><a href="{{route('login')}}"><i class="material-icons">arrow_forward</i>Iniciar sesión</a></li>
                <li class="divider"></li>
                <li><a href="{{url('/')}}"><i class="material-icons">home</i>Inicio</a></li>
                <li><a href="{{url('/nosotros')}}"><i class="material-icons">people</i>Nosotros</a></li>
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
                <li><a href="{{url('/')}}"><i class="material-icons">home</i>Inicio</a></li>
                <li><a href="{{url('/nosotros')}}"><i class="material-icons">people</i>Nosotros</a></li>
                @if(count(Auth::user()->stationsSuscribed) > 0)
                <li class="divider"></li>
                <li><a href="{{url('/admin')}}"><i class="material-icons">settings</i>Administración</a></li>
                @endif
                <li>
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="material-icons">arrow_back</i>Cerrar sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
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
