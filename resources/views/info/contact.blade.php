@extends('layouts.app')

@section ('tittle', 'AlVenta | Contacto')

@section ('body-class', 'profile-page sidebar-collapse')

@section('content')
<div class="page-header header-filter" data-parallax="true" style="background-image: url('{{asset('img/ecommerce.jpg')}}')">
</div>

<div class="main main-raised">
    <div class="profile-content">
        <div class="container">

            <div class="row">
                <div class="ml-auto mr-auto text-center">
                    <h3 class="title">Contacto</h3>
                    <h5>Nuestros administradores te contactarán a la brevedad</h5>
                </div>
            </div>

            <div class="tab-content tab-space">

                <div class="col-md-6 offset-3">

                    @if (session('notification'))
                    <div class="alert alert-success" role="alert">
                        {{ session('notification') }}
                    </div>
                    @endif

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

                    <form method="post" action="/send">
                        @csrf

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Tu Nombre" required value="{{ old('name', (auth()->check()) ? auth()->user()->name : '') }}" onkeypress="isNotNumber(event);" />
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Dirección de correo electrónico" required value="{{ old('email', (auth()->check()) ? auth()->user()->email : '') }}" />
                                </div>

                                <div class="form-group">
                                    <label for="subject" class="control-label">Asunto</label>
                                    <select id="subject" name="subject" class="form-control" required>
                                        <option value="Consulta-General" selected>Consulta General</option>
                                        <option value="Sugerencia" {{ (old('subject') == 'Sugerencia') ? 'selected' : ''}}>Sugerencia</option>
                                        <option value="Problema-Envio" {{ (old('subject') == 'Problema-Envio') ? 'selected' : ''}}>Problemas de Envío</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Mensaje</label>
                                    <textarea name="message" id="message" class="form-control" rows="10" cols="25" required placeholder="Tu Mensaje" style="padding-bottom: 0em;">{{ old('message') }}</textarea>
                                </div>
                            </div>

                            <div class="ml-auto mr-auto text-center">
                                <button type="submit" class="btn btn-primary btn-round">Enviar Email <i class="material-icons">mail</i><i class="material-icons">arrow_forward</i></button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@include('includes.footer')

@endsection
<script>
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