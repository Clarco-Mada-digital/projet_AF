@section('title', 'niveaux')

@section('titlePage', 'NIVEAUX')

<div>
    <h3 class="mb-5 pt-3">Liste des niveaux</h3>
    <div class="row mt-4 mx-2">
        <div class="col-12">
            <div class="card" style="min-height: 350px;">
                <div class="card-header bg-gradient-primary">
                    <h3 class="card-title d-flex align-items-center"> <i class="fa fa-users fa-2x mr-2"></i> Liste des
                        niveaux</h3>
                    <div class="card-tools d-flex align-items-center">
                        <button class="btn btn-link text-light mr-4" wire:click='toogleFormLevel'>
                            <i class="fa fa-user-plus"></i> Nouvelle niveau</button>
                        <div class="input-group input-group-md" style="width: 250px;">
                            <input type="search" name="table_search" class="form-control float-right"
                                placeholder="Rechercher " wire:model.live.debounce.500ms="search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0 table-striped" style="position: relative;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 5%"></th>
                                <th wire:click="setOrderField('nom')">Nom</th>
                                <th class="text-center" style="width: 10%">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- Section pour formulaire de nouvel niveau --}}
                            @if ($showNewLevelForm)
                                <tr>
                                    <td colspan="2">
                                        <input class="form-control @error('newLevel') border-danger @enderror" type="text" placeholder="Nouvel de niveau"
                                            wire:model='newLevel' wire:keydown.enter="addNewLevel">
                                            @error('newLevel') <span class="text-danger fs-3"> {{ $message }} </span> @enderror
                                    </td>                                    
                                    <td class="text-center">                                        
                                        <button class="btn btn-success" wire:click='addNewLevel'> <i
                                                class="fa fa-plus"></i> <i class="fa fa-spinner fa-spin" wire:loading
                                                wire:target='addNewLevel'></i> Enregistrer </button>
                                        <button class="btn btn-danger" wire:click='toogleFormLevel'> <i
                                                class="fa fa-ban"></i> Annuler </button>
                                    </td>
                                </tr>
                            @endif
                            @if ($showEditLevelForm)
                                <tr>
                                    <td colspan="2">
                                        <input class="form-control @error('editLevel') border-danger @enderror" type="text" placeholder="Nouvel de niveau"
                                            wire:model='editLevel' wire:keydown.enter="submitEditLevel">
                                            @error('editLevel') <span class="text-danger fs-3"> {{ $message }} </span> @enderror
                                    </td>                                    
                                    <td class="text-center">                                        
                                        <button class="btn btn-success" wire:click="submitEditLevel()"> <i
                                                class="fa fa-plus"></i> <i class="fa fa-spinner fa-spin" wire:loading
                                                wire:target='editLevel'></i> Confirmer </button>
                                        <button class="btn btn-danger" wire:click="toogleEditLevel({{ 1 }}, false)"> <i
                                                class="fa fa-ban"></i> Annuler </button>
                                    </td>
                                </tr>
                            @endif
                            @forelse ($niveaux as $niveau)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $niveau->nom }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-link" wire:click='toogleEditLevel({{ $niveau->id }})'>
                                            <i class="fa fa-edit" style="color: #FFC107;"></i></button>
                                        <button class="btn btn-link bounce" title="Supprimer la session" wire:click='confirmeDeleteLevel({{ $niveau->id }})'> <i
                                                class="fa fa-trash" style="color: #DC3545;"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="7"> <img src="{{ asset('images/no_data.svg') }}"
                                            alt="Data empty" width="200px">
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>
                <div class="card-footer clearfixr">
                    <div class="float-right">
                        {{ $niveaux->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
</div>
