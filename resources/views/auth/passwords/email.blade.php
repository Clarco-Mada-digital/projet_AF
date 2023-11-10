@extends('/layouts.auth')

@section('content')
    <div class="row w-100 log-container">

        {{-- left part log form --}}
        <div class="col-xl-6 col-md-12">
            <div class="log text-center">
                <img class="w-25" src="../images/logo/alliance-francaise-d-antsiranana-logo.png" alt="logo AF">
            </div>
            <hr class="mb-4 mt-0" />
            <div class="form-container text-center">
                <h3>Réinitialiser le mot de passe</h3>
                <p class="login-box-msg fs-5 text-muted">Perdre son mot de passe est une expérience courante et ne doit pas être source d’inquiétude.</p>

                {{-- Formulaire de reinitialisation de mdp --}}
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Adresse Email') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary sub-log-btn">
                                {{ __('Envoyer le lien de réinitialisation') }}
                            </button>
                        </div>
                    </div>
                </form>              
                
            </div>
        </div>

        {{-- right parte log img --}}
        <div class="col-xl-6 log-right-image" style="background-image: url('../images/fond_log-in.png')">
        </div>
    </div>
    
@endsection


{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
