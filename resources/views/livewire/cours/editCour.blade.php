<div class="card card-default m-0">
    <div class="card-header bg-gradient-primary w-100 d-flex align-items-center">
        <h3 class="card-title flex-grow-1"><i class="fa fa-pen mr-2"></i> Formulaire de cour</h3>
        <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
            <i class="fas fa-expand"></i>
        </button>
        <a type="button" class="btn btn-info" wire:click="toogleStateName('view')">
            <i class="fa fa-list mr-2"></i> Aller à la liste des cours
        </a>
    </div>
    <div class="card-body">
        <form class="row" wire:submit.prevent='updateCour'>
            <div class="col-md-1 form-group">
                <label class="form-label" for="codeCour">Code</label>
                <input class="form-control @error('editCour.code') is-invalid @enderror" type="text" name="editCour"
                    id="codeCour" wire:model='editCour.code'>
                @error('editCour.code')
                    <span class="invalid-feedback">Ce champ est obligatoire</span>
                @enderror
            </div>
            <div class="col-md-3 form-group">
                <label class="form-label" for="codeLibellé">Libellé</label>
                <input class="form-control @error('editCour.libelle') is-invalid @enderror" type="text"
                    name="editCour" id="codeLibellé" wire:model='editCour.libelle'>
                @error('editCour.libelle')
                    <span class="invalid-feedback">Ce champ est obligatoire</span>
                @enderror
            </div>
            <div class="col-md-2 form-group">
                <label class="form-label" for="codeCategorie">Catégorie</label>
                <input class="form-control @error('editCour.libelle') is-invalid @enderror" type="text"
                    name="editCour" id="codeCategorie" wire:model='editCour.categorie'>
                @error('editCour.categorie')
                    <span class="invalid-feedback">Ce champ est obligatoire</span>
                @enderror
            </div>
            <div class="col-md-2 form-group">
                <label class="form-label" for="codeSalle">Niveau</label>
                <select class="form-control @error('editCour.level_id') is-invalid @enderror" id="courNiveau"
                    wire:model='editCour.level_id'>
                    <option>-- Niveau --</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level['id'] }}"> {{ $level['nom'] }} </option>
                    @endforeach
                </select>
                @error('editCour.level_id')
                    <span class="invalid-feedback">Ce champ est obligatoire</span>
                @enderror
            </div>
            <div class="col-md-2 form-group">
                <label class="form-label" for="codeSalle">Salle</label>
                <input class="form-control @error('editCour.salle') is-invalid @enderror" type="text" name="editCour"
                    id="codeSalle" wire:model='editCour.salle'>
                @error('editCour.salle')
                    <span class="invalid-feedback">Ce champ est obligatoire</span>
                @enderror
            </div>
            <div class="col-md-2 form-group">
                <label class="form-label" for="codeProfesseur">Professeur</label>
                <select class="form-control @error('editCour.professeur_id') is-invalid @enderror" name="professeur"
                    id="codeProfesseur" wire:model='editCour.professeur_id'>
                    <option>-- Professeur --</option>
                    @foreach ($professeurs as $prof)
                        <option value="{{ $prof['id'] }}"> {{ $prof['sexe'] == 'F' ? 'Mme/Mlle' : 'Mr' }}
                            {{ $prof['nom'] }} </option>
                    @endforeach
                </select>
                @error('editCour.professeur_id')
                    <span class="invalid-feedback">Ce champ est obligatoire</span>
                @enderror
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label" for="codeHeur">Jour du cour</label>
                <input class="form-control @error('dateHeurCour') is-invalid @enderror" type="text" wire:model='editCour.horaire'>
                @error('dateHeurCour')
                    <span class="invalid-feedback">Ce champ est obligatoir</span>
                @enderror
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label" for="codeComment">Commentaire</label>
                <textarea class="form-control" type="text" name="editCour" id="codeComment" rows="6"
                    wire:model='editCour.commentaire'></textarea>
            </div>
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info btn-lg"> <i class="fa fa-paper-plane"></i>
                    Modifier</button>
            </div>
        </form>

    </div>
</div>
