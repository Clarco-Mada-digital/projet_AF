@section('title', 'etudiant')

<div>

    <div @if ($state !='view' ) style="display: none;" @endif style="font-size: .9rem;">
        <h3 class="mb-2 pt-3">Liste des étudiants</h3>
        <div class="row mt-4 mx-2">
            <div class="col-12">
                <h6 class="fw-bold">Filtre :</h6>
                <div class="d-flex align-items-center">
                    <div class="mb-3" style="width: 18vmin;">
                        <div class="form-group">
                            <label for="filteredLevelForm">Statut/niveaux par :</label>
                            <select class="form-control" id="filteredLevelForm" aria-label="Filter form"
                                wire:model.live="filteredByLevel">
                                <option value="" selected>Tout</option>
                                @foreach ($allLevel as $level)
                                <option value="{{ $level->id }}">{{ $level->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 mx-3" style="width: 20vmin;">
                        <div class="form-group">
                            <label for="filteredPaiementForm">Types d'inscriptions :</label>
                            <select class="form-control" id="filteredInscriptionForm" aria-label="Filter form"
                                wire:model.live="filteredByCourExamen">
                                <option value="" selected>Tout</option>
                                <option value="cours">Cours</option>
                                <option value="examens">Examen</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 mx-3 @if ($filteredByCourExamen == "") d-none @endif" style="width: 20vmin;">
                        <div class="form-group">
                            <label for="filteredPaiementForm">Sessions :</label>
                            <select class="form-control" id="filteredSessionForm" aria-label="Filter form"
                                wire:model.live="filteredBySessions">
                                <option value="" selected>Tout</option>
                                @foreach ($sessions as $session)
                                @if ($session->type == $filteredByCourExamen)
                                <option value="{{ $session->id }}">{{ $session->nom }}</option>                                    
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 mx-3" style="width: 20vmin;">
                        <div class="form-group">
                            <label for="filteredPaiementForm">Payé :</label>
                            <select class="form-control" id="filteredPaiementForm" aria-label="Filter form"
                                wire:model.live="filteredByPaiement">
                                <option value="" selected>Tout</option>
                                <option value='1'>Totalement</option>
                                <option value='0'>Partialement</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header bg-gradient-primary">
                        <h3 class="card-title d-flex align-items-center"> <i class="fa fa-users fa-2x mr-2"></i> Liste
                            des
                            étudiants</h3>
                        <div class="card-tools d-flex align-items-center">
                            <a class="btn btn-link text-light mr-4" wire:click="toogleStateName('new')">
                                <i class="fa fa-user-plus"></i> Nouvel étudiant</a>
                            <div class="input-group input-group-md" style="width: 250px;">
                                <input type="search" name="student_search" class="form-control float-right"
                                    placeholder="Rechercher" wire:model.live.debounce.500ms="search" autocomplete="off">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0 table-striped">
                        <table class="table table-head-fixed text-nowrap">
                            {{-- table header --}}
                            <thead>
                                <tr>
                                    <th style="width: 5%;"></th>
                                    <th class="text-center" wire:click="setOrderField('numCarte')">N° de carte</th>
                                    <th wire:click="setOrderField('nom')">Nom</th>
                                    <th wire:click="setOrderField('prenom')">Prénom</th>
                                    <th class="text-center">Téléphone</th>
                                    <th class="text-center">Cours | Examen</th>
                                    <th class="text-center">Session</th>
                                    <th class="text-center">Statut</th>
                                    {{-- <th class="text-center">Paiement</th> --}}
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            {{-- table body --}}
                            <tbody>
                                @forelse ($etudiants as $etudiant)
                                <tr class=" @foreach ($etudiant->adhesion->inscriptions as $inscription)
                                    {{ $inscription->statut ? '' : " text-danger" }} @endforeach ">
                                    <td>
                                        @if ($etudiant->adhesion->profil != null)
                                        <img class=" img-circle" src="{{ asset('storage/' . $etudiant->adhesion->profil) }}"
                                    width='50' alt="profil etudiant">
                                    @else
                                    <img class="img-circle"
                                        src="{{ 'https://eu.ui-avatars.com/api/?name=' . $etudiant->adhesion->nom . '&background=random' }}"
                                        width='50' alt="profil etudiant">
                                    @endif

                                    </td>
                                    <td class="text-center">{{ $etudiant->adhesion->numCarte }}</td>
                                    <td>{{ $etudiant->adhesion->nom }}</td>
                                    <td>{{ $etudiant->adhesion->prenom }}</td>
                                    <td class="text-center">{{ $etudiant->adhesion->telephone1 }}</td>
                                    <td class="text-center">
                                        @if ($etudiant->cours->count() > 0)
                                        {{ Str::words($etudiant->cours->implode('libelle', ' | '), 3, '...') }}
                                        @endif
                                        |
                                        @if ($etudiant->examens->count() > 0)
                                        {{ Str::words('Examen '.$etudiant->examens->implode('libelle', ' | '), 3, '...')  }}
                                        @endif
                                    </td>
                                    <td class="text-center"> {{ Str::words($etudiant->session->implode("nom", ' | '), 5, '...') }} </td>
                                    <td
                                        class="text-center">
                                        {{ $etudiant->level->libelle }} </td>
                                    {{-- <td
                                        class="text-center">
                                        @foreach ($etudiant->inscription as $inscription)
                                             {{ $inscription->statut ? $paiementStatus = "" : $paiementStatus = "A moitie" }}
                                        @endforeach
                                        {{ $paiementStatus }}                                   
                                    </td> --}}
                                    <td class="text-center">
                                        <button class="btn btn-link" data-toggle="modal"
                                            data-target="#view-etudiant{{ $etudiant->id }}" spellcheck="false"> <i
                                                class="fa fa-eye" style="color: #0DCAF0;"></i></button>
                                        <button class="btn btn-link @cannot('étudiants.edit') disabled @endcannot"
                                            wire:click='initDataEtudiant({{ $etudiant->id }})' spellcheck="false">
                                            <i class="fa fa-edit" style="color: #FFC107;"></i></button>
                                    </td>
                                </tr>

                                {{-- Partie Modal view --}}
                                <div class="modal fade" id="view-etudiant{{ $etudiant->id }}" style="display: none; "
                                    aria-hidden="true" wire:ignore.self>
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body p-0 ">
                                                @include('livewire.etudiants.view')

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @empty
                                <tr>
                                    <td class="text-center" colspan="9"> <img src="{{ asset('images/no_data.svg') }}"
                                            alt="Data empty" width="200px">
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfixr">
                        <div class="float-right">
                            {{ $etudiants->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div @if ($state !='edit' ) style="display: none;" @endif>
        <h3 class="mb-5 pt-3">Modifier étudiant</h3>
        <div class="row m-4 p-0">
            @include('livewire.etudiants.edit')
        </div>
    </div>
</div>