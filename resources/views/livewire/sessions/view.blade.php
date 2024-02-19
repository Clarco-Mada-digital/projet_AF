<div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; width: 100%;" wire:ignore.self>

    {{-- Card header --}}
    <div class="card-header">
        <h3 class="card-title text-center">
            {{ $session->nom }}
            <span class="btn btn-sm @if ($session->statue) btn-success @else btn-danger @endif"> @if ($session->statue) Active
                @else Inactive @endif </span>
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                <i class="fas fa-expand"></i>
            </button>
            {{-- <button type="button" class="btn btn-warning" data-toggle="modal" spellcheck="false"
                data-dismiss="modal" wire:click='initEditCour({{ $cour[' id'] }})'>
                <i class="fa fa-pen"></i> Mettre à jour le cour</button> --}}
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fa fa-times"></i>
            </button>
        </div>

    </div>

    {{-- Card body --}}
    <div class="card-body">
        <strong><i class="fa fa-book mr-1"></i> Date du session </strong>
        <p class="text-muted">
            {{ Date("d M, Y", strtotime($session->dateDebut)) }} - {{ Date('d M, Y', strtotime($session->dateFin)) }}
        </p>
        <hr>
        @if ($session->dateFinPromo != null & $session->dateFinPromo > $now)
        <strong><i class="fa fa-book mr-1"></i> En promotion </strong>
        <p class="text-muted">
            En promo jusqu' a {{ \Carbon\Carbon::parse($session->dateFinPromo)->diffForHumans() }} </br>
            Avec montant de {{$session->montantPromo }} Ar
        </p>
        <hr>
        @else
        <strong><i class="fa fa-book mr-1"></i> Montant du session </strong>
        <p class="text-muted">
           {{$session->montant }} Ar
        </p>
        <hr>
        @endif

        <strong><i class="fa fa-book mr-1"></i> List des cours </strong>
        <p class="text-muted">
            {{ $session->cours->implode('libelle', ' | ') }}
        </p>
    </div>
</div>