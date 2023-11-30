@section('title', 'nouveau cours')

@section('titlePage', 'COURS')

<div class="row mx-4 pt-4">
    <div class="col-md-12 d-flex align-items-center justify-content-between my-3">
        <h3>Nouveau cours: </h3>
        <form action="">
            {{-- <div class="input-group input-group-lg">
                <input type="search" class="form-control form-control-lg" placeholder="Chercher l'information du membre"
                    value="" spellcheck="false" style="width:400px;">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-lg btn-info">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div> --}}
        </form>
    </div>
    <div class="col-md-12">
        <div class="card card-default m-0">
            <div class="card-header bg-gradient-primary w-100 d-flex align-items-center">
                <h3 class="card-title flex-grow-1"><i class="fa fa-pen mr-2"></i> Formulaire du cours</h3>
                <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                    <i class="fas fa-expand"></i>
                </button>
                <a href="{{ route('cours-list') }}" type="button" class="btn btn-warning">
                    <i class="fa fa-list mr-2"></i> Voir la liste des cours
                </a>
            </div>
            <div class="card-body">
                <form class="row" wire:submit.prevent='addNewCour'>
                    <div class="col-md-1 form-group">
                        <label class="form-label" for="codeCour">Code</label>
                        <input class="form-control @error('newCour.code') is-invalid @enderror" type="text" name="newCour" id="codeCour" wire:model='newCour.code'>
                        @error('newCour.code') <span class="invalid-feedback">Ce champ est obligatoire</span> @enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="form-label" for="codeLibellé">Libellé</label>
                        <input class="form-control @error('newCour.libelle') is-invalid @enderror" type="text" name="newCour" id="codeLibellé" wire:model='newCour.libelle'>
                        @error('newCour.libelle') <span class="invalid-feedback">Ce champ est obligatoire</span> @enderror
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="form-label" for="codeCategorie">Catégorie</label>
                        <input class="form-control @error('newCour.libelle') is-invalid @enderror" type="text" name="newCour" id="codeCategorie" wire:model='newCour.categorie'>
                        @error('newCour.categorie') <span class="invalid-feedback">Ce champ est obligatoire</span> @enderror
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="form-label" for="codeSalle">Niveau</label>
                        <select class="form-control @error('newCour.level_id') is-invalid @enderror" id="courNiveau" wire:model='newCour.level_id'>
                            <option >-- Niveau --</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level['id'] }}"> {{ $level['nom'] }} </option>                                
                            @endforeach
                        </select>
                        @error('newCour.level_id') <span class="invalid-feedback">Ce champ est obligatoire</span> @enderror
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="form-label" for="codeSalle">Salle</label>
                        <input class="form-control @error('newCour.salle') is-invalid @enderror" type="text" name="newCour" id="codeSalle" wire:model='newCour.salle'>
                        @error('newCour.salle') <span class="invalid-feedback">Ce champ est obligatoire</span> @enderror
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="form-label" for="codeProfesseur">Professeur</label>
                        <select class="form-control @error('newCour.professeur_id') is-invalid @enderror" name="professeur" id="codeProfesseur" wire:model='newCour.professeur_id'>
                            <option >-- Professeur --</option>
                            @foreach ($professeurs as $prof)
                            <option value="{{ $prof['id'] }}"> {{ $prof['sexe'] == 'F' ? 'Mme/Mlle' : 'Mr' }} {{ $prof['nom'] }} </option>                            
                            @endforeach
                        </select>
                        @error('newCour.professeur_id') <span class="invalid-feedback">Ce champ est obligatoire</span> @enderror
                    </div>
                    <div class="col-md-6 form-group row">
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
                            <label class="form-label" for="codeHeur">Heure du debut</label>
                            <input class="form-control" type="time" name="courTime" wire:model='heurDebInput'>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="codeHeur">Heure du fin</label>
                            <input class="form-control" type="time" name="courTime" wire:model='heurFinInput'>
                        </div>
                        <div class="col-md-2 text-center">
                            <button class="btn btn-info" wire:click.prevent="setDateHourCour"> <i class="fa fa-plus"></i> Add</button>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control @error('dateHeurCour') is-invalid @enderror" type="text" disabled wire:model='dateHeurCour'>
                            @error('dateHeurCour') <span class="invalid-feedback">Ce champ est obligatoir</span> @enderror
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger" wire:click.prevent="resetDateHourCour"> <i class="fa fa-undo"></i> Reset</button>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="codeComment">Commentaire</label>
                        <textarea class="form-control" type="text" name="newCour" id="codeComment" rows="6" wire:model='newCour.coment'></textarea>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-info btn-lg"> <i class="fa fa-paper-plane"></i> Envoyer</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>