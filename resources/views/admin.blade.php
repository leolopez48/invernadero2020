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
    <div class="row bg-green p-0 m-0">
        <div class="row p-3 m-0">
            <div class="col s12" id="btnNewDiv">
                <a href="#modal1" id="btnNew"
                    class="waves-effect blue-text waves-light btn blue white-text modal-trigger">
                    <i class="material-icons">add</i>
                    Nuevo
                </a>
            </div>
            <div class="col s12" id="divStations">

            </div>

        </div>
    </div>
    <svg class="p-0 m-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100">
        <path fill="#009688" fill-opacity="1"
            d="M0,96L120,80C240,64,480,32,720,16C960,0,1200,0,1320,0L1440,0L1440,0L1320,0C1200,0,960,0,720,0C480,0,240,0,120,0L0,0Z">
        </path>
    </svg>
</div>
<!-- MODAL -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <h4 id="titleModal">Editar estación</h4>
        <div class="container-fluid">
            <div class="row">
                <div class="col s12 m-3">
                    <div class="col s12 l12 center">
                        <img class="circle" id="inPhotoPre" width="130px" height="130px">
                    </div>
                    <div class="col s12 pt-2">
                        <p id="inId" style="display: none"></p>
                        <input type="file" name="" id="inFile" accept=".png, .jpg, .jpeg" class="file-path validate">
                        <input type="text" name="" id="inName" placeholder="Nombre" maxlength="30">
                        <textarea name="" id="inDescription" cols="6" rows="6" class="materialize-textarea"
                            placeholder="Descripción" maxlength="50"></textarea>

                        <h5>Tipo estación</h5>
                        <div id="divTypeButtons">
                            <a id="btnTypeInv" class="waves-effect waves-light btn teal lighten-1 p-1">Invernadero</a>
                            <a id="btnTypeAcu" class="waves-effect waves-light btn teal lighten-1 p-1">Acuícola</a>
                        </div>

                        <div id="divVar" style="display: none;">
                            <div>
                                <a class="waves-effect waves-light btn light-blue lighten-1 m-1" id="btnMinValues">Nueva
                                    variable</a>
                            </div>
                            <!-- Buttons -->
                            <div class="p-1" id="minValueButtonsInv" style="display: none;">
                                <a id="btnMinTemp" class="waves-effect waves-light btn teal lighten-1">Temperatura</a>
                                <a id="btnMinHum" class="waves-effect waves-light btn teal lighten-1">Humedad</a>
                                <a id="btnMinRad" class="waves-effect waves-light btn teal lighten-1">Radiación</a>
                            </div>
                            <div class="p-1" id="minValueButtonsAcu" style="display: none;">
                                <a id="btnMinPH" class="waves-effect waves-light btn teal lighten-1">PH</a>
                                <a id="btnMinTempAcu"
                                    class="waves-effect waves-light btn teal lighten-1">Temperatura</a>
                                <a id="btnMinOx" class="waves-effect waves-light btn teal lighten-1">Oxígeno</a>
                            </div>
                            <!-- End buttons -->
                            <h5>Valores mínimos</h5>

                            <div id="divInputsLow">
                                <div id="divLowTemp" style="display: none;">
                                    <h6>Temperatura</h6>
                                    <input type="number" name="" id="inLowestPT" min="1" placeholder="Temperatura">
                                </div>
                                <div id="divLowHum" style="display: none;">
                                    <h6>Húmedad</h6>
                                    <input type="number" name="" id="inLowestPH" min="1" placeholder="Húmedad">
                                </div>
                                <div id="divLowRad" style="display: none;">
                                    <h6>Radiación</h6>
                                    <input type="number" name="" id="inLowestPR" min="1" placeholder="Radiación">
                                </div>

                                <div id="divLowPHL" style="display: none;">
                                    <h6>PH</h6>
                                    <input type="number" name="" id="inLowestPHL" min="1" placeholder="PH">
                                </div>
                                <div id="divLowOx" style="display: none;">
                                    <h6>Oxígeno</h6>
                                    <input type="number" name="" id="inLowestOX" min="1" placeholder="Oxígeno">
                                </div>
                            </div>

                            <h5>Valores máximos</h5>

                            <div id="divInputsHigh">
                                <div id="divHighTemp" style="display: none;">
                                    <h6>Temperatura</h6>
                                    <input type="number" name="" id="inHighestPT" min="1" placeholder="Temperatura">
                                </div>
                                <div id="divHighHum" style="display: none;">
                                    <h6>Húmedad</h6>
                                    <input type="number" name="" id="inHighestPH" min="1" placeholder="Húmedad">
                                </div>
                                <div id="divHighRad" style="display: none;">
                                    <h6>Radiación</h6>
                                    <input type="number" name="" id="inHighestPR" min="1" placeholder="Radiación">
                                </div>

                                <div id="divHighPHL" style="display: none;">
                                    <h6>PH</h6>
                                    <input type="number" name="" id="inHighestPHL" min="1" placeholder="PH">
                                </div>
                                <div id="divHighOx" style="display: none;">
                                    <h6>Oxígeno</h6>
                                    <input type="number" name="" id="inHighestOX" min="1" placeholder="Oxígeno">
                                </div>
                            </div>
                        </div>

                        <div id="divSearch">
                            <h5>Usuarios</h5>
                            <input type="text" id="inUser" class="col s10" placeholder="Correo">
                            <a href="#" class="col s1" id="btnUserSearch"><i
                                    class="fas fa-search fa-2x black-text"></i></a>
                            <div class="container-fluid">
                                <div id="divUsers">
                                    <div id="divUserSearched">

                                    </div>
                                    <div class="col s12">
                                        <h6><strong>Permitidos</strong></h6>
                                    </div>
                                    <div id="divUserAllowed">

                                    </div>
                                </div>
                            </div>
                        </div>
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
<!-- END MODAL -->
<div style="height: 50px;"></div>
@endsection
@section('js')
<script src="{{asset('js/libs.js')}}" type="module"></script>
<script src="{{asset('js/admin.js')}}" type="module"></script>
<!-- SWEETALERT2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@endsection
