<div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; height: 100%; width: 100%;">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-edit fa-2x mr-2"></i> Nouveau utilisateur</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                <i class="fas fa-expand"></i>
            </button>
            <button type="button" class="btn btn-danger" wire:click="toogleSectionName('list')">
                <i class="fa fa-chevron-left mr-2"> Retour à la list des utilisateur</i>
            </button>
        </div>

    </div>

    <div class="card-body row">
        <div class="col-md-6 card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content">
                        @if ($photo)
                            <div class="mr-4">
                                <img class="profile-user-img img-fluid img-circle" src="{{ $photo->temporaryUrl() }}">
                            </div>
                        @endif
                        <div class="mr-4 my-auto" wire:loading wire:target="photo">
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Image profil</label>
                            <div class="btn-group w-100">
                                <label for="userProfil" class="btn btn-success col fileinput-button dz-clickable">
                                    <i class="fas fa-plus"></i>
                                    <input type="file" id="userProfil" wire:model='photo' style="display: none;">
                                    <span>Ajouter un image</span>
                                </label>
                                <label type="reset" class="btn btn-warning col cancel" wire:click="set('photo', '')">
                                    <i class="fas fa-times-circle"></i>
                                    <span>Annuler</span>
                                </label>
                                @error('photo')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="etudiantProfil"
                                        wire:model='photo'>
                                    <label class="custom-file-label" for="etudiantProfil">Choisir un
                                        image</label>
                                    @error('photo')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="userNom">Nom</label>
                            <input type="text" class="form-control @error('newUser.nom') is-invalid @enderror"
                                id="userNom" wire:model='newUser.nom'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="userPrenom">Prénom</label>
                            <input type="text" class="form-control @error('newUser.prenom') is-invalid @enderror"
                                id="userPrenom" wire:model='newUser.prenom'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="userSexe">Sexe</label>
                            <select class="custom-select @error('newUser.sexe') is-invalid @enderror" spellcheck="false"
                                id="userSexe" wire:model='newUser.sexe'>
                                <option value=""> --- --- </option>
                                <option value="M">Homme</option>
                                <option value="F">Femme</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="form-group">
                            <label for="userNationalite">Nationalité</label>
                            <input type="text" class="form-control" id="userNationalite"
                                wire:model='newUser.nationalite'>
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userAddr">Adresse</label>
                            <input type="text" class="form-control @error('newUser.adresse') is-invalid @enderror"
                                id="userAddr" wire:model='newUser.adresse'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userEmail">Email</label>
                            <input type="text" class="form-control @error('newUser.email') is-invalid @enderror"
                                id="userEmail" wire:model='newUser.email'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userPhone1">Téléphone</label>
                            <input type="text" class="form-control @error('newUser.telephone1') is-invalid @enderror"
                                id="userPhone1" wire:model='newUser.telephone1'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userPhone2">Seconde téléphone</label>
                            <input type="text" class="form-control" id="userPhone2" wire:model='newUser.telephone2'>
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
                    @foreach ($roles as $role)
                        <div class="custom-control custom-checkbox mx-3">
                            <input class="custom-control-input" type="radio" name="userId"
                                id="customCheckbox{{ $role->id }}" wire:model='newUser.role_id' value="{{$role->name}}" />
                            <label for="customCheckbox{{ $role->id }}"
                                class="custom-control-label">{{ $role->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card card-primary card-outline mb-0" style="height: 250px;">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-fingerprint mr-3"></i> Permissions</h3>
                    <div class="card-tools">
                        <input class="custom-control-input custom-control-input-warning custom-control-input-outline" type="checkbox" id="allSelectPermissions" name="allSelectPermissions" wire:model.lazy="allSelectePermissions" wire:click.live="selectAllPermission" />
                        <label for="allSelectPermissions" class="custom-control-label">Séléctioner toutes</label>
                        <i class="fas fa-user-check"></i>
                    </div>

                </div>

                <div class="card-body p-0" style="overflow-y: scroll;">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Permissions</th>
                                <th>choix</th>
                                <th class="text-center" style="width: 15%">status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rolePermissionList['permissions'] as $permission)
                            <tr>
                                <td> {{ $loop->index + 1 }} </td>
                                <td> {{Str::before( $permission['nom'], '.*') }} </td>
                                <td>
                                    <div class="form-group">
                                        <div
                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch{{ $permission['id'] }}" wire:model.live='rolePermissionList.permissions.{{ $loop->index }}.active' />
                                            <label class="custom-control-label" for="customSwitch{{ $permission['id'] }}"></label>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{$permission['active'] ? 'bg-success' : 'bg-danger'}} "> {{$permission['active'] ? 'Activé' : 'Desactivé'}} </span>
                                </td>
                            </tr> 
                            @endforeach
                                
                        </tbody>
                    </table>
                </div>

            </div>
            <button class="btn btn-info m-2" wire:click='addNewUser'>Envoyé</button>
        </div>
    </div>
</div>
