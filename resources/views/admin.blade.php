@extends('layout.index')

@section('title')
<title>Administración | Invernadero</title>
@show

<!-- CSS  -->
@section('css')
<link rel="stylesheet" href="{{asset('css/custom.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
@endsection

@section('content')
<!-- LOADER -->
<div class="container-fluid" id="loader">
    <div class="row center">
        <div class="preloader-wrapper big" id="loader-toggle">
            <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END LOADER -->

<div class="container-fluid" id="content">
    <div class="row-fluid bg-green">

        <div class="row p-3 m-0">
            <!-- <div class="col s12 center-align">
                <h4 class="center-align white-text">Administración</h4>
            </div> -->
            <div class="col s12">
                <a href="#modal1" id="btnNew"
                    class="waves-effect blue-text waves-light btn blue white-text modal-trigger">
                    <i class="fas fa-plus pr-1"></i>
                    Nuevo
                </a>
            </div>
            <div class="col s12" id="divStations">

                <a class="station modal-trigger" id="station" href="#modal1">
                    <div class="col s12 m3 l2 m-1 white rounded hoverable">
                        <div class=" col s12 center">
                            <img class="circle center-align p-1" src="https://picsum.photos/id/110/110/110" alt="">
                        </div>
                        <div class="col s12 center">
                            <strong class="center black-text">Titulo</strong>
                            <p class="black-text p-1 left-align">Lorem ipsum dolor sit, amet consectetur adipisicing
                                elit.
                                Impedit, molestiae?
                            </p>
                        </div>
                    </div>
                </a>

            </div>

        </div>
    </div>
    <svg class="p-0 m-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100">
        <path fill="#009688" fill-opacity="1"
            d="M0,96L120,80C240,64,480,32,720,16C960,0,1200,0,1320,0L1440,0L1440,0L1320,0C1200,0,960,0,720,0C480,0,240,0,120,0L0,0Z">
        </path>
    </svg>
</div>

<div id="modal1" class="modal">
    <div class="modal-content">
        <h4 id="titleModal">Editar estación</h4>
        <div class="container-fluid">
            <div class="row">
                <div class="col s12 m-3">
                    <div class="col s12 l12 center">
                        <img class="circle" src="https://picsum.photos/id/120/120/120" alt="">
                    </div>
                    <div class="col s12 pt-2">
                        <input type="file" name="" id="inFile">
                        <input type="text" name="" id="inName" placeholder="Nombre" maxlength="30">
                        <textarea name="" id="inDescription" cols="3" rows="6" class="materialize-textarea m-2"
                            placeholder="Descripción" maxlength="50"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Eliminar</a>
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Guardar</a>
    </div>
</div>

<div style="height: 50px;"></div>
@endsection
@section('js')
<script src="{{asset('js/libs.js')}}" type="module"></script>
<script src="{{asset('js/admin.js')}}" type="module"></script>

@endsection
