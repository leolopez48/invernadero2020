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
    <div class="container" id="box-loader">
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
</div>
<!-- END LOADER -->

<div class="container-fluid" id="content">
    <div class="row-fluid bg-green">
        <div class="row p-3 m-0">
            <div class="col s12">
                <a href="#modal1" id="btnNew"
                    class="waves-effect blue-text waves-light btn blue white-text modal-trigger">
                    <i class="material-icons">add</i>
                    Nuevo
                </a>
            </div>
            <div class="col s12 center" id="divStations">

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
                        <img class="circle" src="" alt="" id="inPhotoPre" width="170px" height="170px">
                    </div>
                    <div class="col s12 pt-2">
                        <p id="inId" style="display: none"></p>
                        <input type="file" name="" id="inFile">
                        <input type="text" name="" id="inName" placeholder="Nombre" maxlength="30">
                        <textarea name="" id="inDescription" cols="6" rows="6" class="materialize-textarea"
                            placeholder="Descripción" maxlength="50"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-flat">Cerrar</a>
        <a href="#!" class="modal-close waves-effect waves-green btn-flat" id="saveStation">Guardar</a>
    </div>
</div>

<div style="height: 50px;"></div>
@endsection
@section('js')
<script src="{{asset('js/libs.js')}}" type="module"></script>
<script src="{{asset('js/admin.js')}}" type="module"></script>
<!-- SWEETALERT2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@endsection
