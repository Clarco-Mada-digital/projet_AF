<div class="row mx-4 pt-4">
    <div class="col-md-12 d-flex align-items-center justify-content-between my-3">
        <h3>Nouvel étudiant: </h3>

        {{-- section recherche --}}
        <div style="position: relative;">
            <div class="input-group input-group-lg">
                <input type="search" class="form-control form-control-lg"
                    placeholder="Chercher les informations du membre" value="" spellcheck="false" style="width:400px;"
                    wire:model.live="search" wire:keydown.enter="showEtudiant" />
                <div class="input-group-append">
                    <button type="submit" class="btn btn-lg btn-info">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            @if ($search != "")
            <div style="position: absolute; inset: 0px auto auto 0px; left: 0px; top: 50px; width: 400px; z-index: 10;">
                <div class=" list-group w-100 border bg-light border-primary rounded"
                    style="max-height: 300px; overflow-y: scroll;">
                    @forelse ($memberResult as $member)
                    <a href="#" class="list-group-item list-group-item-action 
                    @if ((Carbon\Carbon::parse($member->finAdhesion)->isPast())) text-danger @endif"
                    @if (!(Carbon\Carbon::parse($member->finAdhesion)->isPast())) wire:click='initData({{ $member->id }})' @endif >
                    {{ $member->nom }} {{ $member->prenom }} @if ($member->finAdhesion < Carbon\Carbon::today())
                        <i class="fa fa-info-circle text-right fa-2xl" title="Votre date de l'imite d'adhesion est dépassé !"></i>
                    @endif</a>
                    @empty
                    <p class="text-center pt-2">Aucun résultat trouvé 😔</p>
                    @endforelse
                </div>
            </div>
            @endif

        </div>

    </div>
    <div class="col-md-12" wire:ignore.self>
        <div class="card card-default m-0">

            {{-- Card header --}}
            <div class="card-header bg-gradient-primary w-100 d-flex align-items-center">
                <h3 class="card-title flex-grow-1"><i class="fa fa-pen mr-2"></i> Formulaire d'inscription</h3>
                <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                    <i class="fas fa-expand"></i>
                </button>
                <a href="{{ route('etudiants-list') }}" type="button" class="btn btn-info">
                    <i class="fa fa-list mr-2"></i> Voir la liste des étudiants
                </a>
            </div>

            {{-- Card body --}}
            <div class="card-body p-0">
                <div class="bs-stepper" id="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">

                        <div class="step @if ($bsSteepActive == 1) active @endif" data-target="#info-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="info-part"
                                id="logins-part-trigger" @if ($bsSteepActive !=1) disabled="disabled" @endif>
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Information sur l'étudiant</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step @if ($bsSteepActive == 2) active @endif" data-target="#cour-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="cour-part"
                                id="information-part-trigger" @if ($bsSteepActive !=2) disabled="disabled" @endif>
                                <span class="bs-stepper-circle bg-gradient-info">2</span>
                                <span class="bs-stepper-label text-info">Choix du cours</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step @if ($bsSteepActive == 3) active @endif" data-target="#paiement-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="paiement-part"
                                id="information-part-trigger" @if ($bsSteepActive !=3) disabled="disabled" @endif>
                                <span class="bs-stepper-circle bg-gradient-warning">3</span>
                                <span class="bs-stepper-label text-warning">Paiement</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step @if ($bsSteepActive == 4) active @endif" data-target="#facture-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="facture-part"
                                id="information-part-trigger" @if ($bsSteepActive !=4) disabled="disabled" @endif>
                                <span class="bs-stepper-circle bg-gradient-success">4</span>
                                <span class="bs-stepper-label text-success">Facture</span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <form wire:submit="submitNewEtudiant">
                            <div id="info-part" @if ($bsSteepActive !=1) style="display: none;" @endif>
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
                                                <label for="etudiantProfil"
                                                    class="btn btn-success col fileinput-button dz-clickable">
                                                    <i class="fas fa-plus"></i>
                                                    <input type="file" id="etudiantProfil" wire:model='photo'
                                                        style="display: none;">
                                                    <span>Ajouter un image</span>
                                                </label>
                                                <label type="reset" class="btn btn-warning col cancel"
                                                    wire:click="set('photo', '')">
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
                                            <input type="text" class="form-control 
                                                @error('newEtudiant.nom') is-invalid @enderror" id="etudiantNom"
                                                wire:model="newEtudiant.nom">
                                            @error('newEtudiant.nom')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantPrenom">Prénom</label>
                                            <input type="text" class="form-control 
                                                @error('newEtudiant.prenom') is-invalid @enderror" id="etudiantPrenom"
                                                wire:model='newEtudiant.prenom'>
                                            @error('newEtudiant.prenom')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantPrenom">Sexe</label>
                                            <select class="custom-select 
                                                @error('newEtudiant.sexe') is-invalid @enderror" spellcheck="false"
                                                id="etudiantSexe" wire:model='newEtudiant.sexe'>
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
                                            <input type="number" class="form-control 
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
                                            <input type="text" class="form-control 
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
                                            <input type="text" class="form-control 
                                                @error('newEtudiant.adresse') is-invalid @enderror" id="etudiantAddr"
                                                wire:model='newEtudiant.adresse'>
                                            @error('newEtudiant.adresse')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantEmail">Email</label>
                                            <input type="text" class="form-control 
                                                @error('newEtudiant.email') is-invalid @enderror" id="etudiantEmail"
                                                wire:model='newEtudiant.email'>
                                            @error('newEtudiant.email')
                                            <span class="invalid-feedback"> Ce champ est obligatoire | unique</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantNiveau">Catégorie</label>
                                            <select
                                                class="custom-select  @error('newEtudiant.categories') is-invalid @enderror"
                                                spellcheck="false" id="etudiantNiveau"
                                                wire:model='newEtudiant.categorie_id'>
                                                <option> --- --- </option>
                                                @forelse ($categories as $categorie)
                                                <option value="{{ $categorie->id }}"> {{ $categorie->libelle }}</option>
                                                @empty
                                                <option> Donné non trouvé </option>
                                                @endforelse
                                            </select>
                                            @error('newEtudiant.categories')
                                            <span class="invalid-feedback"> Ce champ est obligatoire | unique</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="etudiantPhone">Téléphone</label>
                                        <div class="input-group">
                                            {{-- <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div> --}}
                                            <input type="text"
                                                class="form-control phone @error('newEtudiant.telephone1') is-invalid @enderror"
                                                id="etudiantPhone" wire:model='newEtudiant.telephone1'>
                                            @error('newEtudiant.telephone1')
                                            <span class="invalid-feedback"> Le numéro de téléphone doit être au format: 032.00.000.00</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="etudiantPhone2">Second téléphone</label>
                                        <div class="input-group">
                                            {{-- <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div> --}}
                                            <input type="text"
                                                class="form-control phone @error('newEtudiant.telephone2') is-invalid @enderror"
                                                id="etudiantPhone2" wire:model='newEtudiant.telephone2'>
                                            @error('newEtudiant.telephone2')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input class="custom-control-input custom-control-input-info"
                                                    type="checkbox" id="newMembre" wire:model='noMember'
                                                    @if ($MemberPmb) disabled @endif>
                                                <label for="newMembre" class="custom-control-label">Confirmer que
                                                    c'est un nouveau membre</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-primary" wire:click="bsSteepPrevNext('next')">Suivant</a>
                            </div>
                            <div id="cour-part" @if ($bsSteepActive !=2) style="display: none;" @endif>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label> Inscrit pour : </label>
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn bg-info @if ($typeInscription == 'cours') active @endif">
                                                <input type="radio" name="options" id="option_b1" autocomplete="off"
                                                    spellcheck="false" value="cours" wire:model.live='typeInscription'>
                                                Un cours
                                            </label>
                                            <label
                                                class="btn bg-warning @if ($typeInscription == 'examens') active @endif">
                                                <input type="radio" name="options" id="option_b2" autocomplete="off"
                                                    spellcheck="false" value="examens" wire:model.live='typeInscription'
                                                    wire:click.live="updateCoursList">
                                                Un examen
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Sessions">Session</label>
                                            <select class="custom-select" spellcheck="false" id="Sessions"
                                                wire:model='etudiantSession' wire:click.live='updateCoursList'>
                                                <option value='null'> --- Session --- </option>
                                                @foreach ($listSession as $session)
                                                @if ($session->dateFin > $now && $session->type == $typeInscription)
                                                <option value="{{ $session->id }}"> {{ $session->nom }}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 @if ($typeInscription == 'examens') d-none @endif">
                                        <div class="form-group">
                                            <label for="etudiantNiveau">Niveau</label>
                                            <select class="custom-select" spellcheck="false" id="etudiantNiveau"
                                                wire:model='newEtudiant.level_id' wire:click.live='updateCoursList'>
                                                <option> --- --- </option>
                                                @forelse ($levels as $level)
                                                <option value="{{ $level->id }}"> {{ $level->libelle }}</option>
                                                @empty
                                                <option value="2"> Donné non trouvé </option>
                                                @endforelse
                                            </select>
                                        </div>                                        
                                    </div>

                                    <div
                                        class="col-md-12 card @if ($typeInscription == 'cours') card-info @else card-warning @endif">
                                        <div class="card-header">
                                            <h3 class="card-title">Liste des {{ Str::plural($typeInscription) }}</h3>
                                        </div>
                                        <div class="card-body row">
                                            @if ($typeInscription == 'cours')
                                            @forelse ($nscList['cours'] as $cour)
                                            <div class="form-group col-md-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        id="cour{{ $cour['cour_id'] }}" @if ($cour['active']) checked
                                                        @endif
                                                        wire:model.lazy="nscList.cours.{{ $loop->index }}.active" wire:click='updateMontant'>
                                                    <label for="cour{{ $cour['cour_id'] }}"
                                                        class="custom-control-label">{{ $cour['cour_libelle'] }}</label>
                                                </div>
                                            </div>
                                            @empty
                                            <h3>Aucun donnée trouvé !</h3>
                                            @endforelse
                                            @endif
                                            @if ($typeInscription == 'examens')                                            @forelse ($nscList['examens'] as $examen)
                                            <div class="form-group col-md-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        id="examen{{ $examen['id'] }}" @if ($examen['active']) checked
                                                        @endif
                                                        wire:model.lazy="nscList.examens.{{ $loop->index }}.active"
                                                        wire:click.live="updateMontant">
                                                    <label for="examen{{ $examen['id'] }}"
                                                        class="custom-control-label">{{ $examen['libelle'] }} - {{
                                                        $examen['level'] }} </label>
                                                </div>
                                            </div>                                           
                                            @empty
                                            <h3>Aucun donnée trouvé !</h3>
                                            @endforelse
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-primary" wire:click="bsSteepPrevNext('prev')">Précedent</a>
                                <a class="btn btn-primary" wire:click="bsSteepPrevNext('next')">Suivant</a>
                            </div>
                            <div id="paiement-part" @if ($bsSteepActive !=3) style="display: none;" @endif>
                                <div class="row m-auto">
                                    <div class="col-md-6">
                                        <h5 class="text-center">Detail du paiement :</h5>
                                        <table class="table table-borderless table-striped">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Inscription au {{ Str::plural($typeInscription) }}</td>
                                                    @if ($typeInscription == 'cours')
                                                    <td class="text-end">
                                                        @isset($sessionSelected)
                                                        <span @if($session->dateFinPromo > Carbon\Carbon::now())
                                                            style="text-decoration: line-through; color: #a22;" @endif>
                                                            {{ $sessionSelected->montant }} Ar</span>
                                                        @if ($session->dateFinPromo > Carbon\Carbon::now())
                                                        {{ $sessionSelected->montantPromo }} Ar
                                                        @endif
                                                        @endisset
                                                    </td>
                                                    @endif
                                                    @if ($typeInscription == 'examens')
                                                    <td class="text-end">
                                                        {{ $montantExam }} Ar
                                                    </td>
                                                    @endif
                                                </tr>
                                                @if ($noMember)
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td> Adhésion au membre AF </td>
                                                    <td class="text-end"> {{ $montantAdhesion }} Ar</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="info-box col-md-3 mb-3 mx-3 bg-warning">
                                        <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Montant total</span>
                                            <span class="info-box-number" style="font-size: 1.5rem;">
                                                {{ $montantInscription }} Ar</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="for-group">
                                            <label for="montantPaye">Montant payé en Ar</label>
                                            <input type="number" class="form-control" id="montantPaye"
                                                wire:model.lazy="montantPaye" wire:change="updateMontantRestant">
                                            <small class="text-danger">
                                                @error('montantPaye')
                                                {{ $message }}
                                                @enderror
                                            </small>
                                        </div>
                                    </div>

                                    <div class="info-box col-md-3 mb-3 mx-3 bg-success">
                                        <span class="info-box-icon"><i class="fas fa-coins"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Montant payé</span>
                                            <span class="info-box-number" style="font-size: 1.5rem;">
                                                {{ $montantPaye }} Ar</span>
                                            <span class="info-box-text">Montant restant</span>
                                            <span class="info-box-number" style="font-size: 1.5rem;">
                                                {{ $montantRestant }} Ar</span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Paiement par</h3>
                                        </div>
                                        <div class="card-body row">
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="espece"
                                                    name="paiementPar" wire:click="defineMoyenPai('Espèce')">
                                                <label for="espece" class="custom-control-label">Espèce</label>
                                            </div>
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="cheque"
                                                    name="paiementPar" wire:click="defineMoyenPai('Chèque')">
                                                <label for="cheque" class="custom-control-label"> Chèque</label>
                                            </div>
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="carte"
                                                    name="paiementPar" wire:click="defineMoyenPai('Carte bancaire')">
                                                <label for="carte" class="custom-control-label">Carte
                                                    bancaire</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6 ml-2 card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Status de paiement</h3>
                                        </div>
                                        <div class="card-body row">
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="moitier"
                                                    name="statuePaiement" wire:click="defineStatue('A moitié')">
                                                <label for="moitier" class="custom-control-label">Partiellement payé
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio col-md-3">
                                                <input class="custom-control-input" type="radio" id="totale"
                                                    name="statuePaiement" wire:click="defineStatue('Totalement')">
                                                <label for="totale" class="custom-control-label">Totalement
                                                    payé</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-primary" wire:click="bsSteepPrevNext('prev')">Précédent</a>
                                <a class="btn btn-primary" wire:click="bsSteepPrevNext('next')"> <i
                                        class="fa fa-paper-plane"></i> <i class="fa fa-spinner fa-spin"
                                        wire:loading='submitNewEtudiant' wire:target='submitNewEtudiant'></i>
                                    Enregistrer l'inscription</a>
                            </div>
                            <div id="facture-part" @if ($bsSteepActive !=4) style="display: none;" @endif>
                                <div class="col-md-12 card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Facturation</h3>
                                    </div>
                                    <div class="card-body mx-auto w-100">
                                        <div class="text-center">
                                            <img src="{{ asset('images/facture.jpg') }}" width="50%"
                                                alt="prevision facture">
                                        </div>
                                        <div class="custom-control custom-switch text-center my-3">
                                            {{-- <input class="custom-control-input custom-control-input-info"
                                                type="checkbox" id="generetFactur">
                                            <label for="generetFactur" class="custom-control-label">Imprimer la
                                                facture
                                                après l'inscription.</label> --}}
                                            <a href="/generate-pdf/{{ $paiement_id }}" target="_blank"
                                                class="btn btn-info mr-3"> <i class="fa fa-print"></i> Imprimer
                                            </a>
                                            <a href="/generate-pdf/{{ $paiement_id }}" target="_blank"
                                                class="btn btn-warning"> <i class="fa fa-download"></i> Télécharger
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                {{-- <a class="btn btn-primary" wire:click="bsSteepPrevNext('prev')">Précédent</a>
                                --}}
                                <a href="{{route('etudiants-list')}}" class="btn btn-primary"> Fermer </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>