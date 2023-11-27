<div>
    <h3 class="mb-5 pt-3">Listes cours</h3>
    <div class="row m-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gradient-primary">
                    <h3 class="card-title d-flex align-items-center"> <i class="fa fa-users fa-2x mr-2"></i> Liste des
                        cours</h3>
                    <div class="card-tools d-flex align-items-center">
                        <a href="{{ route('cours-nouveau') }}" class="btn btn-link text-light mr-4">
                            <i class="fa fa-user-plus"></i> Nouvel cours</a>
                        <div class="input-group input-group-md" style="width: 250px;">
                            <input type="search" name="table_search" class="form-control float-right"
                                placeholder="Search" wire:model.live.debounce.500ms="search">
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
                        <thead>
                            <tr>
                                <th style="width: 10%">N°</th>
                                <th style="width: 30%">Libellé</th>
                                <th class="text-center" style="width: 20%">Heur du cour</th>
                                <th class="text-center" style="width: 20%">Proffesseur</th>
                                <th style="width: 10%">Salle</th>
                                <th class="text-center" style="width: 5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cours as $cour)
                                <tr>
                                    <td> {{ $loop->index + 1 }} </td>
                                    <td> {{ $cour->nom }} </td>
                                    <td class="text-center"> {{ $cour->horaire }} </td>
                                    <td class="text-center"> {{ $cour->professeur->sexe == 'F' ? 'Mme/Mlle' : 'Mr' }}
                                        {{ $cour->professeur->nom }} </td>
                                    <td> {{ $cour->sale }} </td>
                                    <td class="text-center">
                                        <button class="btn btn-link" data-toggle="modal"
                                            data-target="#view-cours{{ $cour->id }}" spellcheck="false">
                                            <i class="fa fa-eye"></i></button>
                                        <button class="btn btn-link"> <i class="fa fa-edit"></i></button>
                                    </td>
                                </tr>

                                {{-- Partie Modal view --}}
                                <div class="modal fade" id="view-cours{{ $cour->id }}" style="display: none; "
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body p-0 ">
                                                @include('livewire.cours.view-cour')

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="6"> <img src="{{ asset('images/no_data.svg') }}"
                                            alt="Data empty" width="200px"> </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
                <div class="card-footer clearfixr">
                    <div class="float-right">
                        {{-- {{ $cours->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
