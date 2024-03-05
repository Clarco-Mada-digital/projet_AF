<div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; width: 100%;">
  <div class="card-header">
      <h3 class="card-title">Informations générales</h3>
      <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
              <i class="fas fa-expand"></i>
          </button>
          <button type="button" class="btn btn-warning" data-toggle="modal" 
            spellcheck="false" data-dismiss="modal" wire:click="toogleSectionName('edit', {{$user->id}})">
              <i class="fa fa-pen"></i> Mettre à jour le profil de l'utilisateur</button>
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
                          src="{{ $user->profil != '' ? asset('storage/'.$user->profil) : 'https://eu.ui-avatars.com/api/?name=' . $user->nom . '&background=random' }}"
                          alt="Etudiant profile picture">
                  </div>
                  <h3 class="profile-username text-center">{{ $user->sexe == 'F' ? 'Mme/Mlle' : 'Mr' }} {{ $user->nom }} {{ $user->prenom }}</h3>
                  <p class="text-center text-muted"> {{$user->roles->implode('name', ' | ')}} </p>
                  
                  <ul class="list-group list-group-unbordered mb-3">
                      {{-- <li class="list-group-item">
                          <b>Date de naissance</b> <a class="float-right">{{ $user->dateNaissance }}</a>
                      </li> 
                      <li class="list-group-item">
                          <b>Profession</b> <a class="float-right">{{ $user->profession }}</a>
                      </li> --}}
                      <li class="list-group-item">
                          <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                      </li>
                      <li class="list-group-item">
                          <b>Téléphone</b> <a class="float-right">{{ $user->telephone1 }}</a>
                      </li>
                      @if ($user->telephone2 != '')
                          <li class="list-group-item">
                              <b>Seconde téléphone</b> <a class="float-right">{{ $user->telephone2 }}</a>
                          </li>
                      @endif
                      <li class="list-group-item">
                          <b>Adresse</b> <a class="float-right">{{ $user->adresse }}</a>
                      </li>
                  </ul>
              </div>

          </div>
      </div>
      <div class="col-md-7 card card-primary">
          <div class="card-header">
              <h3 class="card-title"> <i class="fas fa-fingerprint"></i> Permissions</h3>
          </div>

          <div class="card-body" style="max-height: 375px; overflow-y: scroll;"> 
            {{-- La liste des permissions --}}
              <strong><i class="fas fa-fingerprint mr-1"></i> Permissions</strong>
              <ul class="my-2">
                @foreach (($user->permissions->pluck('name')) as $item)
                <li class="text-muted"> {{ Str::before(Str::title($item), '.*') }} </li>                  
                @endforeach
              </ul>
              
              {{-- @isset ($user->roles)
              <p class="text-muted">Aucun permission trouvé !</p>
              @endisset --}}
          </div>

      </div>
  </div>
</div>