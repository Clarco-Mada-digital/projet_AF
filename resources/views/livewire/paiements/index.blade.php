@section('title', 'paiements')

@section('titlePage', 'PAIEMENTS')

<div>
    <h3 class="mb-5 pt-3">Liste des paiements</h3>
    <div class="row mt-4 mx-2">
        <div class="col-12">

            <h6 class="fw-bold">Filtre :</h6>
            <div class="d-flex align-items-center">
                <div class="mb-3 mx-3" style="width: 20vmin;">
                    <div class="form-group">
                        <label for="filteredPaiementForm">Date de paiement :</label>
                        <select class="form-control" id="filteredPaiementForm" aria-label="Filter form"
                            wire:model.live="filteredByDatePaiement">
                            <option value="" selected>Tout</option>
                            <option value="toDay">Aujourd'hui</option>
                            <option value="thisWeek">Cette semaine</option>
                            <option value="thisMonth">Ce mois</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 mx-3" style="width: 20vmin;">
                    <div class="form-group">
                        <label for="filteredPaiementForm">Sessions :</label>
                        <select class="form-control" id="filteredSessionForm" aria-label="Filter form"
                            wire:model.live="filteredBySessions">
                            <option value="" selected>Tout</option>
                            @foreach ($sessions as $session)
                            <option value="{{ $session->id }}">{{ $session->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="resumPaiement ml-auto w-25">
                    <div class="form-group">
                        <label for="filteredPaiementForm" style="text-align: end; width: 100%; font-size:1rem;">Totaux du paiement: </label>
                        <p class="w-100" style="text-align: end;">Avec {{count($paiements)}} paiement(s) : 
                            <span style="font-weight: bold;display: inline-block; font-size:1.1rem; margin-left: 1.3em;">{{$paiementTotal}} Ar</span> <br>
                            {{-- <span class="nomberToLetter" style="font-weight: bold;display: inline-block;width: 100%;text-align: end;">{{ $paiementTotal }}</span></td> --}}
                        </p>
                    </div>
                    
                </div>
            </div>

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
                                <th wire:click="setOrderField('numRecue')">N° reçue</th>
                                <th wire:click="setOrderField('type')">Paiement pour</th>
                                <th wire:click="setOrderField('type')" wire:click="setOrderField('created_at')">Date de
                                    paiement</th>
                                <th class="text-center" wire:click="setOrderField('montant')">Montant en Ar</th>
                                <th style="width: 20%;" class="text-center"
                                    wire:click="setOrderField('moyentPaiement')">Moyen de paiement
                                </th>
                                <th class="text-center">Statue paiement</th>
                                <th class="text-center">Effectuer par</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- Content du tableau --}}
                            @forelse ($paiements as $paiement)
                            <tr>
                                <td> {{ $paiement->numRecue }} </td>
                                <td title="{{ $paiement->type}} {{ $paiement->motif != null
                                    ? "- (".$paiement->motif.")" : "" }}"> {{ Str::words($paiement->type, 3, "...") }} {{ Str::words($paiement->motif != null
                                    ? "- (".$paiement->motif.")" : "", 3, "...") }} </td>
                                <td class="text-center">{{ $paiement->created_at->diffForHumans() }}</td>
                                <td class="text-center">{{ $paiement->montant }}</td>
                                <td class="text-center">{{ $paiement->moyenPaiement }}</td>
                                <td class="text-center">{{ $paiement->statue }} payée
                                    @if ($paiement->montantRestant != 0)
                                    (Reste: {{ $paiement->montantRestant }} Ar)
                                    @endif
                                </td>
                                <td class="text-center"> <a href="#" data-toggle="modal" data-target="#viewUser"
                                        spellcheck="false" wire:click='intiUserShow({{ $paiement->user->id }})'> {{
                                        $paiement->user->nom }} {{ $paiement->user->prenom }} </a>
                                </td>
                                <td class="text-center">
                                    <a href="/generate-pdf/{{ $paiement->id }}" target="_blank"
                                        class="btn btn-link bounce">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    <a href="/generate-pdf/{{ $paiement->id }}" target="_blank" class="btn btn-link">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="8">
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
            <div class="modal-content bg-transparent"
                style="background: url('{{asset('images/logo/alliance-francaise-d-antsiranana-logo.png')}}') center center /cover;">
                <div class="modal-body p-0">
                    @include('livewire.paiements.viewUser')
                </div>
            </div>
        </div>
    </div>

</div>

{{-- <script src="../../js/nombreEnLettre.js"></script>
<script>
    let nbToLetter = document.querySelectorAll('.nomberToLetter');

    nbToLetter.forEach(element => {
        chiffre = Number(element.textContent);
        element.textContent = NumberToLetter(chiffre)+" Ariary";
        console.log(chiffre);
    });
</script> --}}