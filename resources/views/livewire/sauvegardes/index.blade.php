@section('title', 'Sauvegardes')

@section('titlePage', 'SAUVEGARDE & RESTAURATION')

<div>
    <h3 class="mb-5 pt-3">Sauvegardes & Restaurations</h3>
    <div class="row mt-4 mx-2">
        <div class="col-12">
            <div class="card" style="min-height: 350px;">
                <div class="card-header bg-gradient-primary">
                    <h3 class="card-title d-flex align-items-center"> <i class="fa fa-users fa-2x mr-2"></i> Liste des
                        sauvegardes</h3>
                    <div class="card-tools d-flex align-items-center">
                        <button class="btn btn-success mx-3" wire:click='saveDB'>
                            <i class="fa fa-plus"></i>
                            Créer un sauvegarde
                        </button>
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
                                <th wire:click="setOrderField('numRecue')">N°</th>
                                <th wire:click="setOrderField('type')">Nom du sauvegarde</th>
                                <th wire:click="setOrderField('type')" wire:click="setOrderField('created_at')">Date de
                                    sauvegarde</th>
                                <th wire:click="setOrderField('type')">Taille du sauvegarde</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- Content du tableau --}}
                            @forelse ($Lists as $save)
                            <tr>
                                <td> {{ $loop->index + 1 }} </td>
                                <td> {{ $save[0] }} </td>
                                <td> {{ Carbon\Carbon::create($save[1])->diffForHumans() }} </td>
                                <td> {{$save[2] }} </td>
                                <td class="text-center">
                                    <a href="{{$repertoire_sauvegardes.$SaveLists[$loop->index]}}" class="btn btn-link" target="_blank">
                                        <i class="fa fa-save"></i>
                                    </a>
                                    <button class="btn btn-link" wire:click.prefetch="restoreDB({{ $loop->index }})">
                                        <i class="fa fa-recycle"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="6">
                                    <img src="{{ asset('images/no_data.svg') }}" alt="Data empty" width="200px">
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>


</div>