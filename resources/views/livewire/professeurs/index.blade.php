@section('title', 'professeur')

@section('titlePage', 'PROFESSEUR')

<div>
    <div @if ($sectionName != 'list') style="display: none;" @endif>
        <h3 class="mb-5 pt-3">Liste des professeurs</h3>
        <div class="row m-4">
            <div class="col-12">
                <div class="card" style="min-height: 350px;">
                    <div class="card-header bg-gradient-primary">
                        <h3 class="card-title d-flex align-items-center"> <i class="fa fa-users fa-2x mr-2"></i> Liste des
                            professeurs</h3>
                        <div class="card-tools d-flex align-items-center">
                            <button class="btn btn-link text-light mr-4" wire:click="toogleSectionName('new')">
                                <i class="fa fa-user-plus"></i> Ajouter un nouveau professeur</button>
                            <div class="input-group input-group-md" style="width: 250px;">
                                <input type="search" name="table_search" class="form-control float-right"
                                    placeholder="Rechercher" wire:model.live.debounce.500ms="search">
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
                                    <th class="text-center" wire:click="setOrderField('nom')">Prénom
                                    </th>
                                    <th class="text-center" >nationalité</th>
                                    <th class="text-center" >Téléphone</th>
                                    <th class="text-center" >Email</th>
                                    <th class="text-center" >Cours</th>
                                    <th class="text-center" >Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($professeurs as $professeur)
                                    <tr>
                                        <td>
                                            @if ($professeur->profil != null)
                                                <img class="img-circle"
                                                    src="{{ asset('storage/' . $professeur->profil) }}" width='50'
                                                    alt="profil professeur">
                                            @else
                                                <img class="img-circle"
                                                    src="{{ 'https://eu.ui-avatars.com/api/?name=' . $professeur->nom . '&background=random' }}"
                                                    width='50' alt="profil etudiant">
                                            @endif

                                        </td>
                                        <td wire:click="setOrderField('nom')">{{ $professeur->nom }}</td>
                                        <td class="text-center" wire:click="setOrderField('prenom')">{{ $professeur->prenom }}</td>
                                        <td class="text-center" wire:click="setOrderField('nationalite')">{{ $professeur->nationalite }}</td>
                                        <td class="text-center">{{ $professeur->telephone1 }}</td>
                                        <td class="text-center"> {{ $professeur->email }} </td>
                                        <td class="text-center"> {{ $professeur->cours->implode('libelle', ' | ') }} </td>
                                        <td class="text-center">
                                            <button class="btn btn-link"><i class="fa fa-eye" data-toggle="modal"
                                                    data-target="#view-professeur{{ $professeur->id }}"
                                                    spellcheck="false"></i></button>
                                            <button class="btn btn-link"><i class="fa fa-edit" style="color: #FFC107;"
                                                    wire:click="toogleSectionName('edit', {{ $professeur->id }})"></i></button>
                                            <button class="btn btn-link bounce" wire:click='confirmeDeleteProf({{$professeur->id}})'> <i class="fa fa-trash"
                                                    style="color: #DC3545;"></i></button>
                                        </td>
                                    </tr>

                                    {{-- Partie Modal view --}}
                                    <div class="modal fade" id="view-professeur{{ $professeur->id }}"
                                        style="display: none; " aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-0 ">
                                                    @include('livewire.professeurs.view')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="8"> <img
                                                src="{{ asset('images/no_data.svg') }}" alt="Data empty" width="200px">
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>

                    </div>
                    <div class="card-footer clearfixr">
                        <div class="float-right">
                            {{ $professeurs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div @if ($sectionName != 'edit') style="display: none;" @endif>
        <h3 class="mb-5 pt-3">Modifier professeur</h3>
        <div class="row m-4 p-0">
            @include('livewire.professeurs.edit')
        </div>
    </div>

    <div @if ($sectionName != 'new') style="display: none;" @endif>
        <h3 class="mb-5 pt-3">Nouvel professeur</h3>
        <div class="row m-4 p-0">
            @include('livewire.professeurs.new')
        </div>
    </div>

</div>
