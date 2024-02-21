<div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; height: 100%; width: 100%;">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-edit fa-2x mr-2"></i> Modifier profil etudiant</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                <i class="fas fa-expand"></i>
            </button>
            <button type="button" class="btn btn-warning" data-toggle="modal" spellcheck="false" data-dismiss="modal"
                @if ($editEtudiant !=[]) wire:click='updateEtudiant({{ $editEtudiant['id'] }})' @endif>
                <i class="fa fa-save"></i> <i class="fa fa-spinner fa-spin" wire:loading
                    wire:target='updateEtudiant'></i> Enregistrer la modification</button>
            <button type="button" class="btn btn-danger" wire:click="toogleStateName('view')">
                <i class="fa fa-chevron-left mr-2"> Retour</i>
            </button>
        </div>

    </div>

    <div class="card-body row">
        <div class="col-md-6 card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="row">
                    <div class="col-12 d-flex flex-md-column">
                        @if ($editEtudiant != [])
                        <label class="d-flex flex-column justify-content-center w-25 mx-auto">
                            @if ($photo)
                            <img class="profile-user-img img-fluid img-circle" src="{{ $photo->temporaryUrl() }}">
                            <button class="btn btn-warning btn-sm mt-2" wire:click="set('photo', '')">Reset</button>
                            @else
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ $editEtudiant['profil'] ? asset('storage/' . $editEtudiant['profil']) : 'https://eu.ui-avatars.com/api/?name=' . $editEtudiant['nom'] . '&background=random' }}"
                                alt="Etudiant profile picture">
                            @endif
                            <input type="file" wire:model='photo' style="display: none;">
                            @error('editEtudiant.profil')
                            <span class="invalid-feedback">Image invalide</span>
                            @enderror
                        </label>
                        @else
                        <img class="profile-user-img img-fluid img-circle" src="" alt="Etudiant profile picture">
                        @endif
                        <i class="fa fa-spinner fa-spin text-center fa-2x" wire:loading wire:target='photo'
                            style="position: absolute; top:20%; left:48%; color:#FFC107;"></i>
                        <label class="text-center"> N° Carte : <input type="text"
                                class="form-control text-center bg-primary" disabled
                                wire:model='editEtudiant.numCarte'></label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="etudiantNom">Nom</label>
                            <input type="text" class="form-control @error('editEtudiant.nom') is-invalid @enderror"
                                id="etudiantNom" wire:model='editEtudiant.nom'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="etudiantPrenom">Prénom</label>
                            <input type="text" class="form-control @error('editEtudiant.prenom') is-invalid @enderror"
                                id="etudiantPrenom" wire:model='editEtudiant.prenom'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="etudiantPrenom">Sexe</label>
                            <select class="custom-select @error('editEtudiant.sexe') is-invalid @enderror"
                                spellcheck="false" id="etudiantPrenom" wire:model='editEtudiant.sexe'>
                                <option value=""> --- --- </option>
                                <option value="M">Homme</option>
                                <option value="F">Femme</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="etudiantBirth">Date de naissance</label>
                            <input type="date"
                                class="form-control @error('editEtudiant.dateNaissance') is-invalid @enderror"
                                id="etudiantBirth" wire:model='editEtudiant.dateNaissance'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="etudiantProfession">Nationalité</label>
                            <input type="text" class="form-control" id="etudiantNationalite"
                                wire:model='editEtudiant.nationalite'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="etudiantProfession">Profession</label>
                            <input type="text" class="form-control" id="etudiantProfession"
                                wire:model='editEtudiant.profession'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="etudiantAddr">Adresse</label>
                            <input type="text" class="form-control @error('editEtudiant.adresse') is-invalid @enderror"
                                id="etudiantAddr" wire:model='editEtudiant.adresse'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="etudiantEmail">Email</label>
                            <input type="text" class="form-control @error('editEtudiant.email') is-invalid @enderror"
                                id="etudiantEmail" wire:model='editEtudiant.email'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="etudiantPhone">Téléphone</label>
                            <input type="text"
                                class="form-control @error('editEtudiant.telephone1') is-invalid @enderror"
                                id="etudiantPhone" wire:model='editEtudiant.telephone1'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="etudiantPhone">Seconde téléphone</label>
                            <input type="text" class="form-control" id="etudiantPhone"
                                wire:model='editEtudiant.telephone2'>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-md-6 card card-primary card-outline row">

            <div class=" card-body col-md-12 ">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Sessions">Session</label>
                            <select class="custom-select" spellcheck="false" id="Sessions"
                                wire:model='$etudiantSession' disabled>
                                @if ($listSession != null)
                                @foreach ($listSession as $session)
                                <option value="{{ $session['id'] }}"> {{ $session['nom'] }} </option>
                                @endforeach
                                @endif
                                {{-- <option>Session 001 24</option>
                                <option>Session 002 24</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="etudiantNiveau">Niveaux</label>
                            <select class="custom-select" spellcheck="false" id="etudiantNiveau"
                                wire:model='editEtudiant.level_id'>
                                <option> --- --- </option>
                                @foreach ($allLevel as $level)
                                <option value="{{ $level->id }}">{{ $level->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        @if ($nscList["examens"] != [])
                        <h4>List des examens</h4>
                        <div class="row mt-4">
                            <ul class="list-group ml-3">
                                @foreach ($nscList['examens'] as $examen)
                                @if ($examen['active'])
                                <li> {{ $examen['examen_libelle'] }} </li>
                                @endif
                            </ul>
                            @endforeach
                        </div>
                        @endif
                        @if ($nscList["cours"] != [])
                        <h4>List des cours</h4>
                        <div class="row mt-4">
                            <ul class="list-group ml-3">
                                @foreach ($nscList['cours'] as $cour)
                                @if ($cour['active'])
                                <li> {{ $cour['cour_libelle'] }} </li>
                                @endif
                            </ul>
                            @endforeach
                        </div>
                        @endif

                    </div>
                    {{-- <div class="form-group col-md-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="courFrancais">
                            <label for="courFrancais" class="custom-control-label">Cour
                                Français</label>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</div>