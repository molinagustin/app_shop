@extends('layouts.app')

@section ('body-class', 'login-page sidebar-collapse')

@section ('styles')
<style>
    .hide {
        visibility: hidden;
    }

    *,
    *::before,
    *::after {
        box-sizing: content-box;
    }

    *,
    *::before,
    *::after {
        box-sizing: content-box;
    }
</style>
@endsection

@section('content')
<div class="header header-filter" style="background-image: url('{{ asset('img/ecommerce.jpg') }}'); background-size: cover; background-position: top center; position: relative;display:grid;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                <div class="card card-login">

                    <form class="form" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="card-header card-header-primary text-center">
                            <h4 class="card-title">Registro</h4>
                        </div>
                        <p class="description text-center">Completá Tus Datos</p>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>
                                    {{$error}}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="card-body">

                            <div div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">face</i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Nombre de Usuario" name="name" value="{{ old('name', $name) }}" required autofocus onkeypress="isNotNumber(event);">
                            </div>

                            <div div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">location_on</i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Dirección" name="address" value="{{ old('address') }}">
                            </div>

                            <div div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">phone</i>
                                    </span>
                                </div>
                                <input type="phone" class="form-control" placeholder="Teléfono" name="phone" value="{{ old('phone') }}" onkeypress="isNumber2(event);">
                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">mail</i>
                                    </span>
                                </div>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Correo Electrónico" name="email" value="{{ old('email', $email) }}" required autocomplete="email">
                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                </div>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                </div>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password" placeholder="Confirmar Contraseña">
                            </div>

                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-link btn-wd btn-lg">REGISTRARSE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @include('includes.footer')

</div>
@endsection
<script>
    // this prevents from typing non-number text, including "e".
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        let charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
            evt.preventDefault();
        } else {
            return true;
        }
    }

    // this prevents from typing non-number text, including "e" and ".".
    function isNumber2(evt) {
        evt = (evt) ? evt : window.event;
        let charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) || charCode == 46) {
            evt.preventDefault();
        } else {
            return true;
        }
    }

    // this prevents from typing non-number text, including "e".
    function isNotNumber(evt) {
        evt = (evt) ? evt : window.event;
        let charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
            return true;
        } else {
            evt.preventDefault();
        }
    }
</script>