<div class="card card-primary shadow-lg m-0 p-0" style="transition: all 0.15s ease 0s; background:rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">
  

  <div class="card-body p-0 m-0">
      <div class="d-flex justify-content-centr flex-column mr-1">
          <div class="card card-primary card-outline bg-transparent">
              <div class="card-body box-profile">
                  <div class="text-center">
                      <img class="profile-user-img img-fluid img-circle"
                          src="{{  $showUser?->profil != null ? asset('storage/'.  $showUser?->profil) : 'https://eu.ui-avatars.com/api/?name=' .   $showUser?->nom . '&background=random' }}"
                          alt="Etudiant profile picture">
                  </div>
                  <h3 class="profile-username text-center text-white">{{   $showUser?->sexe == 'F' ? 'Mme/Mlle' : 'Mr' }} {{   $showUser?->nom }} {{   $showUser?->prenom }}</h3>
                  <p class="text-center text-white"> {{ Auth::user()->roles->implode('name', ' | ')}} </p>
                  
                  <ul class="list-group list-group-unbordered mb-3 text-white">
                      <li class="list-group-item bg-transparent">
                          <b>Email</b> <a class="float-right text-light">{{   $showUser?->email }}</a>
                      </li>
                      <li class="list-group-item bg-transparent">
                          <b>Téléphone</b> <a class="float-right text-light">{{   $showUser?->telephone1 }}</a>
                      </li>
                      @if ( Auth::user()->telephone2 != '')
                          <li class="list-group-item bg-transparent">
                              <b>Seconde téléphone</b> <a class="float-right text-light">{{   $showUser?->telephone2 }}</a>
                          </li>
                      @endif
                      <li class="list-group-item bg-transparent">
                          <b>Nationalité</b> <a class="float-right text-light">{{   $showUser?->nationalite }}</a>
                      </li>
                      <li class="list-group-item bg-transparent">
                          <b>Adresse</b> <a class="float-right text-light">{{  $showUser?->adresse }}</a>
                      </li>
                  </ul>
              </div>

          </div>
      </div>
      <div class="d-flex justify-content-end mb-2">       
        <button class="btn btn-danger btn-sm mx-2" data-toggle="modal" 
        spellcheck="false" data-dismiss="modal">Fermer</button>
      </div>
      {{-- @json($showUser) --}}

  </div>
</div>