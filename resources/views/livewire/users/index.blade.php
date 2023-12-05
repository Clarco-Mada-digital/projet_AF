@section('title', 'utilisateur')

@section('titlePage', 'UTILISATEUR')

<div>
    <div @if ($sectionName != 'list') style="display: none;" @endif>
        <h3 class="mb-5 pt-3">List des ustilisateurs</h3>
        <div class="row m-4">
            <div class="col-12">
                <div class="card" style="min-height: 350px;">
                    <div class="card-header bg-gradient-primary">
                        <h3 class="card-title d-flex align-items-center"> <i class="fa fa-users fa-2x mr-2"></i> Liste des
                            utilisateurs</h3>
                        <div class="card-tools d-flex align-items-center">
                            <button class="btn btn-link text-light mr-4" wire:click="toogleSectionName('new')">
                                <i class="fa fa-user-plus"></i> inscrit un nouveau utilisateur</button>
                            <div class="input-group input-group-md" style="width: 250px;">
                                <input type="search" name="table_search" class="form-control float-right"
                                    placeholder="Recherche" wire:model.live.debounce.500ms="search">
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
                                    <th class="text-center" style="width: 15%" wire:click="setOrderField('nom')">Prenom
                                    </th>
                                    <th class="text-center" style="width: 15%">nationalité</th>
                                    <th class="text-center" style="width: 15%">Telephone</th>
                                    <th class="text-center" style="width: 20%">Email</th>
                                    <th class="text-center" style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $user->nom }}</td>
                                        <td class="text-center">{{ $user->prenom }}</td>
                                        <td class="text-center">{{ $user->nationalite }}</td>
                                        <td class="text-center">{{ $user->telephone1 }}</td>
                                        <td class="text-center"> {{ $user->email }} </td>
                                        <td class="text-center">
                                            <button class="btn btn-link"><i class="fa fa-eye" data-toggle="modal"
                                                    data-target="#view-professeur{{ $user->id }}"
                                                    spellcheck="false"></i></button>
                                            <button class="btn btn-link"><i class="fa fa-edit" style="color: #FFC107;"
                                                    wire:click="toogleSectionName('edit', {{ $user->id }})"></i></button>
                                            <button class="btn btn-link bounce"> <i class="fa fa-trash"
                                                    style="color: #DC3545;"></i></button>
                                        </td>
                                    </tr>

                                    {{-- Partie Modal view --}}
                                    <div class="modal fade" id="view-professeur{{ $user->id }}"
                                        style="display: none; " aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-0 ">
                                                    @include('livewire.users.view')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div @if ($sectionName != 'edit') style="display: none;" @endif>
        <h3 class="mb-5 pt-3">Modifier utilisateur</h3>
        <div class="row m-4 p-0">
            @include('livewire.users.edit')
        </div>
    </div>

    {{-- <div @if ($sectionName != 'new') style="display: none;" @endif>
        <h3 class="mb-5 pt-3">Modifier étudiant</h3>
        <div class="row m-4 p-0">
            @include('livewire.professeurs.new')
        </div>
    </div> --}}

</div>
