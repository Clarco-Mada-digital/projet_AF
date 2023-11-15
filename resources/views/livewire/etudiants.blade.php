@section('title', 'Listes etudiants')

@section('titlePage', 'PAGE ETUDIANT')

<div>
    <h3 class="mb-5 pt-3">Listes étudiants</h3>
    <div class="row m-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title d-flex align-items-center"> <i class="fa fa-users fa-2x mr-2"></i> Liste des
                        étudiants</h3>
                    <div class="card-tools d-flex align-items-center">
                        <a class="btn btn-link text-light mr-4" href="{{ route('etudiants-nouveau') }}"> <i class="fa fa-user-plus"></i> Nouvel
                            étudiant</a>
                        <div class="input-group input-group-md" style="width: 250px;">
                            <input type="text" name="table_search" class="form-control float-right"
                                placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0 table-striped" style="height: 370px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 5%"></th>
                                <th class="text-center" style="width: 10%">N° Carte</th>
                                <th style="width: 20%">Nom</th>
                                <th style="width: 20%">Prénom</th>
                                <th class="text-center" style="width: 20%">Téléphone</th>
                                <th class="text-center" style="width: 20%">Cour choisi</th>
                                <th class="text-center" style="width: 5%">Détail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($etudiants as $etudiant)
                                <tr>
                                    <td>
                                        @if($etudiant->sexe == 'F') <img src="{{ asset('images/profil/woman.png') }}" width='24' alt="profil etudiant">
                                        @else <img src="{{ asset('images/profil/man.png') }}" width='24' alt="profil etudiant"> 
                                        @endif
                                    </td>
                                    <td class="text-center">{{$etudiant->numCarte}}</td>
                                    <td>{{$etudiant->nom}}</td>
                                    <td>{{$etudiant->prenom}}</td>
                                    <td class="text-center">{{$etudiant->telephone1}}</td>
                                    <td> {{ $etudiant->cours->implode('nom', ' | ') }} </td>
                                    <td class="text-center">
                                        <button class="btn btn-link"> <i class="fa fa-eye"></i></button>
                                        <button class="btn btn-link"> <i class="fa fa-edit"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfixr">
                    <div class="float-right">
                        {{ $etudiants->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
