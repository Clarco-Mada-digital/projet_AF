@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
<div class="row w-100 log-container">
    {{-- Section SVG --}}
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>

    {{-- left part log form --}}
    <div class="col-xl-6 col-md-12">
        <div class="log text-center">
            <img class="w-25" src="{{asset("images/logo/alliance-francaise-d-antsiranana-logo.png")}}" alt="logo AF">
        </div>
        <hr class="mb-4 mt-0" />
        <div class="form-container text-center">
            <h3>Bienvenue</h3>
            <p class="login-box-msg fs-5">Connexion ou création de compte en 1 minute</p>

            @error('email')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 mx-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div>
                    Désolé, Votre email ou mot de passe incorrect !
                </div>
            </div>
            @enderror


            {{-- Formulaire de connexion --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group text-left">
                    <label class="form-label text-muted">Identifiant</label>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email"
                            value="{{ old('email')? old('email'):'jhon@doe.com' }}" required autocomplete="email"
                            autofocus placeholder="jhon@doe.com">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                        {{-- @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>Address email introuvable !</strong>
                        </span>
                        @enderror --}}
                    </div>
                </div>

                <div class="form-group text-left">
                    <label class="form-label text-muted">Mot de passe</label>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control"
                            name="password" value="password" required autocomplete="current-password"
                            placeholder="Mot de passe">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        {{-- @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror --}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 text-left">
                        <div class="icheck-primary text-muted">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">
                                Souviens-toi de moi
                            </label>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <p class="mb-1">
                            @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Mot de passe oublier
                            </a>
                            @endif
                        </p>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block sub-log-btn">Continuer</button>
                    </div>

                </div>
            </form>
            <div class="row m-3">
                <div class="col-sm-4">
                    <hr />
                </div>
                <div class="col-sm-4">
                    <span>ou</span>
                </div>
                <div class="col-sm-4">
                    <hr />
                </div>
            </div>

            <div class="social-auth-links text-center mt-2 mb-3">
                <a href="{{ route("mada-contact") }}" class="btn btn-block btn-danger">
                    <i class="fa fa-envelope mr-2"></i> Contacter MADA-Digital
                </a>
            </div>

        </div>
    </div>

    {{-- right parte log img --}}
    <div class="col-xl-6 log-right-image" style="background-image: url('images/fond_log-in.webp')">
    </div>
</div>

@endsection