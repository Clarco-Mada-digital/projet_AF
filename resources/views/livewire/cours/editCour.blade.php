<div>
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
                        wire:model='editCour.categorie_id'>
                        <option>-- Catégorie --</option>
                        @foreach ($categories as $categorie)
                            <option value="{{ $categorie['id'] }}"> {{ $categorie['libelle'] }}</option>
                        @endforeach
                    </select>
                    @error('editCour.categorie')
                    <span class="invalid-feedback">Ce champ est obligatoire</span>
                    @enderror
                </div>

                <div class="col-md-2 form-group">
                    <label class="form-label" for="codeSalle">Salle</label>
                    <div class="input-group">
                        <select class="form-control @error('editCour.salle_id') is-invalid @enderror" id="codeSalle" wire:model='editCour.salle_id'>
                            <option >-- Salle --</option>
                            @foreach ($salles as $salle)
                                <option value="{{$salle['id']}}">{{ $salle['nom'] }}</option>                                
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" data-toggle="modal"
                            data-target="#addSalleModal" spellcheck="false">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    @error('editCour.salle_id')
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
                        @foreach ($levels as $level)
                        <option value="{{ $level['id'] }}"> {{ $level['libelle'] }} </option>
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
                        <textarea class="form-control @error('dateHeurCour') is-invalid @enderror" type="text" disabled rows="6"> {{ $dateHeurCour }} </textarea>
                        @error('dateHeurCour')
                        <span class="invalid-feedback">Ce champ est obligatoire</span>
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

    <!-- Modal Ajout de salle -->
    <div id="addSalleModal" class="modal fade show" style="display: none; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog" aria-labelledby="addSalleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="addSalleModalLabel">Ajouter une nouvelle salle</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="addNewSalle">
                        <div class="form-group">
                            <label for="newSalleName">Nom de la salle <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('newSalleName') is-invalid @enderror" 
                                id="newSalleName" wire:model.defer="newSalleName" required>
                            @error('newSalleName') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="newSalleDescription">Description</label>
                            <textarea class="form-control @error('newSalleDescription') is-invalid @enderror" 
                                    id="newSalleDescription" wire:model.defer="newSalleDescription" rows="3"></textarea>
                            @error('newSalleDescription')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">
                                <span wire:loading wire:target="addNewSalle">
                                    <i class="fas fa-spinner fa-spin"></i> Enregistrement...
                                </span>
                                <span wire:loading.remove wire:target="addNewSalle">
                                    <i class="fas fa-save"></i> Enregistrer
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>