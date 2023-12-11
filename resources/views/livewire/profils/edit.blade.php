<div class="modal fade @if ($editModal) show @endif" id="editProfil"
    @if ($editModal) style="display: block;" @else style="display: none;" @endif aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent">
            <div class="modal-body p-0">
                <div class="card card-primary shadow-lg mb-0"
                    style="transition: all 0.15s ease 0s; height: 100%; width: 100%;">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-edit fa-2x mr-2"></i> Modifier mon profil</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                                <i class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn btn-warning" wire:click='updateProfil'>
                                <i class="fa fa-save"></i> <i class="fa fa-spinner fa-spin" wire:loading
                                    wire:target='updateProfil'></i>
                                Enregistrer la modification</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" spellcheck="false"
                                data-dismiss="modal">
                                <i class="fa fa-chevron-left mr-2"> Annuler</i>
                            </button>
                        </div>

                    </div>

                    <div class="card-body row">
                        <div class="col-md-6 card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="row">
                                    {{-- <div class="col-12 d-flex flex-md-column">
                                        @if ($editProfil != [])
                                            <label class="d-flex flex-column justify-content-center">
                                                <img class="profile-user-img img-fluid img-circle"
                                                    src="{{ $editProfil['profil'] ? asset('storage/' . $editProfil['profil']) : 'https://eu.ui-avatars.com/api/?name=' . $editProfil['nom'] . '&background=random' }}"
                                                    alt="Etudiant profile picture">
                                            </label>
                                        @else
                                            <img class="profile-user-img img-fluid img-circle" src=""
                                                alt="Etudiant profile picture">
                                        @endif
                                    </div> --}}
                                    <div class="col-12 d-flex flex-md-column">
                                        @if ($editProfil != [])
                                            <label class="d-flex flex-column justify-content-center w-25 m-auto">
                                                @if ($photo)
                                                    <img class="profile-user-img img-fluid img-circle"
                                                        src="{{ $photo->temporaryUrl() }}">
                                                    <button class="btn btn-warning btn-sm mt-2" wire:click="set('photo', '')">Reset</button>
                                                @else
                                                    <img class="profile-user-img img-fluid img-circle"
                                                        src="{{ $editProfil['profil'] ? asset('storage/' . $editProfil['profil']) : 'https://eu.ui-avatars.com/api/?name=' . $editProfil['nom'] . '&background=random' }}"
                                                        alt="Etudiant profile picture">
                                                @endif
                                                <input type="file" wire:model='photo' style="display: none;">
                                            </label>
                                        @else
                                            <img class="profile-user-img img-fluid img-circle" src=""
                                                alt="Etudiant profile picture">
                                        @endif
                                        <i class="fa fa-spinner fa-spin text-center fa-2x" wire:loading
                                            wire:target='photo'
                                            style="position: absolute; top:20%; left:48%; color:#FFC107;"></i>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="userNom">Nom</label>
                                            <input type="text"
                                                class="form-control @error('editProfil.nom') is-invalid @enderror"
                                                id="userNom" wire:model='editProfil.nom'>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="userPrenom">Prénom</label>
                                            <input type="text"
                                                class="form-control @error('editProfil.prenom') is-invalid @enderror"
                                                id="userPrenom" wire:model='editProfil.prenom'>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="userSexe">Sexe</label>
                                            <select class="custom-select @error('editProfil.sexe') is-invalid @enderror"
                                                spellcheck="false" id="userSexe" wire:model='editProfil.sexe'>
                                                <option value=""> --- --- </option>
                                                <option value="M">Homme</option>
                                                <option value="F">Femme</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="userNationalite">Nationalité</label>
                                            <input type="text" class="form-control" id="userNationalite"
                                                wire:model='editProfil.nationalite'>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="userAddr">Adresse</label>
                                            <input type="text"
                                                class="form-control @error('editProfil.adresse') is-invalid @enderror"
                                                id="userAddr" wire:model='editProfil.adresse'>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="userEmail">Email</label>
                                            <input type="text"
                                                class="form-control @error('editProfil.email') is-invalid @enderror"
                                                id="userEmail" wire:model='editProfil.email'>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="userPhone1">Téléphone</label>
                                            <input type="text"
                                                class="form-control @error('editProfil.telephone1') is-invalid @enderror"
                                                id="userPhone1" wire:model='editProfil.telephone1'>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="userPhone2">Seconde téléphone</label>
                                            <input type="text" class="form-control" id="userPhone2"
                                                wire:model='editProfil.telephone2'>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-6 card card-primary card-outline row p-0">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-user-circle mr-3"></i> Modifier mon mot de
                                    passe</h3>
                                <div class="card-tools">
                                    <i class="fa fa-user-check"></i>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Nouveau mot de passe">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Confirme mot de passe">
                                </div>
                                <div class="text-right">
                                    <a class="btn btn-link btn-sm text-info" href="#">Mot de passe oublier</a><i class="fa fa-lock fa-sm text-info"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
