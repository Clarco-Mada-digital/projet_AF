<div class="row mx-4 pt-4" >
    <div class="col-md-12 d-flex align-items-center justify-content-between my-3">
        <h3>Nouveaux étudiants: </h3>
        <form action="">
            <div class="input-group input-group-lg">
                <input type="search" class="form-control form-control-lg" placeholder="Chercher l'information du membre"
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
                    <i class="fa fa-list mr-2"></i> Voir la liste d'étudiants
                </a>
            </div>
            <div class="card-body p-0">
                <div class="bs-stepper" id="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">

                        <div class="step @if ($bsSteepActive == 1) active @endif" data-target="#info-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="info-part"
                                id="logins-part-trigger" @if ($bsSteepActive != 1) disabled="disabled" @endif>
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Information étudiant</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step @if ($bsSteepActive == 2) active @endif" data-target="#cour-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="cour-part"
                                id="information-part-trigger"
                                @if ($bsSteepActive != 2) disabled="disabled" @endif>
                                <span class="bs-stepper-circle bg-gradient-info">2</span>
                                <span class="bs-stepper-label text-info">Choix des cours</span>
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
                                        <div class="form-group">
                                            <label for="exampleInputFile">Image profil</label>
                                            <div class="input-group">
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantNom">Nom</label>
                                            <input type="text" class="form-control" id="etudiantNom"
                                                wire:model="newEtudiant.nom">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantPrenom">Prénom</label>
                                            <input type="text" class="form-control" id="etudiantPrenom"
                                                wire:model='newEtudiant.prenom'>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantPrenom">Sexe</label>
                                            <select class="custom-select" spellcheck="false" id="etudiantSexe"
                                                wire:model='newEtudiant.sexe'>
                                                <option> --- --- </option>
                                                <option value="M">Homme</option>
                                                <option value="F">Femme</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantBirth">Date de naissance</label>
                                            <input type="date" class="form-control" id="etudiantBirth"
                                                wire:model='newEtudiant.dateNaissance'>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantProfession">Nationalité</label>
                                            <input type="text" class="form-control" id="etudiantNationalite"
                                                wire:model='newEtudiant.nationalite'>
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
                                            <input type="text" class="form-control" id="etudiantAddr"
                                                wire:model='newEtudiant.adresse'>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantEmail">Email</label>
                                            <input type="text" class="form-control" id="etudiantEmail"
                                                wire:model='newEtudiant.email'>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantPhone">Téléphone</label>
                                            <input type="text" class="form-control" id="etudiantPhone"
                                                wire:model='newEtudiant.telephone1'>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantPhone">Seconde téléphone</label>
                                            <input type="text" class="form-control" id="etudiantPhone"
                                                wire:model='newEtudiant.telephone2'>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input custom-control-input-danger"
                                                    type="checkbox" id="newMembre">
                                                <label for="newMembre" class="custom-control-label">Confirmer que
                                                    c'est un nouveaux membre</label>
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
                                            <select class="custom-select" spellcheck="false" id="Sessions">
                                                <option>Session 002 23</option>
                                                <option>Session 001 24</option>
                                                <option>Session 002 24</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantNiveau">Niveaux</label>
                                            <select class="custom-select" spellcheck="false" id="etudiantNiveau"
                                                wire:model='newEtudiant.level_id'>
                                                <option> --- --- </option>
                                                <option value="1">Niveau Debutante</option>
                                                <option value="2">Niveau Intermediaire</option>
                                                <option value="3">Niveau avancée</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Liste des cours</h3>
                                        </div>
                                        <div class="card-body row">
                                            @foreach ($nscList['cours'] as $cour)
                                                <div class="form-group col-md-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="cour{{ $cour['cour_id'] }}"
                                                            @if ($cour['active']) checked @endif
                                                            wire:model.lazy="nscList.cours.{{ $loop->index }}.active">
                                                        <label for="cour{{ $cour['cour_id'] }}"
                                                            class="custom-control-label">{{ $cour['cour_nom']}}</label>
                                                    </div>
                                                </div>
                                            @endforeach
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
                                            <span class="info-box-number" style="font-size: 1.5rem;">20.000Ar</span>
                                        </div>

                                    </div>
                                    <div class="col-md-12 card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Paiement par</h3>
                                        </div>
                                        <div class="card-body row">
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="espece"
                                                    name="paiementPar">
                                                <label for="espece" class="custom-control-label">Espèce</label>
                                            </div>
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="cheque"
                                                    name="paiementPar">
                                                <label for="cheque" class="custom-control-label"> Chèque</label>
                                            </div>
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="carte"
                                                    name="paiementPar">
                                                <label for="carte" class="custom-control-label">Carte
                                                    banquaire</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Statue de paiement</h3>
                                        </div>
                                        <div class="card-body row">
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="totale"
                                                    name="statuePaiement">
                                                <label for="totale" class="custom-control-label">Totalement
                                                    payé</label>
                                            </div>
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="moitier"
                                                    name="statuePaiement">
                                                <label for="moitier" class="custom-control-label"> A moitier
                                                    paiyé</label>
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
                                    <div class="card-body row">
                                        <div class="col-md-6">
                                            <button class="btn btn-success">Generer un facture</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-success">Envoyé la facture par email</button>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-primary" wire:click="bsSteepPrevNext('prev')">Précedent</a>
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
