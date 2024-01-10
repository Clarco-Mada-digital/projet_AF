@extends('layouts.mainLayout')

@section('title', 'Contact')

@section('titlePage', 'PAGE CONTACT')

@section('content')
    <h3 class="mb-5 pt-3"> Contact MADA-Digital </h3>

    <section class="content">

        <div class="card">
            <div class="card-body row">
                <div class="col-5 text-center d-flex align-items-center justify-content-center">
                    <div class="">
                        <img src="{{ asset('images/logo/logo_mada-digital.png') }}" alt="logo MADA-Digital">
                        <p class="lead mb-5">EPP, Lazaret-Nord, Antsiranana 201<br />
                            <b>Téléphone</b>:
                            (+261) 32 82 968 68 <br />
                            <b>Email</b>: contact@mada-digital.net
                        </p>
                    </div>
                </div>
                <div class="col-7 mt-4">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="inputName">Nom</label>
                            <input type="text" id="inputName" class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <label for="inputEmail">E-mail</label>
                            <input type="email" id="inputEmail" class="form-control">
                        </div>
                        <div class="form-group col-7">
                            <label for="inputSubject">Object</label>
                            <input type="text" id="inputSubject" class="form-control">
                        </div>
                        <div class="form-group col-12">
                            <label for="inputMessage">Message</label>
                            <textarea id="inputMessage" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Envoyer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
