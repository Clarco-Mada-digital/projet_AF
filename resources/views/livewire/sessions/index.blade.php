@section('title', 'sessions')

@section('titlePage', 'SESSIONS')

<div>
    <h3 class="mb-5 pt-3">Liste des sessions</h3>
    <div class="row mt-4 mx-2">
        <div class="col-12">
            <div class="card" style="min-height: 400px;">

                {{-- En tête de la card --}}
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

                {{-- corp de la card --}}
                <div class="card-body table-responsive p-0 table-striped" style="position: relative;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 5%"></th>
                                <th style="width: 20%" wire:click="setOrderField('nom')">Nom</th>
                                <th class="text-center" style="width: 15%">Date de début</th>
                                <th class="text-center" style="width: 15%">Date de fin</th>
                                <th class="text-center" style="width: 20%">Montant en Ar</th>
                                <th class="text-center" style="width: 15%" wire:click="setOrderField('statue')">Statut
                                </th>
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
                                        <button class="btn btn-info" wire:click='toogleFormCours'> Choisir le cour
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-icon" data-toggle="modal"
                                            data-target="#newCours" spellcheck="false"> <i class="fa fa-plus"></i> <span
                                                class="btn-icon-title d-none">Cours</span> </button>
                                        <button class="btn btn-warning btn-icon" data-toggle="modal"
                                            data-target="#newPromotion" spellcheck="false"> <i class="fa fa-gift"></i>
                                            <span class="btn-icon-title d-none">Promotion</span> </button>
                                        <button class="btn btn-success btn-icon" wire:click='addNewSession'> <i
                                                class="fa fa-save"></i> <i class="fa fa-spinner fa-spin" wire:loading
                                                wire:target='addNewSession'></i> <span
                                                class="btn-icon-title d-none">Save</span> </button>
                                        <button class="btn btn-danger btn-icon" wire:click='toogleFormSession'> <i
                                                class="fa fa-ban"></i> <span
                                                class="btn-icon-title d-none">Annuler</span> </button>
                                    </td>
                                </tr>
                            @endif
                            @if ($formEditSession)
                                <tr>
                                    <td colspan="2">
                                        <input class="form-control" type="text" placeholder="Nom de session"
                                            wire:model='editSession.nom'>
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
                                        <button class="btn btn-info btn-icon" data-toggle="modal" data-target="#newCours"
                                            spellcheck="false"> <i class="fa fa-plus"></i> <span class="btn-icon-title d-none">cours</span> </button>
                                        <button class="btn btn-info btn-icon" data-toggle="modal" data-target="#editPromotion"
                                            spellcheck="false"> <i class="fa fa-gift"></i> <span class="btn-icon-title d-none">Promotion</span> </button>
                                        <button class="btn btn-warning btn-icon"
                                            wire:click="updateSession({{ $editSession['id'] }})"> <i
                                                class="fa fa-edit"></i> <i class="fa fa-spinner fa-spin" wire:loading
                                                wire:target="updateSession"></i> <span class="btn-icon-title d-none">Modifier</span> </button>
                                        <button class="btn btn-danger btn-icon"
                                            wire:click="initUpdateSession({{ $editSession['id'] }}, 'True')"> <i
                                                class="fa fa-ban"></i> <span class="btn-icon-title d-none">Annuler</span> </button>
                                    </td>
                                </tr>

                                {{-- Partie Modal edit promotion --}}
                                <div class="modal fade" id="editPromotion" style="display: none; "
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-body p-0 ">
                                                <div class="card card-primary shadow-lg mb-0"
                                                    style="transition: all 0.15s ease 0s; width: 100%;">
                                                    <div class="card-header">
                                                        <h3 class="card-title"> Définie le promotion </h3>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool"
                                                                data-card-widget="maximize" spellcheck="false">
                                                                <i class="fas fa-expand"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>

                                                    </div>
                                                    <div class="card-body row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="userNom"> Date de fin du promotion
                                                                </label>
                                                                <input type="date" class="form-control"
                                                                    id="dateFinPromotion"
                                                                    wire:model="editSession.dateFinPromo">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="userNom"> Montant </label>
                                                                <input type="number" class="form-control"
                                                                    id="montantPromotion"
                                                                    wire:model="editSession.montantPromo">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 text-right">
                                                            <button class="btn btn-success" data-dismiss="modal"> <i
                                                                    class="fa fa-save"></i> Confirmer </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @forelse ($sessions as $session)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $session->nom }}
                                        @if (($session->dateFinPromo != null) & ($session->dateFinPromo > $now))
                                            <span class="right badge badge-info">En promo</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $session->dateDebut }}</td>
                                    <td class="text-center">{{ $session->dateFin }}</td>
                                    <td class="text-center">
                                        {{ ($session->dateFinPromo != null) & ($session->dateFinPromo > $now) ? $session->montantPromo : $session->montant }}
                                    </td>
                                    <td class="text-center"> <button
                                            class="btn btn-link @if ($session->statue) text-success @else text-danger @endif">
                                            @if ($session->statue)
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </button> </td>
                                    <td class="text-center">
                                        <button class="btn btn-link"
                                            wire:click="initUpdateSession({{ $session->id }})"
                                            title="Modifier la session">
                                            <i class="fa fa-edit" style="color: #FFC107;"></i></button>
                                        <button class="btn btn-link bounce" title="Supprimer la session"> <i
                                                class="fa fa-trash" style="color: #DC3545;"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="7"> <img
                                            src="{{ asset('images/no_data.svg') }}" alt="Data empty" width="200px">
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>



                </div>
                <div class="card-footer clearfixr">
                    <div class="float-right">
                        {{ $sessions->links() }}
                    </div>
                </div>

                {{-- Partie Modal promotion --}}
                <div class="modal fade" id="newPromotion" style="display: none; " aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-body p-0 ">
                                <div class="card card-primary shadow-lg mb-0"
                                    style="transition: all 0.15s ease 0s; width: 100%;">
                                    <div class="card-header">
                                        <h3 class="card-title"> Définie le promotion </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="maximize"
                                                spellcheck="false">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>

                                    </div>
                                    <div class="card-body row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="userNom"> Date de fin du promotion </label>
                                                <input type="date" class="form-control" id="dateFinPromotion"
                                                    wire:model="newSession.dateFinPromo">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="userNom"> Montant </label>
                                                <input type="number" class="form-control" id="montantPromotion"
                                                    wire:model="newSession.montantPromo">
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <button class="btn btn-success" data-dismiss="modal"> <i
                                                    class="fa fa-save"></i> Confirmer </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Partie Modal du cour --}}
                {{-- <div class="modal fade" id="sessionCour" style="display: none; " aria-hidden="true"
                    wire:ignore.self>
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-body p-0 ">
                                <div class="card card-primary shadow-lg mb-0"
                                    style="transition: all 0.15s ease 0s; width: 100%;">

                                    <div class="card-header">
                                        <h3 class="card-title"> Section cours </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="maximize"
                                                spellcheck="false">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                            <button type="button" class="btn btn-success" data-dismiss="modal">
                                                <i class="fa fa-save"></i> Confirmer
                                            </button>
                                        </div>

                                    </div>
                                    {{-- Listes des cours 
                                    <div class="col-md-12 card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Liste des cours</h3>
                                        </div>
                                        <div class="card-body row">
                                            @forelse ($coursList as $cour)
                                                <div class="form-group col-md-4">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                            id="cour{{ $cour['id'] }}"
                                                            wire:model.lazy="coursList.{{ $loop->index }}.active">
                                                        <label for="cour{{ $cour['id'] }}"
                                                            class="custom-control-label">{{ $cour['libelle'] }}</label>
                                                    </div>
                                                </div>
                                            @empty
                                                <h3>Aucun donnée trouvé !</h3>
                                            @endforelse
                                                @json($coursList)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                {{-- Partie modal new cours --}}
                <div class="modal fade" id="newCours" style="display: none; " aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-body p-0 ">
                                <div class="card card-primary shadow-lg mb-0"
                                    style="transition: all 0.15s ease 0s; width: 100%;">

                                    {{-- En tête du modale --}}
                                    <div class="card-header">
                                        <h3 class="card-title"> Section cours </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="maximize"
                                                spellcheck = "false">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                            <button type="button" class="btn btn-success" data-dismiss="modal">
                                                <i class="fa fa-save"></i> Confirmer
                                            </button>
                                        </div>

                                    </div>

                                    {{-- Contenue du modal --}}
                                    <div class="card-body row px-2">
                                        <div class="col-md-12 mx-0" id="accordion">
                                            <div class="card card-info bg-none">
                                                <div class="card-header mx-auto" style="width: 12rem;">
                                                    <h4 class="card-title">
                                                        <a class="d-block accordion-button mx-auto collapsed"
                                                            data-toggle="collapse" href="#collapseOne"
                                                            aria-expanded="false" spellcheck="false"> <i
                                                                class="fa fa-plus"></i>
                                                            Nouveau cours
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseOne" class="collapse show" data-parent="#accordion"
                                                    style="">
                                                    <div class="card-body row">
                                                        <div class="col-md-2 form-group">
                                                            <label class="form-label" for="codeCour">Code *</label>
                                                            <input
                                                                class="form-control @error('newCour.code') is-invalid @enderror"
                                                                type="text" name="newCour" id="codeCour"
                                                                wire:model='newCour.code'>
                                                            @error('newCour.code')
                                                                <span class="invalid-feedback">Ce champ est
                                                                    obligatoire</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label class="form-label" for="codeLibellé">Libellé
                                                                *</label>
                                                            <input
                                                                class="form-control @error('newCour.libelle') is-invalid @enderror"
                                                                type="text" name="newCour" id="codeLibellé"
                                                                wire:model='newCour.libelle'>
                                                            @error('newCour.libelle')
                                                                <span class="invalid-feedback">Ce champ est
                                                                    obligatoire</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-2 form-group">
                                                            <label class="form-label" for="codeCategorie">Catégorie
                                                                *</label>
                                                            <select
                                                                class="form-control @error('newCour.level_id') is-invalid @enderror"
                                                                id="codeCategorie" wire:model='newCour.categorie'>
                                                                <option>-- Catégorie --</option>
                                                                <option value="enfant">Enfant</option>
                                                                <option value="ado">Ado</option>
                                                                <option value="adulte">Adulte</option>
                                                            </select>
                                                            @error('newCour.categorie')
                                                                <span class="invalid-feedback">Ce champ est
                                                                    obligatoire</span>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-2 form-group">
                                                            <label class="form-label" for="codeSalle">Salle</label>
                                                            <input
                                                                class="form-control @error('newCour.salle') is-invalid @enderror"
                                                                type="text" name="newCour" id="codeSalle"
                                                                wire:model='newCour.salle'>
                                                            @error('newCour.salle')
                                                                <span class="invalid-feedback">Ce champ est
                                                                    obligatoire</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-2 form-group">
                                                            <label class="form-label"
                                                                for="codeProfesseur">Professeur</label>
                                                            <select
                                                                class="form-control @error('newCour.professeur_id') is-invalid @enderror"
                                                                name="professeur" id="codeProfesseur"
                                                                wire:model='newCour.professeur_id'>
                                                                <option>-- Professeur --</option>
                                                                @foreach ($professeurs as $prof)
                                                                    <option value="{{ $prof['id'] }}">
                                                                        {{ $prof['sexe'] == 'F' ? 'Mme/Mlle' : 'M.' }}
                                                                        {{ $prof['nom'] }} </option>
                                                                @endforeach
                                                            </select>
                                                            @error('newCour.professeur_id')
                                                                <span class="invalid-feedback">Ce champ est
                                                                    obligatoire</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label class="form-label" for="codeSalle">Niveau</label>
                                                            <select multiple
                                                                class="form-control @error('newCour.level_id') is-invalid @enderror"
                                                                id="courNiveau" wire:model='newLevels'>
                                                                {{-- <option >-- Niveau --</option> --}}
                                                                @foreach ($levels as $level)
                                                                    <option value="{{ $level['id'] }}">
                                                                        {{ $level['nom'] }} </option>
                                                                @endforeach
                                                            </select>
                                                            @error('newCour.level_id')
                                                                <span class="invalid-feedback">Ce champ est
                                                                    obligatoire</span>
                                                            @enderror
                                                            <span class="text-info" style="font-size: .7rem;">**Pour
                                                                effectuer une
                                                                sélection multiple, appuyez sur Ctrl ou Cmd.**</span>
                                                        </div>

                                                        {{-- <label for="Sessions">Horaire du cour</label> --}}
                                                        <div class="col-md-8 form-group row">
                                                            {{-- Formulaire d'horaire du cour --}}
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="codeHeur">Jour</label>
                                                                <select class="form-control" name="courDay"
                                                                    wire:model='dateInput'>
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
                                                                <input class="form-control" type="time"
                                                                    name="courTime" wire:model='heurDebInput'>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label" for="codeHeur">Heure du
                                                                    fin</label>
                                                                <input class="form-control" type="time"
                                                                    name="courTime" wire:model='heurFinInput'>
                                                            </div>
                                                            <div class="col-md-3 text-right mt-3">
                                                                <button class="btn btn-info"
                                                                    wire:click="setDateHourCour">
                                                                    <i class="fa fa-plus"></i> Add</button>
                                                            </div>
                                                            <div class="col-md-6 mt-3">
                                                                <input
                                                                    class="form-control @error('dateHeurCour') is-invalid @enderror"
                                                                    type="text" disabled wire:model='dateHeurCour'>
                                                                @error('dateHeurCour')
                                                                    <span class="invalid-feedback"> Ce champ est
                                                                        obligatoire
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-3 mt-3">
                                                                <button class="btn btn-danger"
                                                                    wire:click.prevent="resetDateHourCour()">
                                                                    <i class="fa fa-undo"></i> Reset</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <label class="form-label"
                                                                for="codeComment">Commentaire</label>
                                                            <textarea class="form-control" type="text" name="newCour" id="codeComment" rows="6"
                                                                wire:model='newCour.coment'></textarea>
                                                        </div>
                                                        <div class="col-md-12 text-right">
                                                            <button class="btn btn-success" wire:click='addNewCour'>
                                                                <i class="fa fa-check"></i> Ajouter le
                                                                cour </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    {{-- Formulaire d'ajout de cours --}}
    <div class="row @if (!$showFormCours) d-none @endif "
        style="position: absolute; top:23rem; right:15px; width:55%;">
        <div class="card card-outline card-info w-100 my-0" style="height: 200px; overflow: hidden; overflow-y: scroll;">
            <div class="card-header py-0" style="position: sticky">
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

            <div class="card-body d-flex justify-content-center row">
                @foreach ($coursList as $cour)
                    <div class="form-group col-md-4">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="cour{{ $cour['id'] }}"
                                wire:model.lazy="coursList.{{ $loop->index }}.active">
                            <label for="cour{{ $cour['id'] }}"
                                class="custom-control-label">{{ $cour['libelle'] }}</label>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
</div>
</div>
