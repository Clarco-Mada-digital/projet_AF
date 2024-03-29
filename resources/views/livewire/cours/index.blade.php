@section('title', 'cours')

@section('titlePage', 'COURS')

<div>
    <div @if ($state !='view' ) style="display: none;" @endif>
        <h3 class="mb-5 pt-3">Listes des cours</h3>
        <div class="row mt-4 mx-2">
            <div class="col-12">
                <div class="card">

                    {{-- Card header --}}
                    <div class="card-header bg-gradient-primary">
                        <h3 class="card-title d-flex align-items-center"> <i class="fa fa-users fa-2x mr-2"></i> Liste
                            des
                            cours</h3>
                        <div class="card-tools d-flex align-items-center">
                            <a href="{{ route('cours-nouveau') }}" class="btn btn-link text-light mr-4">
                                <i class="fa fa-user-plus"></i> Nouveau cours</a>
                            <div class="input-group input-group-md" style="width: 250px;">
                                <input type="search" name="table_search" class="form-control float-right"
                                    placeholder="Rechercher" wire:model.live.debounce.500ms="search" autocomplete="off">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card body --}}
                    <div class="card-body table-responsive p-0 table-striped">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 5%">N°</th>
                                    <th style="width: 5%">Code</th>
                                    <th style="width: 25%">Libellé</th>
                                    <th class="text-center" style="width: 20%">Heure du cours</th>
                                    <th class="text-center" style="width: 25%">Professeur</th>
                                    <th style="width: 10%">Salle</th>
                                    <th class="text-center" style="width: 10%">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($cours as $cour)
                                <tr>
                                    <td> {{ $loop->index + 1 }} </td>
                                    <td> {{ $cour->code }} </td>
                                    <td> {{ $cour->libelle }} </td>
                                    <td class="text-center"> {{ Str::words($cour->horaireDuCour, 5, "...") }} </td>
                                    <td class="text-center">
                                        {{ $cour->professeur->sexe == 'F' ? 'Mme/Mlle' : 'Mr' }}
                                        {{ $cour->professeur->nom }} </td>
                                    <td> {{ $cour->salle }} </td>
                                    <td x-data="{ showTooltip : {list:false, view:false, edit:false, delete:false}}"
                                        class="text-center">
                                        <button class="btn btn-link" data-toggle="modal"
                                            data-target="#view-cours{{ $cour->id }}" spellcheck="false"
                                            wire:click="initStudentList('True', '{{ $cour->id }}')" @mouseover = "showTooltip.list = true" @mouseover.away = "showTooltip.list = false">
                                            <i class="fa fa-list"></i></button>
                                        <button class="btn btn-link" data-toggle="modal"
                                            data-target="#view-cours{{ $cour->id }}" spellcheck="false"
                                            wire:click="initStudentList('False', '{{ $cour->id }}')" @mouseover = "showTooltip.view = true" @mouseover.away = "showTooltip.view = false">
                                            <i class="fa fa-eye" style="color: #0DCAF0;"></i></button>
                                        <button class="btn btn-link @cannot('cours.edit') disabled @endcannot"
                                            wire:click="initEditCour('{{ $cour->id }}')" @mouseover = "showTooltip.edit = true" @mouseover.away = "showTooltip.edit = false"> <i class="fa fa-edit"
                                                style="color: #FFC107;"></i></button>
                                        <button class="btn btn-link bounce @cannot('cours.delete') disabled @endcannot"
                                            wire:click='confirmeDeleteLevel({{ $cour->id }})' @mouseover = "showTooltip.delete = true" @mouseover.away = "showTooltip.delete = false"> <i class="fa fa-trash"
                                                style="color: #DC3545;"></i></button>
                                        <div>
                                            <span x-show="showTooltip.list"
                                                class="text-primary p-2 rounded mt-4">Liste des étudiants</span>
                                            <span x-show="showTooltip.view" class="text-info p-2 rounded mt-4">Détail</span>
                                            <span x-show="showTooltip.edit"
                                                class="text-warning p-2 rounded mt-4">Modifier</span>
                                            <span x-show="showTooltip.delete"
                                                class="text-danger p-2 rounded mt-4">Supprimer</span>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Partie Modal view --}}
                                <div class="modal fade" id="view-cours{{ $cour->id }}" style="display: none; "
                                    aria-hidden="true" wire:ignore.self>
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body p-0 ">
                                                @if ($viewListStudent == True)
                                                @include('livewire.cours.studentList')
                                                @else
                                                @include('livewire.cours.view-cour')
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="7"> <img src="{{ asset('images/no_data.svg') }}"
                                            alt="Data empty" width="200px"> </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

                    <div class="card-footer clearfixr">
                        <div class="float-right">
                            {{ $cours->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Partie Section edit --}}
    <div @if ($state !='edit' ) style="display: none;" @endif>
        <div class="row mx-4 pt-4">
            <div class="col-md-12 my-3">
                <h3 class="flex-grow-1">Nouveau cour: </h3>
            </div>
            <div class="col-md-12">
                @include('livewire.cours.editCour')
            </div>
        </div>
    </div>

</div>