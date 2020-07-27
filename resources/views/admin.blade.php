@extends('layout.index')

@section('title')
<title>Administración | Invernadero</title>
@show

<!-- CSS  -->
@section('css')
<link rel="stylesheet" href="{{asset('css/custom.css')}}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="background-green">
            <div class="container">
            </div>
        </div>
        <div class="m-0 p-0 p-relative">
            <div class="p-absolute-1" style="position: absolute; z-index: 1; top: 300px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                    <path fill="#009688" fill-opacity="1"
                        d="M0,128L48,112C96,96,192,64,288,64C384,64,480,96,576,112C672,128,768,128,864,133.3C960,139,1056,149,1152,133.3C1248,117,1344,75,1392,53.3L1440,32L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z">
                    </path>
                </svg>
            </div>
            <div class="p-absolute-2" style="position: absolute; z-index: 2; top: 200px;">
                <row>
                    <h6>Hola</h6>
                </row>
            </div>
        </div>
    </div>
</div>
@endsection
