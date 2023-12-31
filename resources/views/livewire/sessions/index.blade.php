@section('title', 'sessions')

@section('titlePage', 'SESSIONS')

<div>
    <h3 class="mb-5 pt-3">Liste des sessions</h3>
    <div class="row mt-4 mx-2">
        <div class="col-12">
            <div class="card" style="min-height: 350px;">
                <div class="card-header bg-gradient-primary">
                    <h3 class="card-title d-flex align-items-center"> <i class="fa fa-users fa-2x mr-2"></i> Liste des
                        sessions</h3>
                    <div class="card-tools d-flex align-items-center">
                        <button class="btn btn-link text-light mr-4" wire:click='toogleFormSession'>
                            <i class="fa fa-user-plus"></i> Nouvelle session</button>
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
                                <th style="width: 20%" wire:click="setOrderField('nom')">Nom</th>
                                <th class="text-center" style="width: 15%">Date de début</th>
                                <th class="text-center" style="width: 15%">Date de fin</th>
                                <th class="text-center" style="width: 20%">Montant en Ar</th>
                                <th class="text-center" style="width: 15%" wire:click="setOrderField('statue')">Statut</th>
                                <th class="text-center" style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Section pour formulaire de nouvel session --}}
                            @if ($formNewSession)
                                <tr>
                                    <td colspan="2">
                                        <input class="form-control" type="text" placeholder="Nom de session"
                                            wire:model='newSession.nom'>
                                    </td>
                                    <td>
                                        <input class="form-control" type="date" wire:model='newSession.dateDebut'>
                                    </td>
                                    <td>
                                        <input class="form-control" type="date" wire:model='newSession.dateFin'>
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" wire:model='newSession.montant'>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-info" wire:click='toogleFormCours'>Choisir les
                                            cours</button>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-warning" wire:click='addNewSession'> <i
                                                class="fa fa-plus"></i> <i class="fa fa-spinner fa-spin" wire:loading wire:target='addNewSession'></i> Add</button>
                                        <button class="btn btn-danger" wire:click='toogleFormSession'> <i
                                                class="fa fa-ban"></i> Annuler</button>
                                    </td>
                                </tr>
                            @endif
                            @if ($formEditSession)
                                <tr>
                                    <td colspan="2">
                                        <input class="form-control" type="text" placeholder="Nom de session" wire:model='editSession.nom'>
                                    </td>
                                    <td>
                                        <input class="form-control" type="date" wire:model='editSession.dateDebut'>
                                    </td>
                                    <td>
                                        <input class="form-control" type="date" wire:model='editSession.dateFin'>
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" wire:model='editSession.montant'>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-info" wire:click='toogleFormCours'>Choisir les
                                            cours</button>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-warning" wire:click="updateSession({{$editSession['id']}})"> <i
                                                class="fa fa-edit"></i> <i class="fa fa-spinner fa-spin" wire:loading wire:target="updateSession"></i> Modifier</button>
                                        <button class="btn btn-danger" wire:click="initUpdateSession({{$editSession['id']}}, 'True')"> <i
                                                class="fa fa-ban"></i> Annuler</button>
                                    </td>
                                </tr>
                            @endif
                            @forelse ($sessions as $session)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $session->nom }}</td>
                                    <td class="text-center">{{ $session->dateDebut }}</td>
                                    <td class="text-center">{{ date($session->dateFin) }}</td>
                                    <td class="text-center">{{ $session->montant }}</td>
                                    <td class="text-center"> <button
                                            class="btn btn-link @if ($session->statue) bg-gradient-success @else bg-gradient-danger @endif">
                                            @if ($session->statue)
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </button> </td>
                                    <td class="text-center">
                                        <button class="btn btn-link" wire:click="initUpdateSession({{$session->id}})">
                                            <i class="fa fa-edit" style="color: #FFC107;"></i></button>
                                        <button class="btn btn-link bounce"> <i class="fa fa-trash"
                                                style="color: #DC3545;"></i></button>
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
                    <div class="row @if (!$showFormCours) d-none @endif "
                        style="position: absolute; top:7rem; right:15px; width:55%;">
                        <div class="card card-outline card-info w-100 my-0" style="min-height: 150px;">
                            <div class="card-header py-0">
                                <h3 class="card-title">List des cours</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                        data-source="widgets.html" data-source-selector="#card-refresh-content"
                                        data-load-on-init="false" spellcheck="false">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                    <button type="button" class="btn btn-info btn-sm" wire:click='toogleFormCours'>
                                        <i class="fas fa-save"> Confirmer</i>
                                    </button>
                                </div>

                            </div>

                            <div class="card-body d-flex justify-content-center">
                                @foreach ($cours as $cour)
                                    <div class="form-group col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox"
                                                id="cour{{ $cour['id'] }}"
                                                wire:model.lazy="cours.{{ $loop->index }}.active">
                                            <label for="cour{{ $cour['id'] }}"
                                                class="custom-control-label">{{ $cour['libelle'] }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                </div>
                <div class="card-footer clearfixr">
                    <div class="float-right">
                        {{ $sessions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
