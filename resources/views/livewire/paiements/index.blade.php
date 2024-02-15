@section('title', 'paiements')

@section('titlePage', 'PAIEMENTS')

<div>
    <h3 class="mb-5 pt-3">Liste des paiements</h3>
    <div class="row mt-4 mx-2">
        <div class="col-12">
            <div class="card" style="min-height: 350px;">
                <div class="card-header bg-gradient-primary">
                    <h3 class="card-title d-flex align-items-center"> <i class="fa fa-users fa-2x mr-2"></i> Liste des
                        paiements</h3>
                    <div class="card-tools d-flex align-items-center">
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
                                <th style="width: 5%;" wire:click="setOrderField('numRecue')">N° reçue</th>
                                <th style="width: 20%;" wire:click="setOrderField('type')">Paiement pour</th>
                                <th style="width: 15%;" class="text-center" wire:click="setOrderField('montant')">Montant en Ar</th>
                                <th style="width: 20%;" class="text-center" wire:click="setOrderField('moyentPaiement')">Moyen de paiement
                                </th>
                                <th class="text-center" style="width: 15%;">Statue paiement</th>
                                <th class="text-center" style="width: 20%;">Effectuer par</th>
                                <th class="text-center" style="width: 5%;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- Content du tableau --}}
                            @forelse ($paiements as $paiement)
                                <tr>
                                    <td> {{ $paiement->numRecue }} </td>
                                    <td> {{ $paiement->type }} {{ $paiement->motif != null ? "- (".$paiement->motif.")" : "" }} </td>
                                    <td class="text-center">{{ $paiement->montant }}</td>
                                    <td class="text-center">{{ $paiement->moyenPaiement }}</td>
                                    <td class="text-center">{{ $paiement->statue }} payée</td>
                                    <td class="text-center"> <a href="#" data-toggle="modal"
                                        data-target="#viewUser" spellcheck="false" wire:click='intiUserShow({{ $paiement->user->id }})'> {{ $paiement->user->nom }} {{ $paiement->user->prenom }} </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="/generate-pdf/{{ $paiement->id }}" target="_blank" class="btn btn-link bounce">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <a href="/generate-pdf/{{ $paiement->id }}" target="_blank" class="btn btn-link">
                                            <i class="fa fa-print" ></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="7">
                                        <img src="{{ asset('images/no_data.svg') }}" alt="Data empty" width="200px">
                                    </td>
                                </tr>
                            @endforelse
                        
                        </tbody>
                    </table>

                </div>
                <div class="card-footer clearfixr">
                    <div class="float-right">
                        {{ $paiements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Partie Modal view --}}
    <div class="modal fade" id="viewUser" style="display: none; " aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content bg-transparent" style="background: url('{{asset('images/logo/alliance-francaise-d-antsiranana-logo.png')}}') center center /cover;">
                <div class="modal-body p-0">
                    @include('livewire.paiements.viewUser')
                </div>
            </div>
        </div>
    </div>

</div>
