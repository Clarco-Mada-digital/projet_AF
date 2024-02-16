<div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; width: 100%;">
    <div class="card-header">
        <h3 class="card-title">Informations générales</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                <i class="fas fa-expand"></i>
            </button>
            <button type="button" class="btn btn-warning" data-toggle="modal" spellcheck="false" data-dismiss="modal"
                wire:click='initDataEtudiant({{ $etudiant->id }})'>
                <i class="fa fa-pen"></i> Mettre à jour le profil</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fa fa-times"></i>
            </button>
        </div>

    </div>

    <div class="card-body row">
        <div class="col-md-4 d-flex justify-content-centr flex-column mr-1">
            <div class="card card-primary card-outline">

                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ $etudiant->profil != '' ? asset('storage/'.$etudiant->profil) : 'https://eu.ui-avatars.com/api/?name=' . $etudiant->nom . '&background=random' }}"
                            alt="Etudiant profile picture">
                    </div>
                    <h3 class="profile-username text-center">{{ $etudiant->sexe == 'F' ? 'Mme/Mlle' : 'Mr' }} {{
                        $etudiant->nom }} {{ $etudiant->prenom }}</h3>
                    <p class="text-muted text-center">Membre {{ $etudiant->created_at->diffForHumans() }}</p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Date de naissance</b> <a class="float-right">{{ $etudiant->dateNaissance }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Profession</b> <a class="float-right">{{ $etudiant->profession }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ $etudiant->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Téléphone</b> <a class="float-right">{{ $etudiant->telephone1 }}</a>
                        </li>
                        @if ($etudiant->telephone2 != '')
                        <li class="list-group-item">
                            <b>Seconde téléphone</b> <a class="float-right">{{ $etudiant->telephone2 }}</a>
                        </li>
                        @endif
                        <li class="list-group-item">
                            <b>Nationalité</b> <a class="float-right">{{ $etudiant->nationalite }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Adresse</b> <a class="float-right">{{ $etudiant->adresse }}</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-md-7 card card-primary">

            {{-- cards header --}}
            <div class="card-header">
                <h3 class="card-title">Information cours</h3>
            </div>

            {{-- cards body --}}
            <div class="card-body">
                @if ($etudiant->cours->count() != 0)
                <strong><i class="fa fa-book mr-1"></i> Cour choisie</strong>
                <p class="text-muted">
                    {{ $etudiant->cours->implode('libelle', ' | ') }} - ({{ $etudiant->session->nom }})
                </p>
                <hr>
                <strong><i class="fa fa-hourglass mr-1" aria-hidden="true"></i> Heure de cour</strong>
                <p class="text-muted">
                    <span class="tag tag-danger"> {{ $etudiant->cours->implode('horaireDuCour', ', ') }} </span>
                </p>
                <hr>
                @endif
                @if ($etudiant->examens->count() != 0)
                <strong><i class="fa fa-book mr-1"></i> Examen choisie</strong>
                <p class="text-muted">
                    {{ $etudiant->examens->implode('libelle', ' | ') }} - ({{ $etudiant->session->nom }})
                </p>
                <hr>
                @endif

                <strong><i class="fa fa-thermometer mr-1"></i> Niveaux</strong>
                <p class="text-muted">{{ $etudiant->level->libelle }}</p>
                <hr>

                <strong><i class="fa fa-comments mr-1"></i> Commentaire</strong>
                <p class="text-muted"> {{ $etudiant->coment }} </p>
            </div>

        </div>
    </div>
</div>