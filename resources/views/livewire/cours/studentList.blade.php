<div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; width: 100%;" wire:ignore.self>

  {{-- Card header --}}
  <div class="card-header">
    <h3 class="card-title">Liste des étudiants ayant suivi le cours</h3>
    <div class="card-tools d-flex justify-content-center align-items-center">
      {{-- <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
        <i class="fas fa-expand"></i>
      </button> --}}
      <button type="button" class="btn btn-warning" wire:click='toogleStudentListAdd'>
        <i class="fa fa-plus"></i>
      </button>
      <div class="input-group ml-2">
        <select class="custom-select" wire:model='exportType'>
          <option value="csv">CSV</option>
          <option value="text">Texte</option>
          {{-- <option value="pdf">PDF</option> --}}
          <option value="md">Markdown (md)</option>
        </select>
        <div class="input-group-append">
          <button type="button" class="btn btn-info" wire:click='exportStudentList({{ $cour->id }})'>
            Exporter
          </button>
        </div>
      </div>
      <button type="button" class="btn btn-danger ml-2" data-dismiss="modal">
        <i class="fa fa-times"></i>
      </button>
    </div>

  </div>

  {{-- Card body --}}
  <div class="card-body">
    <div x-show="$wire.studentListAdd" class="row border border-info p-2" style="max-height: 300px;overflow-y: scroll;">
      @forelse ($eutdiantCours as $etudiant)
      @foreach ($etudiant->session as $session)
        <div class="custom-control custom-checkbox col-6 @if ($session->id != $cour->session->id) d-none @endif">
        <input class="custom-control-input custom-control-input-primary custom-control-input-outline" type="checkbox"
          id="{{$etudiant->id}}" spellcheck="false" value="{{$etudiant->id}}" wire:model="studentList">
        <label for="{{$etudiant->id}}" class="custom-control-label">{{ $etudiant->adhesion->nom }} {{
          $etudiant->adhesion->prenom }} ({{ $etudiant->level->libelle}})</label>
      </div>
      @endforeach      
      @empty
      <p>Aucun étudiant inscrit dans la session qui existe le cours</p>
      @endforelse
      <div class="col-12 text-right">
        <button class="btn btn-success mt-1" wire:click='addStudentCours({{$cour->id}})'>Ajouter</button>
      </div>
    </div>


    <strong><i class="fa fa-user mr-1 mt-4" aria-hidden="true"></i> Étudiants</strong>
    <p class="text-muted">
      <div class="row mt-2">
            <div class="col-md-6">
                <ul class="text-muted list-group">
                    @foreach ($cour->etudiants->take(ceil($cour->etudiants->count()/2)) as $etudiant)
                        <li class="list-group-item">{{ $etudiant->adhesion->nom }} {{ $etudiant->adhesion->prenom }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="text-muted list-group">
                    @foreach ($cour->etudiants->skip(ceil($cour->etudiants->count()/2))->take(ceil($cour->etudiants->count()/2)) as $etudiant)
                        <li class="list-group-item">{{ $etudiant->adhesion->nom }} {{ $etudiant->adhesion->prenom }}</li>
                    @endforeach
                </ul>
            </div>
            {{-- si aucun resultat est trouvé --}}
            @if ($cour->etudiants->count() == 0)
            <p>Aucun étudiant suivie ce cours</p>
            @endif
        </div>
    </p>
  </div>
  
</div>