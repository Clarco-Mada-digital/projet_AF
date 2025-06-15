@section('title', 'nouveau cours')

@section('titlePage', 'COURS')
<div>
    <div class="row mx-4 pt-4">
        <div class="col-md-12 d-flex align-items-center justify-content-between my-3">
            <h3>Nouveau cours: </h3>
        </div>
        <div class="col-md-12">
            <div class="card card-default m-0">

                {{-- card header --}}
                <div class="card-header bg-gradient-primary w-100 d-flex align-items-center">
                    <h3 class="card-title flex-grow-1"><i class="fa fa-pen mr-2"></i> Formulaire du cours</h3>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                        <i class="fas fa-expand"></i>
                    </button>
                    <a href="{{ route('cours-list') }}" type="button" class="btn btn-warning">
                        <i class="fa fa-list mr-2"></i> Voir la liste des cours
                    </a>
                </div>

                {{-- card body --}}
                <div class="card-body">
                    <form class="row" wire:submit.prevent='addNewCour'>
                        <div class="col-md-2 form-group">
                            <label class="form-label" for="codeCour">Code *</label>
                            <input class="form-control @error('newCour.code') is-invalid @enderror" type="text" name="newCour" id="codeCour" wire:model='newCour.code'>
                            @error('newCour.code') <span class="invalid-feedback">Ce champ est obligatoire</span> @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="form-label" for="libelleCour">Libellé *</label>
                            <input class="form-control @error('newCour.libelle') is-invalid @enderror" type="text" name="newCour" id="libelleCour" wire:model='newCour.libelle'>
                            @error('newCour.libelle') <span class="invalid-feedback">Ce champ est obligatoire</span> @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label class="form-label" for="categorieCour">Catégorie *</label>
                            <select class="form-control @error('newCour.categorie_id') is-invalid @enderror" id="categorieCour" wire:model='newCour.categorie_id'>
                                <option >-- Catégorie --</option>
                                @foreach ($categories as $categorie)
                                    <option value="{{$categorie['id']}}">{{ $categorie['libelle'] }}</option>                                
                                @endforeach
                            </select>
                            @error('newCour.categorie') <span class="invalid-feedback">Ce champ est obligatoire</span> @enderror
                        </div>
                        
                        <div class="col-md-2 form-group">
                            <label class="form-label" for="salleCour">Salle</label>
                            <div class="input-group">
                                <select class="form-control @error('newCour.salle_id') is-invalid @enderror" 
                                    id="salleCour" 
                                    wire:model='newCour.salle_id'>
                                    <option value="">-- Salle --</option>
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
                            @error('newCour.salle_id') <span class="invalid-feedback">Ce champ est obligatoire</span> @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label class="form-label" for="professeurCour">Professeur</label>
                            <select class="form-control @error('newCour.professeur_id') is-invalid @enderror" name="professeur" id="professeurCour" wire:model='newCour.professeur_id'>
                                <option >-- Professeur --</option>
                                @foreach ($professeurs as $prof)
                                <option value="{{ $prof['id'] }}"> {{ $prof['sexe'] == 'F' ? 'Mme/Mlle' : 'M.' }} {{ $prof['nom'] }} </option>                            
                                @endforeach
                            </select>
                            @error('newCour.professeur_id') <span class="invalid-feedback">Ce champ est obligatoire</span> @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label class="form-label" for="courNiveau">Niveau</label>
                            <select multiple class="form-control @error('newCour.level_id') is-invalid @enderror" id="courNiveau" wire:model='newLevels'>
                                {{-- <option >-- Niveau --</option> --}}
                                @foreach ($levels as $level)
                                    <option value="{{ $level['id'] }}"> {{ $level['libelle'] }} </option>                                
                                @endforeach
                            </select>
                            @error('newCour.level_id') <span class="invalid-feedback">Ce champ est obligatoire</span> @enderror
                            <span class="text-info">**Pour effectuer une sélection multiple, appuyez sur Ctrl ou Cmd.**</span>
                        </div>
                        <div class="col-md-2 form-group">
                            <label class="form-label" for="sessionNiveau">Session</label>
                            <select class="form-control @error('newCour.session_id') is-invalid @enderror" id="sessionNiveau" wire:model='newCour.session_id'>
                                <option >-- Session --</option>
                                @foreach ($sessions as $session)
                                    <option value="{{ $session->id }}"> {{ $session->nom }} </option>                                
                                @endforeach
                            </select>
                            @error('newCour.session_id') <span class="invalid-feedback">Ce champ est obligatoire</span> @enderror
                        </div>
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
                                <label class="form-label" for="codeHeur">Heure du début</label>
                                <input class="form-control" type="time" name="courTime" wire:model='heurDebInput'>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="codeHeur">Heure du fin</label>
                                <input class="form-control" type="time" name="courTime" wire:model='heurFinInput'>
                            </div>
                            <div class="col-md-3 text-center mt-3">
                                <button class="btn btn-info" wire:click.prevent="setDateHourCour"> <i class="fa fa-plus"></i> Add</button>
                            </div>
                            <div class="col-md-6 mt-3">
                                <textarea class="form-control @error('dateHeurCour') is-invalid @enderror" type="text" disabled rows="5"> {{ $dateHeurCour }} </textarea>
                                @error('dateHeurCour') <span class="invalid-feedback">Ce champ est obligatoir</span> @enderror
                            </div>
                            <div class="col-md-3 mt-3">
                                <button class="btn btn-danger" wire:click.prevent="resetDateHourCour"> <i class="fa fa-undo"></i> Reset</button>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="form-label" for="codeComment">Commentaire</label>
                            <textarea class="form-control" type="text" name="newCour" id="codeComment" rows="6" wire:model='newCour.comment'></textarea>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-info btn-md"> <i class="fa fa-paper-plane"></i> <i class="fa fa-spinner fa-spin" wire:loading wire:target='addNewCour'></i> Envoyer</button>
                        </div>
                    </form>

                </div>

            </div>
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