<aside class="control-sidebar control-sidebar-light" >

    <div class="pt-5">

        <div class="card card-widget widget-user-2">

            <div class="widget-user-header bg-primary">
                <div class="widget-user-image">
                    <img class="img-rounded elevation-2 mt-2"
                        src="{{ Auth::user()->profil ? asset('storage/' . Auth::user()->profil) : 'https://eu.ui-avatars.com/api/?name=' . Auth::user()->nom . '&background=random' }}"
                        alt="User Avatar">
                </div>

                <h3 class="widget-user-username fs-3">{{ Auth::user()->prenom . ' ' . Auth::user()->nom }}</h3>
                <h5 class="widget-user-desc fs-4">{{ Auth::user()->role->nom }}</h5>

            </div>
            <div class="card-body p-0 bg-light">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-toggle="modal" data-target="#viewProfil" spellcheck="false" wire:click='initUser({{ Auth::user()->role->id }})'>
                            Voir mon profil <span class="float-right badge bg-info"> <i class="fa fa-eye"></i> </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-toggle="modal"
                        data-target="#editProfil" spellcheck="false">
                            Mettre à jour mon profil <span class="float-right badge bg-primary"> <i
                                    class="fa fa-edit"></i> </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        @if (!$formChangePwd)                            
                            <a href="#" class="nav-link" wire:click='showFormPass'>
                                Modifer mon mot de passe <span class="float-right badge bg-warning"> 
                                <i class="fa fa-user-secret"></i> </span>
                            </a>
                        @else
                            <label class="fs-5 ml-2" for="newPwd">Nouveau mot de passe:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-secret"></i></span>
                                </div>
                                <input type="password" class="form-control" placeholder="Nouveau mot de passe" wire:model='newPwd' autocomplete="off">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user-secret"></i></span>
                                </div>
                                <input type="password" class="form-control" placeholder="Confirm mot de passe" wire:model='confPwd' autocomplete="off">
                            </div>
                            <div class="d-flex justify-content-center mb-2">
                                <button class="btn btn-warning btn-sm mx-2" wire:click='changePass'> <i class="fa fa-save"></i> <i class="fa fa-spin fa-spinner" wire:loading wire:target='changePass'></i> Confirmer</button>
                                <button class="btn btn-danger btn-sm mx-2" wire:click='showFormPass'> <i class="fa fa-times"></i> Annuler</button>
                            </div>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}<span class="float-right badge bg-danger"> <ion-icon
                                    name="log-out-outline"></ion-icon> </span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</aside>

