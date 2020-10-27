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
            <p id="IdEst" style="display:none;">0</p>
            <h1 id="tituloEst" class="header center teal-text text-lighten-2 tituloEst">Invernadero ENA</h1>
            <div class="row center">
                <h5 class="header col s12 light text-bold">
                    <p id="descEst" class="descEst">Invernadero ubicado en ENA</p>
                </h5>
            </div>
            <br><br>

        </div>
    </div>
    <div class="parallax"><img src="{{asset('imgs/background3.jpg')}}" alt="Unsplashed background img 1"
            id="stBackground"></div>
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

<div class="container">
    <div class="row">
        <h4 class="center blue-text text-darken-4">Estaciones</h4>
        <div id="stations">
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="section">
        <h4 class="center teal-text" id="titleGraphics">Datos registrados</h4>
        <div class="row" id="divData">
            <!-- Modal Trigger -->
            <div class="container">
                <a class="waves-effect waves-light btn modal-trigger margin-2" href="#modalFilter" id="btnFilter"><i
                        class="material-icons">filter_list</i> Filtrar</a>
                <a class="waves-effect waves-light btn red margin-2" href="#" id="btnDelFilter"
                    style="visibility: hidden;"><i class="material-icons">delete_sweep</i> Eliminar filtro</a>
            </div>
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
        <div class="row center" id="divTable">
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

<!-- MODAL -->

<!-- Modal Structure -->
<div id="modalFilter" class="modal">
    <div class="modal-content">
        <h4 id="titleModal">Filtrar</h4>
        <div class="container-fluid">
            <div class="row">
                <div class="col s12 m10 offset-m1">

                    <h5 class="lead mb-0">Fecha inicio</h5>
                    <input type="datetime-local" class="form-control mb-3" id="filterStart" name="start">
                    <h5 class="lead mb-0">Fecha final</h5>
                    <input type="datetime-local" class="form-control mb-3" id="filterEnd" name="end">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cerrar</a>
        <a href="#!" class="modal-close waves-effect waves-green btn-flat" id="btnModalFilter">Filtrar</a>
    </div>
</div>
<!-- END MODAL -->
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{asset('js/mapa.js')}}"></script>
@endsection
