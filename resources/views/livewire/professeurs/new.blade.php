<div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; height: 100%; width: 100%;">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-edit fa-2x mr-2"></i> Nouveau professeur</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                <i class="fas fa-expand"></i>
            </button>
            <button type="button" class="btn btn-danger" wire:click="toogleSectionName('list')">
                <i class="fa fa-chevron-left mr-2"> Retour à la liste des professeurs</i>
            </button>
        </div>

    </div>

    <div class="card-body row">
        <div class="col-md-8 mx-auto">
            <div class="card-body box-profile">
                <form class="row" wire:submit='submitNewProfesseur'>
                    <div class="col-md-12 d-flex justify-content">
                        @if ($photo)
                            <div class="mr-4">
                                <img class="profile-user-img img-fluid img-circle" src="{{ $photo->temporaryUrl() }}">
                            </div>
                        @endif
                        <div class="mr-4 my-auto" wire:loading wire:target="photo">
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>
                        <div class="form-group w-100">
                            <label for="exampleInputFile">Photo de profil</label>
                            <div class="input-group w-50">
                                <div class="btn-group w-100">
                                    <label for="professeurtProfil" class="btn btn-success col fileinput-button dz-clickable">
                                        <i class="fas fa-plus"></i>
                                        <input type="file" id="professeurtProfil" wire:model='photo' style="display: none;">
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
                                {{-- <div class="custom-file">
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
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="etudiantNom">Nom</label>
                            <input type="text" class="form-control @error('editEtudiant.nom') is-invalid @enderror"
                                id="etudiantNom" wire:model='newProfesseur.nom'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="etudiantPrenom">Prénom</label>
                            <input type="text"
                                class="form-control @error('editEtudiant.prenom') is-invalid @enderror"
                                id="etudiantPrenom" wire:model='newProfesseur.prenom'>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="etudiantPrenom">Sexe</label>
                            <select class="custom-select @error('editEtudiant.sexe') is-invalid @enderror"
                                spellcheck="false" id="etudiantPrenom" wire:model='newProfesseur.sexe'>
                                <option value=""> --- --- </option>
                                <option value="M">Homme</option>
                                <option value="F">Femme</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="etudiantProfession">Nationalité</label>
                            <input type="text" class="form-control" id="etudiantNationalite"
                                wire:model='newProfesseur.nationalite'>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="etudiantAddr">Adresse</label>
                            <input type="text"
                                class="form-control @error('newProfesseur.adresse') is-invalid @enderror"
                                id="etudiantAddr" wire:model='newProfesseur.adresse'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="etudiantEmail">Email</label>
                            <input type="text"
                                class="form-control @error('newProfesseur.email') is-invalid @enderror"
                                id="etudiantEmail" wire:model='newProfesseur.email'>
                            @error('newProfesseur.email')
                                <span class="invalid-feedback">Email doit être unique !</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="etudiantPhone">Téléphone</label>
                            <input type="text"
                                class="form-control @error('newProfesseur.telephone1') is-invalid @enderror"
                                id="etudiantPhone" wire:model='newProfesseur.telephone1'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="etudiantPhone">Second téléphone</label>
                            <input type="text" class="form-control" id="etudiantPhone"
                                wire:model='newProfesseur.telephone2'>
                        </div>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info btn-md"> <i class="fa fa-send"></i> <i class="fa fa-paper-plane"></i> <i class="fa fa-spin fa-spinner" wire:loading wire:target="submitNewProfesseur"></i> Envoyer</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
