@extends('layout.index')

@section('title')
<title>Inicio | Invernadero</title>
@show

<!-- CSS  -->
@section('css')
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/maps.js"></script>
<script src="https://www.amcharts.com/lib/4/geodata/elSalvadorLow.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="//www.amcharts.com/lib/4/lang/es_ES.js"></script>
@endsection

@section('content')

<div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
        <div class="container">
            <br><br>
            <h1 id="tituloEst" class="header center teal-text text-lighten-2 tituloEst">Estación ENA</h1>
            <div class="row center">
                <h5 class="header col s12 light text-bold">
                    <p id="descEst" class="descEst">Invernadero ubicado en ENA</p>
                </h5>
            </div>
            <br><br>

        </div>
    </div>
    <div class="parallax"><img src="{{ asset('imgs/background3.jpg') }}" alt="Unsplashed background img 1"></div>
</div>

<!-- Modal Trigger -->
<button class="waves-effect waves-light btn modal-trigger no-display" href="#modal1" id="btnModal">Modal</button>

<!-- Modal Structure -->
<div id="modal1" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <h4 id="depSelected"></h4>
        <p id="idSelected"></p>
        <a href="" id="idSantaAna1">Santa Ana</a>
    </div>
    <div class="modal-footer">
        <a href="#" class="modal-close waves-effect waves-light btn-flat" id="idSelect"
            data-dismiss="#modal1">Seleccionar</a>
    </div>
</div>

<!-- <div class="container-fluid padding-60">
    <div class="section ">
        <div class="row">
            <div class="col s12 s12 ">
                <div class="" id="chartdiv"></div> 
            </div>
        </div>

    </div>
</div> -->

<div class="container">
    <div class="row">
        <h4 class="center blue-text text-darken-4">Estaciones</h4>
        <div class="col s6 m6">
            <div class="card">
                <a href="" id="est1">
                    <div class="card-image">
                        <img src="{{asset('imgs/background3.jpg')}}">
                        <span class="card-title">Card Title</span>
                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information.
                            I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <!-- <div class="card-action">
                    <a href="#">This is a link</a>
                </div> -->
                </a>
            </div>

        </div>
        <div class="col s6 m6">
            <div class="card">
                <a href="" id="est2">
                    <div class="card-image">
                        <img src="{{asset('imgs/background3.jpg')}}">
                        <span class="card-title">Card Title</span>
                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information.
                            I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <!-- <div class="card-action">
        <a href="#">This is a link</a>
    </div> -->
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="section ">
        <h4 class="center teal-text">Datos registrados</h4>
        <div class="row">
            <div class="col s12 m4">
                <h6 class="center blue-text text-darken-4">Temperatura</h6>
                <div class="" id="graphicLineDiv"></div>
            </div>
            <div class="col s12 m4 ">
                <h6 class="center blue-text text-darken-4">Húmedad</h6>
                <div class="" id="graphicLineHumDiv"></div>
            </div>
            <div class="col s12 m4 ">
                <h6 class="center blue-text text-darken-4">Radiación solar</h6>
                <div class="" id="graphicLineRadDiv"></div>
            </div>
        </div>

    </div>
</div>

<div class="container">
    <div class="section ">
        <div class="row center">
            <div class="col s12 m12 padding-20" id="containerTable">
                <table class="responsive-table highlight">
                    <thead>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Temperatura (°C)</th>
                        <th>Húmedad</th>
                        <th>Radiación solar</th>
                    </thead>
                    <tbody id="idTabla">
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/mapa.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@endsection
