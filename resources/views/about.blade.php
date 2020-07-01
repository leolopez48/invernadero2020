@extends('layout.index')

@section('title')
<title>Nosotros | Invernadero</title>
@endsection

@yield('materialize')

@section('content')
<div id="index-banner" class="parallax-container">
    <div class="parallax"><img class="responsive-img" src="{{ asset('imgs/Itca.png') }}"
            alt="Unsplashed background img 1">
    </div>
</div>
<div class="container">
    <div class="section">
        <!--   Icon Section   -->
        <div class="row">
            <div class="col s12 m12 center">
                <h1 class="center teal-text">Nosotros</h1>
                <h3 class="left teal-text text-darken-2">ITCA-FEPADE</h5>
            </div>
            <div class="col s12 m12">
                <div class="icon-block center">
                    <h2 class="center teal-text"><i class="material-icons">person</i></h2>
                    <h6 class="center">Ing. Elvis Moisés Martínez Pérez</h6>

                    <p class="light center">Coordinador de investigación</p>
                </div>
            </div>
            <div class="col s12 m12">
                <div class="icon-block center">
                    <h2 class="center teal-text"><i class="material-icons">person</i></h2>
                    <h6 class="center">Ing. Rina Elizabeth López</h6>

                    <p class="light center">Co-Coordinadora de investigación</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="icon-block center">
                    <h2 class="center teal-text"><i class="material-icons">person</i></h2>
                    <h6 class="center">Leonel Antonio López Valencia</h6>

                    <p class="light center">Investigador</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="icon-block center">
                    <h2 class="center teal-text"><i class="material-icons">person</i></h2>
                    <h6 class="center">Samuel Armando Díaz Perez</h6>

                    <p class="light center">Investigador</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="icon-block center">
                    <h2 class="center teal-text"><i class="material-icons">person</i></h2>
                    <h6 class="center">Geovanny Roberto Martínez Ávila</h6>

                    <p class="light center">Investigador</p>
                </div>
            </div>
        </div>

    </div>
    <br><br>
</div>
@endsection

@yield('materialize-js')
