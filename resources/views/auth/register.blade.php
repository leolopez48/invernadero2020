@extends('layout.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m8 offset-m2">
            <div class="card z-depth-3">
                <div class="card-header">
                <h4 class="center grey-text text-darken-1 padding-20">Registrarse</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <label for="name" class="col m2 offset-m1">{{ __('Nombre') }}</label>

                            <div class="col m7">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('Nombre') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="email" class="col m2 offset-m1">{{ __('E-Mail') }}</label>

                            <div class="col m7">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="password" class="col m2 offset-m1">{{ __('Contraseña') }}</label>

                            <div class="col m7">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="password-confirm" class="col m2 offset-m1">{{ __('Confirmar Contraseña') }}</label>

                            <div class="col m7">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row center">
                            <div class="padding-20">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrarse') }}
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
