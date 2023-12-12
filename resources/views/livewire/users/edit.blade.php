<div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; height: 100%; width: 100%;">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-edit fa-2x mr-2"></i> Modifier profil d'utilisateur</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                <i class="fas fa-expand"></i>
            </button>
            <button type="button" class="btn btn-warning" data-toggle="modal" spellcheck="false" data-dismiss="modal"
                @if ($editUser != []) wire:click='updateUser' @endif>
                <i class="fa fa-save"></i> <i class="fa fa-spinner fa-spin" wire:loading wire:target='updateUser'></i>
                Enregistrer la modification</button>
            <button type="button" class="btn btn-danger" wire:click="toogleSectionName('list')">
                <i class="fa fa-chevron-left mr-2"> Retour</i>
            </button>
        </div>

    </div>

    <div class="card-body row">
        <div class="col-md-6 card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="row">
                    <div class="col-12 d-flex flex-md-column">
                        @if ($editUser != [])
                            <label class="d-flex flex-column justify-content-center">
                                @if ($photo)
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ $photo->temporaryUrl() }}">
                                @else
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ $editUser['profil'] ? asset('storage/' . $editUser['profil']) : 'https://eu.ui-avatars.com/api/?name=' . $editUser['nom'] . '&background=random' }}"
                                        alt="Etudiant profile picture">
                                @endif
                                <input type="file" wire:model='photo' style="display: none;">
                            </label>
                        @else
                            <img class="profile-user-img img-fluid img-circle" src=""
                                alt="Etudiant profile picture">
                        @endif
                        <i class="fa fa-spinner fa-spin text-center fa-2x" wire:loading wire:target='photo'
                            style="position: absolute; top:20%; left:48%; color:#FFC107;"></i>
                        {{-- <label class="text-center"> Rôle : <input type="text"
                              class="form-control text-center bg-primary" disabled> {{$editUser->role->nom}} </label> --}}
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="userNom">Nom</label>
                            <input type="text" class="form-control @error('editUser.nom') is-invalid @enderror"
                                id="userNom" wire:model='editUser.nom'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="userPrenom">Prénom</label>
                            <input type="text" class="form-control @error('editUser.prenom') is-invalid @enderror"
                                id="userPrenom" wire:model='editUser.prenom'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="userSexe">Sexe</label>
                            <select class="custom-select @error('editUser.sexe') is-invalid @enderror"
                                spellcheck="false" id="userSexe" wire:model='editUser.sexe'>
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
                                wire:model='editUser.nationalite'>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="userAddr">Adresse</label>
                            <input type="text" class="form-control @error('editUser.adresse') is-invalid @enderror"
                                id="userAddr" wire:model='editUser.adresse'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userEmail">Email</label>
                            <input type="text" class="form-control @error('editUser.email') is-invalid @enderror"
                                id="userEmail" wire:model='editUser.email'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userPhone1">Téléphone</label>
                            <input type="text"
                                class="form-control @error('editUser.telephone1') is-invalid @enderror" id="userPhone1"
                                wire:model='editUser.telephone1'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userPhone2">Seconde téléphone</label>
                            <input type="text" class="form-control" id="userPhone2"
                                wire:model='editUser.telephone2'>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-md-6 card card-primary card-outline row p-0">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-user-circle mr-3"></i> Rôle</h3>
                <div class="card-tools">
                    <i class="fa fa-user-check"></i>
                </div>

            </div>

            <div class=" card-body col-md-12 ">
                <div class="row">
                    @foreach ($rolePermissionList['roles'] as $role)
                        <div class="custom-control custom-radio mx-3">
                            <input
                                class="custom-control-input custom-control-input-warning custom-control-input-outline"
                                type="checkbox" id="customCheckbox{{ $role['id'] }}" name="roleUser" @if ($role['active'])
                                    checked=''  @endif wire:model.lazy='rolePermissionList.roles.{{ $loop->index }}.active'/>
                                <label for="customCheckbox{{ $role['id'] }}"
                                class="custom-control-label">{{ $role['nom'] }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card card-primary card-outline mb-0" style="min-height: 250px;">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-user-circle mr-3"></i> Permissions</h3>
                    <div class="card-tools">
                        <i class="fas fa-fingerprint"></i>
                    </div>

                </div>

                <div class="card-body p-0">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Permissions</th>
                                <th>choix</th>
                                <th style="width: 40px">status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> 1. </td>
                                <td>Permission d'ajout de cours</td>
                                <td>
                                    <div class="form-group">
                                        <div
                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1" wire:model.live='permission'>
                                            <label class="custom-control-label" for="customSwitch1"></label>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge {{$permission ? 'bg-success' : 'bg-danger'}} "> {{$permission ? 'Activé' : 'Desactivé'}} </span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
