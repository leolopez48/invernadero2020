@extends('layout.index')

@section('content')
<div class="container">
    <div class="row center">
        <div class="col s12 m8 offset-m2">
            <div class="card ">
                <div class="card-header">
                    <h4 class="padding-20 grey-text text-darken-1">Iniciar sesión</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col m4 left offset-s1">Correo </label>

                            <div class="col m6 s8">
                                <input id="email" type="email"
                                    class=" form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Valor incorrecto</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="password" class="col m4 left offset-s1">Contraseña</label>

                            <div class="col m6 s8 ">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Valor incorrecto</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row padding-20">
                            <div class="col m8 offset-m2 offset-s4">
                                <button type="submit" class="btn btn-primary">
                                    Iniciar sesión
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
