<div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; width: 100%;">
  <div class="card-header">
      <h3 class="card-title">Informations générales</h3>
      <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
              <i class="fas fa-expand"></i>
          </button>
          <button type="button" class="btn btn-warning" data-toggle="modal" 
            spellcheck="false" data-dismiss="modal" wire:click="toogleSectionName('edit', {{$professeur->id}})">
              <i class="fa fa-pen"></i> Mettre à jour le profil de professeur</button>
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
                          src="{{ $professeur->profil != '' ? asset('storage/'.$professeur->profil) : 'https://eu.ui-avatars.com/api/?name=' . $professeur->nom . '&background=random' }}"
                          alt="Etudiant profile picture">
                  </div>
                  <h3 class="profile-username text-center">{{ $professeur->sexe == 'F' ? 'Mme/Mlle' : 'Mr' }} {{ $professeur->nom }} {{ $professeur->prenom }}</h3>
                  
                  <ul class="list-group list-group-unbordered mb-3">
                      {{-- <li class="list-group-item">
                          <b>Date de naissance</b> <a class="float-right">{{ $professeur->dateNaissance }}</a>
                      </li> 
                      <li class="list-group-item">
                          <b>Profession</b> <a class="float-right">{{ $professeur->profession }}</a>
                      </li> --}}
                      <li class="list-group-item">
                          <b>Email</b> <a class="float-right">{{ $professeur->email }}</a>
                      </li>
                      <li class="list-group-item">
                          <b>Téléphone</b> <a class="float-right">{{ $professeur->telephone1 }}</a>
                      </li>
                      @if ($professeur->telephone2 != '')
                          <li class="list-group-item">
                              <b>Seconde téléphone</b> <a class="float-right">{{ $professeur->telephone2 }}</a>
                          </li>
                      @endif
                      <li class="list-group-item">
                          <b>Nationalité</b> <a class="float-right">{{ $professeur->nationalite }}</a>
                      </li>
                      <li class="list-group-item">
                          <b>Adresse</b> <a class="float-right">{{ $professeur->adresse }}</a>
                      </li>
                  </ul>
              </div>

          </div>
      </div>
      <div class="col-md-7 card card-primary">
          <div class="card-header">
              <h3 class="card-title">Information cours</h3>
          </div>

          <div class="card-body">
              <strong><i class="fa fa-book mr-1"></i> Cour choisie</strong>
              <p class="text-muted">
                {{ $professeur->cours != '[]' ? $professeur->cours->implode('libelle', ' | ') : 'Aucun cours trouvé !' }}
              </p>
              <hr>
              {{-- <strong><i class="fa fa-thermometer mr-1"></i> Niveaux</strong>
              <p class="text-muted">{{ $professeur->level->nom }}</p>
              <hr> --}}
              <strong><i class="fa fa-hourglass mr-1" aria-hidden="true"></i> Heure de cour</strong>
              <p class="text-muted">
                  {{ $professeur->cours != '[]' ? $professeur->cours->implode('horaire', ' | ') :'Aucun cours trouvé !' }}
              </p>
              <hr>
              <strong><i class="fa fa-comments mr-1"></i> Commentaire</strong>
              <p class="text-muted"> {{ $professeur->coment }} </p>
          </div>

      </div>
  </div>
</div>