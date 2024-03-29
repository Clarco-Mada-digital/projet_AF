<div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; width: 100%;" wire:ignore.self>
    
    {{-- Card header --}}
    <div class="card-header">
        <h3 class="card-title">A propos du cours</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                <i class="fas fa-expand"></i>
            </button>
            <button type="button" class="btn btn-warning" data-toggle="modal" spellcheck="false" data-dismiss="modal"
                wire:click='initEditCour({{ $cour[' id'] }})'>
                <i class="fa fa-pen"></i> Mettre à jour le cours</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fa fa-times"></i>
            </button>
        </div>

    </div>

    {{-- Card body --}}
    <div class="card-body">
        <strong><i class="fa fa-book mr-1"></i> Libellé du cours</strong>
        <p class="text-muted">
            {{ $cour->libelle }} niveau <b>{{ $cour->level->implode('libelle', '/') }}</b> {{ $cour->professeur->sexe == 'F'
            ? 'Avec Mme/Mlle '.$cour->professeur->prenom : 'Avec Mr '.$cour->professeur->prenom }}
        </p>
        <hr>
        <strong><i class="fa fa-list mr-1"></i> Session du cours</strong>
        <p class="text-muted"> {{ $cour->session->nom }} </p>
        <hr>
        <strong><i class="fa fa-clock mr-1"></i> Horaire du cours</strong>
        <p class="text-muted"> {{ $cour->horaireDuCour }} </p>
        <hr>
        <strong><i class="fa fa-thermometer mr-1"></i> Salle du cours</strong>
        <p class="text-muted"> {{ $cour->salle }} </p>
        <hr>
        <strong><i class="fa fa-user mr-1" aria-hidden="true"></i> Professeur</strong>
        <p class="text-muted">
            <span class="tag tag-danger">
                Nom: {{ $cour->professeur->nom }} {{ $cour->professeur->prenom }}<br>
                Nationalité: {{ $cour->professeur->nationalite }} <br>
                Contact: {{ $cour->professeur->telephone1 }} @if ($cour->professeur->telephone2) | {{
                $cour->professeur->telephone1 }} @endif | {{ $cour->professeur->email }} <br>
            </span>
        </p>
        <hr>
        <strong><i class="fa fa-comments mr-1"></i> Commentaire</strong>
        <p class="text-muted"> {{ $cour->coment }} </p>
    </div>
</div>