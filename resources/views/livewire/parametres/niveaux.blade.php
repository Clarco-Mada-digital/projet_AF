<div class="col-lg-12 col-xl-6">
    <div class="card" style="min-height: 350px;">
        {{-- card header --}}
        <div class="card-header bg-gradient-primary">
            <h3 class="card-title d-flex align-items-center">
                @if ($key == 'Niveaux')
                <i class="fa fa-bars fa-2x mr-2"></i>
                @elseif ($key == 'Categories')
                <i class="fa fa-tag fa-2x mr-2"></i>
                @elseif ($key == 'Tarifs')
                <i class="far fa-credit-card fa-2x mr-2"></i>
                @elseif ($key == 'Permissions')
                <i class="fas fa-fingerprint fa-2x mr-2"></i>
                @endif
                Liste des {{ $key }}
            </h3>
            <div class="card-tools d-flex align-items-center">
                <button class="btn btn-link text-light mr-4" data-toggle="modal" data-target="#view-params"
                    spellcheck="false" wire:click="initModal('{{ $key }}')">
                    <i class="fa fa-plus"></i> {{ $key }}</button>
                <div class="input-group input-group-md" style="width: 250px;">
                    <input type="search" name="table_search" class="form-control float-right" placeholder="Rechercher "
                        wire:model.live.debounce.500ms="search{{ $key }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- card body --}}
        <div class="card-body table-responsive p-0 table-striped" style="position: relative;">
            <table class="table table-head-fixed text-nowrap">
                {{-- table header --}}
                <thead>
                    <tr>
                        <th style="width: 5%"></th>
                        <th @if ($key=='Tarifs' || $key=='Examens' ) wire:click="setOrderField('nom')" @else
                            wire:click="setOrderField('libelle')" @endif>Nom</th>
                        @if ($key == 'Tarifs' || $key == 'Examens')
                        <th class="text-center" wire:click="setOrderField('montant')">Montant en Ar</th>
                        @endif
                        <th class="text-center" style="width: 10%">Action</th>
                    </tr>
                </thead>

                {{-- table body --}}
                <tbody>
                    @forelse ($niveaux as $niveau)
                    <tr>
                        <td> {{ $loop->index + 1 }} </td>
                        <td>
                            @if ($key == 'Tarifs')
                            {{ $niveau->nom }} - {{ $niveau->levels->implode("libelle", " | ")}}                            
                            @elseif ($key == 'Examens')
                            {{ $niveau->libelle }} - {{ $niveau->level->libelle }} 
                            @else
                            {{ $niveau->libelle }}
                            @endif
                        </td>
                        @if ($key == 'Tarifs')
                        <td class="text-center"> {{ $niveau->montant }} </td>
                        @endif
                        @if ($key == 'Examens')
                        <td class="text-center"> {{ $niveau->price->montant }} </td>
                        @endif
                        <td class="text-center">
                            <button class="btn btn-link" data-toggle="modal" data-target="#view-params"
                                spellcheck="false" wire:click="editModal('{{ $key }}', '{{ $niveau->id }}')">
                                <i class="fa fa-edit" style="color: #FFC107;"></i></button>
                            <button class="btn btn-link bounce" title="Supprimer la session"
                                wire:click="confirmeDeleteLevel('{{ $niveau->id }}', '{{$key}}')"> <i
                                    class="fa fa-trash" style="color: #DC3545;"></i></button>
                        </td>
                    </tr>

                    {{-- Partie Modal view --}}
                    <div class="modal fade" id="view-params" style="display: none; " aria-hidden="true"
                        wire:ignore.self>
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content bg-transparent">
                                <div class="modal-body p-0">
                                    @if ($edit)
                                    @include('livewire.parametres.edit')
                                    @else
                                    @include('livewire.parametres.new')
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
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

        {{-- card footer --}}
        <div class="card-footer clearfixr">
            <div class="float-right">
                {{ $niveaux->links() }}
            </div>
        </div>

    </div>

</div>