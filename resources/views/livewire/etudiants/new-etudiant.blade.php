<div class="row mx-4 pt-4">
    <div class="col-md-12 d-flex align-items-center justify-content-between my-3">
        <h3>Nouvel étudiant: </h3>
        <form action="">
            <div class="input-group input-group-lg">
                <input type="search" class="form-control form-control-lg" placeholder="Chercher les informations du membre"
                    value="" spellcheck="false" style="width:400px;">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-lg btn-info">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-12">
        <div class="card card-default m-0">
            <div class="card-header bg-gradient-primary w-100 d-flex align-items-center">
                <h3 class="card-title flex-grow-1"><i class="fa fa-pen mr-2"></i> Formulaire d'inscription</h3>
                <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                    <i class="fas fa-expand"></i>
                </button>
                <a href="{{ route('etudiants-list') }}" type="button" class="btn btn-info">
                    <i class="fa fa-list mr-2"></i> Voir la liste des étudiants
                </a>
            </div>
            <div class="card-body p-0">
                <div class="bs-stepper" id="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">

                        <div class="step @if ($bsSteepActive == 1) active @endif" data-target="#info-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="info-part"
                                id="logins-part-trigger" @if ($bsSteepActive != 1) disabled="disabled" @endif>
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Information sur l'étudiant</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step @if ($bsSteepActive == 2) active @endif" data-target="#cour-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="cour-part"
                                id="information-part-trigger"
                                @if ($bsSteepActive != 2) disabled="disabled" @endif>
                                <span class="bs-stepper-circle bg-gradient-info">2</span>
                                <span class="bs-stepper-label text-info">Choix du cours</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step @if ($bsSteepActive == 3) active @endif" data-target="#paiement-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="paiement-part"
                                id="information-part-trigger"
                                @if ($bsSteepActive != 3) disabled="disabled" @endif>
                                <span class="bs-stepper-circle bg-gradient-warning">3</span>
                                <span class="bs-stepper-label text-warning">Paiement</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step @if ($bsSteepActive == 4) active @endif" data-target="#facture-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="facture-part"
                                id="information-part-trigger"
                                @if ($bsSteepActive != 4) disabled="disabled" @endif>
                                <span class="bs-stepper-circle bg-gradient-success">4</span>
                                <span class="bs-stepper-label text-success">Facture</span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <form wire:submit="submitNewEtudiant">
                            <div id="info-part" @if ($bsSteepActive != 1) style="display: none;" @endif>
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content">
                                        @if ($photo)
                                            <div class="mr-4">
                                                <img class="profile-user-img img-fluid img-circle"
                                                    src="{{ $photo->temporaryUrl() }}">
                                            </div>
                                        @endif
                                        <div class="mr-4 my-auto" wire:loading wire:target="photo">
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Photo de profil</label>
                                            <div class="btn-group w-100">
                                                <label for="etudiantProfil" class="btn btn-success col fileinput-button dz-clickable">
                                                    <i class="fas fa-plus"></i>
                                                    <input type="file" id="etudiantProfil" wire:model='photo' style="display: none;">
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantNom">Nom</label>
                                            <input type="text"
                                                class="form-control 
                                                @error('newEtudiant.nom') is-invalid @enderror"
                                                id="etudiantNom" wire:model="newEtudiant.nom">
                                            @error('newEtudiant.nom')
                                                <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantPrenom">Prénom</label>
                                            <input type="text"
                                                class="form-control 
                                                @error('newEtudiant.prenom') is-invalid @enderror"
                                                id="etudiantPrenom" wire:model='newEtudiant.prenom'>
                                            @error('newEtudiant.prenom')
                                                <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantPrenom">Sexe</label>
                                            <select
                                                class="custom-select 
                                                @error('newEtudiant.sexe') is-invalid @enderror"
                                                spellcheck="false" id="etudiantSexe" wire:model='newEtudiant.sexe'>
                                                <option> --- --- </option>
                                                <option value="M">Homme</option>
                                                <option value="F">Femme</option>
                                            </select>
                                            @error('newEtudiant.sexe')
                                                <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantBirth">Date de naissance</label>
                                            <input type="date"
                                                class="form-control 
                                                @error('newEtudiant.dateNaissance') is-invalid @enderror"
                                                id="etudiantBirth" wire:model='newEtudiant.dateNaissance'>
                                            @error('newEtudiant.dateNaissance')
                                                <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantProfession">Nationalité</label>
                                            <input type="text"
                                                class="form-control 
                                                @error('newEtudiant.nationalite') is-invalid @enderror"
                                                id="etudiantNationalite" wire:model='newEtudiant.nationalite'>
                                            @error('newEtudiant.nationalite')
                                                <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantProfession">Profession</label>
                                            <input type="text" class="form-control" id="etudiantProfession"
                                                wire:model='newEtudiant.profession'>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantAddr">Adresse</label>
                                            <input type="text"
                                                class="form-control 
                                                @error('newEtudiant.adresse') is-invalid @enderror"
                                                id="etudiantAddr" wire:model='newEtudiant.adresse'>
                                            @error('newEtudiant.adresse')
                                                <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantEmail">Email</label>
                                            <input type="text"
                                                class="form-control 
                                                @error('newEtudiant.email') is-invalid @enderror"
                                                id="etudiantEmail" wire:model='newEtudiant.email'>
                                            @error('newEtudiant.email')
                                                <span class="invalid-feedback"> Ce champ est obligatoire | unique</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantPhone">Téléphone</label>
                                            <input type="text"
                                                class="form-control 
                                                @error('newEtudiant.telephone1') is-invalid @enderror"
                                                id="etudiantPhone" wire:model='newEtudiant.telephone1'>
                                            @error('newEtudiant.telephone1')
                                                <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantPhone">Second téléphone</label>
                                            <input type="text" class="form-control" id="etudiantPhone"
                                                wire:model='newEtudiant.telephone2'>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input class="custom-control-input custom-control-input-info"
                                                    type="checkbox" id="newMembre">
                                                <label for="newMembre" class="custom-control-label">Confirmer que
                                                    c'est un nouveau membre</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-primary" wire:click="bsSteepPrevNext('next')">Suivant</a>
                            </div>
                            <div id="cour-part" @if ($bsSteepActive != 2) style="display: none;" @endif>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Sessions">Session</label>
                                            <select class="custom-select" spellcheck="false" id="Sessions"
                                                wire:model='etudiantSession' wire:click.live='updateCoursList'>
                                                <option value='null'> --- Session --- </option>
                                                @foreach ($listSession as $session)
                                                    @if ($session->dateFin > $now)
                                                        <option value="{{ $session->id }}"> {{ $session->nom }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantNiveau">Niveau</label>
                                            <select class="custom-select" spellcheck="false" id="etudiantNiveau"
                                                wire:model='newEtudiant.level_id' wire:click.live='updateCoursList'>
                                                <option> --- --- </option>
                                                @forelse ($levels as $level)
                                                    <option value="{{ $level->id }}"> {{ $level->nom }}</option>
                                                @empty
                                                    <option value="2"> Donné non trouvé </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Liste des cours</h3>
                                        </div>
                                        <div class="card-body row">
                                            @forelse ($nscList['cours'] as $cour)
                                                <div class="form-group col-md-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="cour{{ $cour['cour_id'] }}"
                                                            @if ($cour['active']) checked @endif
                                                            wire:model.lazy="nscList.cours.{{ $loop->index }}.active">
                                                        <label for="cour{{ $cour['cour_id'] }}"
                                                            class="custom-control-label">{{ $cour['cour_libelle'] }}</label>
                                                    </div>
                                                </div>
                                            @empty
                                                <h3>Aucun donnée trouvé !</h3>
                                            @endforelse
                                            {{-- <div class="form-group col-md-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="courFrancais">
                                                        <label for="courFrancais" class="custom-control-label">Cour
                                                            Français</label>
                                                    </div>
                                                </div> --}}

                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-primary" wire:click="bsSteepPrevNext('prev')">Précedent</a>
                                <a class="btn btn-primary" wire:click="bsSteepPrevNext('next')">Suivant</a>
                            </div>
                            <div id="paiement-part" @if ($bsSteepActive != 3) style="display: none;" @endif>
                                <div class="row">
                                    <div class="info-box col-md-3 mb-3 bg-warning">
                                        <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Montant total</span>
                                            @if ($etudiantSession != null)
                                                <span class="info-box-number" style="font-size: 1.5rem;">
                                                    {{ $sessionSelected->montant }} Ar</span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-md-12 card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Paiement par</h3>
                                        </div>
                                        <div class="card-body row">
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="espece"
                                                    name="paiementPar" wire:model='moyenPaiment'>
                                                <label for="espece" class="custom-control-label">Espèce</label>
                                            </div>
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="cheque"
                                                    name="paiementPar" wire:model='moyenPaiment'>
                                                <label for="cheque" class="custom-control-label"> Chèque</label>
                                            </div>
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="carte"
                                                    name="paiementPar" wire:model='moyenPaiment'>
                                                <label for="carte" class="custom-control-label">Carte
                                                    bancaire</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Status de paiement</h3>
                                        </div>
                                        <div class="card-body row">
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="moitier"
                                                    name="statuePaiement" wire:model='statue'>
                                                <label for="moitier" class="custom-control-label"> A moitié
                                                    payé</label>
                                            </div>
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="totale"
                                                    name="statuePaiement" wire:model='statue'>
                                                <label for="totale" class="custom-control-label">Totalement
                                                    payé</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-primary" wire:click="bsSteepPrevNext('prev')">Précedent</a>
                                <a class="btn btn-primary" wire:click="bsSteepPrevNext('next')">Suivant</a>
                            </div>
                            <div id="facture-part" @if ($bsSteepActive != 4) style="display: none;" @endif>
                                <div class="col-md-12 card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Facturation</h3>
                                    </div>
                                    <div class="card-body mx-auto w-100">
                                        <div class="text-center">
                                            <img class="w-25" src="{{ asset('images/facture.jpg') }}"
                                                alt="prevision facture">
                                        </div>
                                        <div class="custom-control custom-switch text-center my-3">
                                            <input class="custom-control-input custom-control-input-info"
                                                type="checkbox" id="generetFactur">
                                            <label for="generetFactur" class="custom-control-label">Imprimer la facture après l'inscription.</label>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-primary" wire:click="bsSteepPrevNext('prev')">Précedent</a>
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-paper-plane"></i> <i class="fa fa-spinner fa-spin"
                                        wire:loading='submitNewEtudiant' wire:target='submitNewEtudiant'></i>
                                    Finir l'inscription</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
