@section('title', 'adhésions')

@section('titlePage', 'ADHÉSIONS')

<div class="row mx-4 pt-4">
    <div class="col-md-12 d-flex align-items-center justify-content-between my-3">
        <h3>Nouvel adhésions: </h3>

    </div>
    <div class="col-md-12" wire:ignore.self>
        <div class="card card-default m-0">

            {{-- Card header --}}
            <div class="card-header bg-gradient-primary w-100 d-flex align-items-center">
                <h3 class="card-title flex-grow-1"><i class="fa fa-pen mr-2"></i> Formulaire d'adhésion</h3>
                <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                    <i class="fas fa-expand"></i>
                </button>
                <a type="button" class="btn btn-info" data-toggle="modal" data-target="#view-list-adhesion" spellcheck="false">
                    <i class="fa fa-list mr-2"></i> Voir la liste des membres
                </a>
            </div>

            {{-- Card body --}}
            <div class="card-body p-0">
                <div class="bs-stepper" id="bs-stepper">
                    @if ($stapes == "new")
                    <div class="bs-stepper-header" role="tablist">

                        <div class="step @if ($bsSteepActive == 1) active @endif" data-target="#info-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="info-part"
                                id="logins-part-trigger" @if ($bsSteepActive !=1) disabled="disabled" @endif>
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Information de membre</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step @if ($bsSteepActive == 2) active @endif" data-target="#paiement-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="paiement-part"
                                id="information-part-trigger" @if ($bsSteepActive !=3) disabled="disabled" @endif>
                                <span class="bs-stepper-circle bg-gradient-warning">3</span>
                                <span class="bs-stepper-label text-warning">Paiement</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step @if ($bsSteepActive == 3) active @endif" data-target="#facture-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="facture-part"
                                id="information-part-trigger" @if ($bsSteepActive !=4) disabled="disabled" @endif>
                                <span class="bs-stepper-circle bg-gradient-success">4</span>
                                <span class="bs-stepper-label text-success">Facture</span>
                            </button>
                        </div>
                    </div>
                    @endif
                    <div class="bs-stepper-content">
                        <form>
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
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantNom">Nom</label>
                                            <input type="text" class="form-control 
                                                @error('newAdhesion.nom') is-invalid @enderror" id="etudiantNom"
                                                wire:model="newAdhesion.nom">
                                            @error('newAdhesion.nom')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantPrenom">Prénom</label>
                                            <input type="text" class="form-control 
                                                @error('newAdhesion.prenom') is-invalid @enderror" id="etudiantPrenom"
                                                wire:model='newAdhesion.prenom'>
                                            @error('newAdhesion.prenom')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantPrenom">Sexe</label>
                                            <select class="custom-select 
                                                @error('newAdhesion.sexe') is-invalid @enderror" spellcheck="false"
                                                id="etudiantSexe" wire:model='newAdhesion.sexe'>
                                                <option> --- --- </option>
                                                <option value="M">Homme</option>
                                                <option value="F">Femme</option>
                                            </select>
                                            @error('newAdhesion.sexe')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantBirth">Date de naissance</label>
                                            <input type="date" class="form-control 
                                                @error('newAdhesion.dateNaissance') is-invalid @enderror"
                                                id="etudiantBirth" wire:model='newAdhesion.dateNaissance'>
                                            @error('newAdhesion.dateNaissance')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantProfession">Nationalité</label>
                                            <input type="text" class="form-control 
                                                @error('newAdhesion.nationalite') is-invalid @enderror"
                                                id="etudiantNationalite" wire:model='newAdhesion.nationalite'>
                                            @error('newAdhesion.nationalite')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantProfession">Profession</label>
                                            <input type="text" class="form-control" id="etudiantProfession"
                                                wire:model='newAdhesion.profession'>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantAddr">Adresse</label>
                                            <input type="text" class="form-control 
                                                @error('newAdhesion.adresse') is-invalid @enderror" id="etudiantAddr"
                                                wire:model='newAdhesion.adresse'>
                                            @error('newAdhesion.adresse')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantEmail">Email</label>
                                            <input type="text" class="form-control 
                                                @error('newAdhesion.email') is-invalid @enderror" id="etudiantEmail"
                                                wire:model='newAdhesion.email'>
                                            @error('newAdhesion.email')
                                            <span class="invalid-feedback"> Ce champ est obligatoire | unique</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantNiveau">Catégorie</label>
                                            <select
                                                class="custom-select  @error('newAdhesion.categorie_id') is-invalid @enderror"
                                                spellcheck="false" id="etudiantNiveau"
                                                wire:model='newAdhesion.categorie_id' @if ($stapes != "new") disabled @endif>
                                                <option> --- --- </option>
                                                @forelse ($categories as $categorie)
                                                <option value="{{ $categorie->id }}"> {{ $categorie->libelle }}</option>
                                                @empty
                                                <option> Donné non trouvé </option>
                                                @endforelse
                                            </select>
                                            @error('newAdhesion.categorie_id')
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
                                                class="form-control phone @error('newAdhesion.telephone1') is-invalid @enderror"
                                                id="etudiantPhone" wire:model='newAdhesion.telephone1'>
                                            @error('newAdhesion.telephone1')
                                            <span class="invalid-feedback"> Le numéro de téléphone doit être au format:
                                                032.00.000.00</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="etudiantPhone2">Second téléphone</label>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control phone @error('newAdhesion.telephone2') is-invalid @enderror"
                                                id="etudiantPhone2" wire:model='newAdhesion.telephone2'>
                                            @error('newAdhesion.telephone2')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @if ($stapes == "new")
                                <a class="btn btn-primary" wire:click="bsSteepPrevNext('next')">Suivant</a>
                                @else
                                <button class="btn btn-primary" wire:click.prevent='updateAdhesion'>Mettre à jour</button>    
                                @endif
                            </div>
                            <div id="paiement-part" @if ($bsSteepActive != 2) style="display: none;" @endif>
                                <div class="row m-auto">
                                    <div class="col-md-6">
                                        <h5 class="text-center">Detail du paiement :</h5>
                                        <table class="table table-borderless table-striped">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Adhésion au membre de l'alliance française</td>
                                                    
                                                    <td class="text-end">
                                                        {{ $montantAdhesion }} Ar
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="info-box col-md-3 mb-3 mx-3 bg-warning">
                                        <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Montant total</span>
                                            <span class="info-box-number" style="font-size: 1.5rem;">
                                                {{ $montantAdhesion }} Ar</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="for-group">
                                            <label for="montantPaye">Montant payé en Ar</label>
                                            <input type="number" class="form-control" id="montantPaye"
                                               value="{{ $montantAdhesion }}" @if ($newAdhesion['categorie_id'] != 4) disabled @endif wire:model.live='montantPayer' wire:change='montantPayeChange'>
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
                                                {{ $montantPayer }} Ar</span>
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
                                        wire:loading='submitNewMembre' wire:target='submitNewMembre'></i>
                                    Enregistrer</a>
                            </div>
                            <div id="facture-part" @if ($bsSteepActive != 3) style="display: none;" @endif>
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
                                            <a  href="/generate-pdf/{{ $paiement_id }}" target="_blank"
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

            {{-- Partie Modal view --}}
            <div class="modal fade" id="view-list-adhesion" style="display: none; "
                aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-0 ">
                            @include('livewire.adhesions.view')

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>