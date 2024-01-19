<div class="card card-default m-0">

    {{-- Card header --}}
    <div class="card-header bg-gradient-primary w-100 d-flex align-items-center">
        <h3 class="card-title flex-grow-1"><i class="fa fa-pen mr-2"></i> Formulaire de cour</h3>
        <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
            <i class="fas fa-expand"></i>
        </button>
        <a type="button" class="btn btn-warning" wire:click="toogleStateName('view')">
            <i class="fa fa-list mr-2"></i> Aller à la liste des cours
        </a>
    </div>

    {{-- Card body --}}
    <div class="card-body">
        <form class="row" wire:submit.prevent='updateCour'>
            <div class="col-md-2 form-group">
                <label class="form-label" for="codeCour">Code</label>
                <input class="form-control @error('editCour.code') is-invalid @enderror" type="text" name="editCour"
                    id="codeCour" wire:model='editCour.code'>
                @error('editCour.code')
                <span class="invalid-feedback">Ce champ est obligatoire</span>
                @enderror
            </div>
            <div class="col-md-4 form-group">
                <label class="form-label" for="codeLibellé">Libellé</label>
                <input class="form-control @error('editCour.libelle') is-invalid @enderror" type="text" name="editCour"
                    id="codeLibellé" wire:model='editCour.libelle'>
                @error('editCour.libelle')
                <span class="invalid-feedback">Ce champ est obligatoire</span>
                @enderror
            </div>
            <div class="col-md-2 form-group">
                <label class="form-label" for="codeCategorie">Catégorie</label>
                <select class="form-control @error('editCour.libelle') is-invalid @enderror" id="codeCategorie"
                    wire:model='editCour.categorie'>
                    <option>-- Catégorie --</option>
                    <option value="enfant">Enfant</option>
                    <option value="ado">Ado</option>
                    <option value="adulte">Adulte</option>
                </select>
                @error('editCour.categorie')
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
            <div class="col-md-4 form-group">
                <label class="form-label" for="codeSalle">Niveau</label>
                <select multiple class="form-control @error('editCour.level_id') is-invalid @enderror" id="courNiveau"
                    wire:model='editCour.levels'>
                    {{-- <option>-- Niveau --</option> --}}
                    @foreach ($levels as $level)
                    <option value="{{ $level['id'] }}"> {{ $level['nom'] }} </option>
                    @endforeach
                </select>
                @error('editCour.level_id')
                <span class="invalid-feedback">Ce champ est obligatoire</span>
                @enderror
            </div>
            {{-- Formulaire d'horaire du cour --}}
            <div class="col-md-8 form-group row">
                <div class="col-md-6">
                    <label class="form-label" for="codeHeur">Jour</label>
                    <select class="form-control" name="courDay" wire:model='dateInput'>
                        <option>-- Jour --</option>
                        <option value="Lundi">Lundi</option>
                        <option value="Mardi">Mardi</option>
                        <option value="Mercredi">Mercredi</option>
                        <option value="Jeudi">Jeudi</option>
                        <option value="Vendredi">Vendredi</option>
                        <option value="Samedi">Samedi</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="codeHeur">Heure du
                        début</label>
                    <input class="form-control" type="time" name="courTime" wire:model='heurDebInput'>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="codeHeur">Heure du
                        fin</label>
                    <input class="form-control" type="time" name="courTime" wire:model='heurFinInput'>
                </div>
                <div class="col-md-3 text-right mt-3">
                    <button class="btn btn-info" wire:click.prevent='setDateHourCour()'>
                        <i class="fa fa-plus"></i> Add</button>
                </div>
                <div class="col-md-6 mt-3">
                    <input class="form-control @error('dateHeurCour') is-invalid @enderror" type="text" disabled
                        wire:model='dateHeurCour'>
                    @error('dateHeurCour')
                    <span class="invalid-feedback"> Ce champ est
                        obligatoire
                    </span>
                    @enderror
                </div>
                <div class="col-md-3 mt-3">
                    <button class="btn btn-danger" wire:click.prevent="resetDateHourCour()">
                        <i class="fa fa-undo"></i> Reset</button>
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label class="form-label" for="codeComment">Commentaire</label>
                <textarea class="form-control" type="text" name="editCour" id="codeComment" rows="6"
                    wire:model='editCour.coment'></textarea>
            </div>
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-info btn-lg" wire:click='updateCour'> <i class="fa fa-paper-plane"></i> <i
                        class="fa fa-spinner fa-spin" wire:loading wire:target='updateCour'></i>
                    Modifier</button>
            </div>
        </form>

    </div>
</div>