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
                            src="{{ $etudiant->adhesion->profil != '' ? asset('storage/'.$etudiant->adhesion->profil) : 'https://eu.ui-avatars.com/api/?name=' . $etudiant->adhesion->nom . '&background=random' }}"
                            alt="Etudiant profile picture">
                    </div>
                    <h3 class="profile-username text-center">{{ $etudiant->adhesion->sexe == 'F' ? 'Mme/Mlle' : 'Mr' }} {{
                        $etudiant->adhesion->nom }} {{ $etudiant->adhesion->prenom }}</h3>
                    <p class="text-muted text-center">Membre {{ $etudiant->created_at->diffForHumans() }}</p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Date de naissance</b> <a class="float-right">{{ Date('d M, Y',
                                strtotime($etudiant->adhesion->dateNaissance)) }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Profession</b> <a class="float-right">{{ $etudiant->adhesion->profession }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ $etudiant->adhesion->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Téléphone</b> <a class="float-right">{{ $etudiant->adhesion->telephone1 }}</a>
                        </li>
                        @if ($etudiant->adhesion->telephone2 != '')
                        <li class="list-group-item">
                            <b>Seconde téléphone</b> <a class="float-right">{{ $etudiant->adhesion->telephone2 }}</a>
                        </li>
                        @endif
                        <li class="list-group-item">
                            <b>Nationalité</b> <a class="float-right">{{ $etudiant->adhesion->nationalite }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Adresse</b> <a class="float-right">{{ $etudiant->adhesion->adresse }}</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-md-7 w-100 card card-primary">

            {{-- cards header --}}
            <div class="card-header">
                <h3 class="card-title">Information cours</h3>
            </div>

            {{-- cards body --}}
            <div class="card-body">
                <div class="input-group mb-3 @if($payRestant == false) d-none @endif">
                    <input type="number" class="form-control" placeholder="Montant à payer"
                        wire:model.live="montantPayer">
                    <div class="input-group-append">
                        <span class="input-group-text">Ar</span>
                    </div>
                    <button class="mx-2 btn btn-sm btn-success" wire:click="payRestantSubmit()">Payer</button>
                    <button class="btn btn-sm btn-danger" wire:click='toogleFormPayRestant'>
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                @if ($etudiant->cours->count() != 0)
                <strong><i class="fa fa-book mr-1"></i> Cours choisie</strong>
                <p class="text-muted d-flex justify-content-between align-items-center">
                    @foreach ($etudiant->cours as $cours)
                    <span>{{ $cours->libelle }} - {{ $cours->level->implode('libelle', ' | ') }} ({{ $cours->session->nom }})
                        @foreach ($etudiant->adhesion->inscriptions as $inscription)
                        @if ($inscription->type == "cours" && $cours->id == $inscription->idCourOrExam)
                        @foreach ($inscription->paiements as $paiement)
                        @if ( $paiement->montantRestant != 0)
                        - {{$paiement->montantRestant}} Ar à payer
                        <button class='btn btn-sm btn-success'
                            wire:click.prevent='toogleFormPayRestant({{$paiement->id}}, {{$inscription->id}})'>Régler le paiement</button>
                        @endif
                        @endforeach

                        @endif
                        @endforeach
                    </span>
                    </br>
                    @endforeach
                    {{-- {{ $etudiant->cours->implode('libelle', ' | ') }} - ({{ $etudiant->session->nom }}) --}}
                </p>
                <hr>
                <strong><i class="fa fa-hourglass mr-1" aria-hidden="true"></i> Heure de cour</strong>
                <p class="text-muted">
                    <span class="tag tag-danger"> {{ $etudiant->cours->implode('horaireDuCour', ', ') }} </span>
                </p>
                <hr>
                @endif
                @foreach ($etudiant->adhesion->inscriptions as $inscription)
                    @if ($inscription->idCourOrExam == null && $inscription->type == "cours")
                    <strong><i class="fa fa-book mr-1"></i> Cours choisie</strong>
                    <p class="text-muted d-flex justify-content-between align-items-center">
                        {{ $inscription->session->implode('nom', ' | ') }}
                        @foreach ($inscription->paiements as $paiement)
                        @if ( $paiement->montantRestant != 0)
                        - {{$paiement->montantRestant}} Ar à payer
                        <button class='btn btn-sm btn-warning'
                            wire:click.prevent='toogleFormPayRestant({{$paiement->id}}, {{$inscription->id}})'>Régler le paiement</button>
                        @endif
                        @endforeach
                    </p>
                    <hr>
                    @endif
                @endforeach
                
                @if ($etudiant->examens->count() != 0)
                <strong><i class="fa fa-book mr-1"></i> Examen choisie</strong>
                <p class="text-muted d-flex justify-content-between align-items-center p-0 m-0">
                    @foreach ($etudiant->examens as $examen)
                <section>{{ $examen->libelle }} - {{ $examen->level->libelle }} ({{ $examen->session->nom }})
                    @foreach ($etudiant->adhesion->inscriptions as $inscription)
                    @if ($inscription->type == "examen" && $examen->id == $inscription->idCourOrExam)                    
                    @foreach ($inscription->paiements as $paiement)
                    @if ( $paiement->montantRestant != 0)
                    - {{$paiement->montantRestant}} Ar à payer
                    <button class='btn btn-sm btn-success'
                        wire:click.prevent='toogleFormPayRestant({{$paiement->id}}, {{$inscription->id}})'>Régler le paiement</button>
                    @endif
                    @endforeach
                    
                    @endif
                    @endforeach
                </section>
                @endforeach
                {{-- {{ $etudiant->examens->implode('libelle', ' | ') }} - ({{ $etudiant->session->nom }}) --}}
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