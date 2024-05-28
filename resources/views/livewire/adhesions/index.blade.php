@section('title', 'adhésions')

@section('titlePage', 'ADHÉSIONS')

<div class="row mx-4 pt-4">
    
    <div class="col-md-12 d-flex align-items-center justify-content-between my-3">
        <h3>Nouvel adhésions: </h3> 
        @hasrole('Super-Admin')
        <button class="btn btn-warning" wire:click='getDataPmb'>
            <i class="fa fa-sync mr-2"></i>
            <i class="fa fa-spinner fa-spin" wire:loading='getDataPmb' wire:target='getDataPmb'></i> 
            Récupérer la base de donné pmb 
        </button>
        @endhasrole
    </div>
    <div class="col-md-12" wire:ignore.self>
        <div class="card card-default m-0  mb-3">

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
                    
                    <div x-show="$wire.stapes != 'update'" class="bs-stepper-header" role="tablist">

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
                                            <label for="adhesionNom">Nom</label>
                                            <input type="text" class="form-control 
                                                @error('newAdhesion.nom') is-invalid @enderror" id="adhesionNom"
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
                                    <div class="col-md-3 d-flex justify-content-between">
                                        <div class="form-group mr-2">
                                            <label for="etudiantPrenom">Sexe</label>
                                            <select class="custom-select 
                                                @error('newAdhesion.sexe') is-invalid @enderror" spellcheck="false"
                                                id="etudiantSexe" wire:model='newAdhesion.sexe'>
                                                <option> --- --- </option>
                                                <option value="M">Masculin</option>
                                                <option value="F">Féminin</option>
                                            </select>
                                            @error('newAdhesion.sexe')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                        <div class="form-group ml-2">
                                            <label for="etudiantBirth">Année de naissance</label>
                                            <input type="number" class="form-control 
                                                @error('newAdhesion.dateNaissance') is-invalid @enderror"
                                                id="etudiantBirth" wire:model='newAdhesion.dateNaissance'>
                                            @error('newAdhesion.dateNaissance')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantProfession">Établissement</label>
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
                                            <label for="etudiantVille">Ville</label>
                                            <input type="text" class="form-control 
                                                @error('newAdhesion.ville') is-invalid @enderror" id="etudiantVille"
                                                wire:model='newAdhesion.ville'>
                                            @error('newAdhesion.ville')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="etudiantPays">Pays</label>
                                            <input type="text" class="form-control 
                                                @error('newAdhesion.pays') is-invalid @enderror"
                                                id="etudiantPays" wire:model='newAdhesion.pays'>
                                            @error('newAdhesion.pays')
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
                                                wire:model='newAdhesion.categorie_id' wire:change='generateCB' @if ($stapes == "update") disabled @endif>
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
                                                id="etudiantPhone2" wire:model='newAdhesion.telephone2'/>
                                            @error('newAdhesion.telephone2')
                                            <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 form-group ">
                                        <label class="form-label">Code Barre </label>
                                        {{-- <span class="text-danger ml-2 fw-light">*Pour ceux qui s’inscrit au bibliothèque*</span> --}}
                                        <div class="d-flex justify-content-between">
                                            <a type="button" class="form-control btn btn-info" data-toggle="modal" data-target="#view-scan-code" spellcheck="false" onclick="exemple()"> <i class="fa fa-barcode mr-3"></i>{{ $newAdhesion['CB'] == null ? 'Scanne' : $newAdhesion['CB'] }} </a>
                                            
                                            @if ($newAdhesion['CB'] == null)
                                            <input type="number" placeholder="Code barre"
                                                class="form-control mx-2 @error('newAdhesion.CB') is-invalid @enderror"
                                                id="etudiantCb" wire:model='newAdhesion.CB'/>
                                            @error('newAdhesion.CB')
                                                <span class="invalid-feedback"> Ce champ est obligatoire</span>
                                            @enderror
                                            {{-- <a type="button" class="form-control btn btn-info mx-2" data-toggle="modal" data-target="#view-new-cb" spellcheck="false" onclick='$("#bcTarget").barcode("{{$newAdhesion["numCarte"]}}", "code128",{barWidth:2, barHeight:100, output:"svg"});'> <i class="fa fa-barcode mr-3"></i>Générer </a>                                                 --}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <a x-show="$wire.stapes != 'update'" class="btn btn-primary" wire:click="bsSteepPrevNext('next')">Suivant</a>
                                    <button x-show="$wire.stapes == 'update'" class="btn btn-primary" wire:click.prevent='updateAdhesion'>Mettre à jour</button>    
                                    <a class="btn btn-danger" wire:click="initData">Annuler</a>
                                </div>                                
                               
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
                                            <select x-show="$wire.newAdhesion['categorie_id'] != '4'" name="paiementCategories" id="paiementCategories" wire:model.live='catPaiement' class="form-control mb-3" wire:change.live="defineMontant">
                                                @foreach ($prices as $price)
                                                <option class="@if ($price->categories == '[]') d-none @endif" 
                                                    value="{{ $price->id }}">{{$price->nom}} - {{ $price->categories->implode("libelle", " - ") }}</option>
                                                @endforeach
                                            </select>

                                            <input type="number" class="form-control mb-3  @error('montantPayer') is-invalid @enderror" id="montantPaye"
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
                                    <div class="col-md-12 card card-warning">
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
                                    {{-- <div class="col-md-6 ml-2 card card-warning">
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
                                    </div> --}}
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
                                <a href="{{route('adhesions-nouveau')}}" class="btn btn-primary"> Fermer </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal pour Code Barre --}}
            <div class="modal fade" id="view-scan-code" style="display: none; " aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card-body p-0 m-0">
                                <div class="d-flex justify-content-centr flex-column mr-1">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                            <div id="reader"></div>
                                            <div class="col-md-12">
                                                <label for="etudiantPhone2">Code Barre</label>
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control text-center text-success fw-bold"
                                                        id="resultCB" wire:model.live='newAdhesion.CB' disabled style="font-size: 1.2rem"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex w-100">
                                <button class="btn btn-danger" wire:click='cancelCB' data-toggle="modal" spellcheck="false" data-dismiss="modal"> Annuler</button>
                                <button class="btn btn-success ml-auto" data-toggle="modal" spellcheck="false" data-dismiss="modal"> OK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modale pour la génération du code barre --}}
            <div class="modal fade" id="view-new-cb" style="display: none; " aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card-body p-0 m-0">
                                <div class="d-flex justify-content-centr flex-column mr-1">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body box-profile m-auto">
                                            <div id="bcTarget"></div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex w-100">
                                <button class="btn btn-danger" wire:click='cancelCB' data-toggle="modal" spellcheck="false" data-dismiss="modal"> Annuler</button>
                                <button class="btn btn-success ml-auto" data-toggle="modal" spellcheck="false" data-dismiss="modal" wire:click='defineCB("{{$newAdhesion["numCarte"]}}")'> OK</button>
                            </div>
                        </div>
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
    
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function exemple() {
            const html5Qrcode = new Html5Qrcode("reader"); // "reader" est l'ID de l'élément HTML où vous voulez afficher la caméra
            const resultCB = document.getElementById('resultCB')

            function onScanSuccess(decodedText, decodedResult) {
                // Gérer la réussite de la lecture du code-barre ici
                console.log(`Code-barre lu : ${decodedText}`);
                resultCB.value = decodedText;
                Livewire.dispatch('code_barre_update', {codeBarre: decodedText});
                html5QrcodeScanner.clear();
                // Exemple : envoyer le code-barre au serveur via AJAX
                // $.ajax({
                //     url: "/api/codes",
                //     method: "POST",
                //     data: { code: decodedText },
                //     success: function(response) {
                //         console.log("Code-barre ajouté avec succès");
                //     },
                //     error: function(error) {
                //         console.error("Erreur lors de l'ajout du code-barre", error);
                //     }
                // });
            }
            
            

            function onScanFailure(error) {
                // Gérer l'échec de la lecture du code-barre ici
                console.error("Échec de la lecture du code-barre :", error);
            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: 200 },
            /* verbose= */ false);
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        };

    </script>
</div>