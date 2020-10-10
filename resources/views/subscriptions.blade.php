@extends('layout.index')

@section('title')
<title>Suscripciones | Invernadero</title>
@show

@section('content')
<div class="container">
    <div class="row">
        <h4 class="center blue-text text-darken-4">Suscripciones</h4>
        <div id="stations">
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/suscriptions.js')}}"></script>
@endsection