@php
    $marcaVeiculos = [];
    $modelo = [];
@endphp
@extends('layouts.app_sem_main')

@section('content')
    <div class="container-fluid bg-dark text-white h-100">
        <div class="row align-items-center h-100">
            <div class="col-md-4 mx-auto">
                <span class="display-5"><img src="{{ asset('images/logo_login.png') }}" width="400px"
                        alt="Golden Service - Controle de Frotas"></span>
                <form method="POST" action="{{ route('saldo.json') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input class="form-control form-control-lg{{ $errors->has('username') ? ' is-invalid' : '' }}"
                            placeholder="Usuário" id="text" type="username" name="username"
                            value="{{ old('username') }}" required autofocus>

                        @if ($errors->has('username'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            placeholder="Senha" id="password" type="password" name="password" value="{{ old('password') }}"
                            required autofocus>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="remember" name="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="remember">Manter conectado</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-info btn-lg btn-block">Entrar</button>
                    </div>
                    <div class="row">
                        <a class="btn btn-link text-light" href="{{ route('password.request') }}">
                            Esqueceu sua senha?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('document-ready')
    $("#text").mask('000.000.000-00', {placeholder: '___.___.___-__'});
@endpush
