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
                <h1 class="center teal-text">Acerca de</h1>
                <h3 class="left teal-text text-darken-2">ITCA-FEPADE</h3>
            </div>
            <div class="col m12">
                <h6 class="left teal-text text-darken-2">Docentes investigadores</h6>
            </div>
            <div class="col s12 m6">

                <div class="icon-block center">
                    <h2 class="center teal-text"><i class="material-icons">person</i></h2>
                    <h6 class="center">Ing. Elvis Moisés Martínez Pérez</h6>

                    <!-- <p class="light center">Coordinador de investigación</p> -->
                </div>
            </div>
            <div class="col s12 m6">
                <div class="icon-block center">
                    <h2 class="center teal-text"><i class="material-icons">person</i></h2>
                    <h6 class="center">Ing. Rina Elizabeth López</h6>

                    <!-- <p class="light center">Co-Coordinadora de investigación</p> -->
                </div>
            </div>
            <div class="col m12" style="padding-top: 30px;">
                <h6 class="left teal-text text-darken-2">Alumnos investigadores</h6>
            </div>
            <div class="col s12 m4">
                <div class="icon-block center">
                    <h2 class="center teal-text"><i class="material-icons">person</i></h2>
                    <h6 class="center">Leonel Antonio López Valencia</h6>

                    <!-- <p class="light center">Investigador</p> -->
                </div>
            </div>
            <div class="col s12 m4">
                <div class="icon-block center">
                    <h2 class="center teal-text"><i class="material-icons">person</i></h2>
                    <h6 class="center">Samuel Armando Díaz Perez</h6>

                    <!-- <p class="light center">Investigador</p> -->
                </div>
            </div>
            <div class="col s12 m4">
                <div class="icon-block center">
                    <h2 class="center teal-text"><i class="material-icons">person</i></h2>
                    <h6 class="center">Geovanny Roberto Martínez Ávila</h6>

                    <!-- <p class="light center">Investigador</p> -->
                </div>
            </div>
            <div class="col s12 m12 center">
                <h3 class="left teal-text text-darken-2">Descripción</h3>
            </div>
            <div class="col s12 m12 center" style="text-align: justify;">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam porro inventore enim eveniet
                    atque dignissimos repellat obcaecati minus, facere voluptatum mollitia error delectus, fuga,
                    ullam corporis exercitationem ex alias quia.Eum iste vitae est asperiores
                    laudantium odit quisquam distinctio dignissimos itaque, necessitatibus tempore enim ullam fuga
                    ducimus iure soluta! Eveniet tenetur numquam eius obcaecati, explicabo distinctio nam quibusdam
                    sapiente provident.</p>
            </div>
        </div>
    </div>
    <br><br>
</div>
@endsection

@yield('materialize-js')
