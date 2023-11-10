@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
    <div class="row w-100 log-container">

        {{-- left part log form --}}
        <div class="col-xl-6 col-md-12">
            <div class="log text-center">
                <img class="w-25" src="images/logo/alliance-francaise-d-antsiranana-logo.png" alt="logo AF">
            </div>
            <hr class="mb-4 mt-0" />
            <div class="form-container text-center">
                <h3>Bienvenue</h3>
                <p class="login-box-msg fs-5">Connexion ou création de compte en 1 minute</p>

                {{-- Formulaire de connexion --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group text-left">
                        <label class="form-label text-muted">Identifiant</label>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group text-left">
                        <label class="form-label text-muted">Mot de passe</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password" placeholder="Mot de passe">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 text-left">
                            <div class="icheck-primary text-muted">
                                <input type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
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
                        <span>ou continuer avec</span>
                    </div>
                    <div class="col-sm-4">
                        <hr />
                    </div>
                </div>

                <div class="social-auth-links text-center mt-2 mb-3">
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Connecté avec Google+
                    </a>
                </div>
                
            </div>
        </div>

        {{-- right parte log img --}}
        <div class="col-xl-6 log-right-image" style="background-image: url('images/fond_log-in.png')">
        </div>
    </div>
    
@endsection



