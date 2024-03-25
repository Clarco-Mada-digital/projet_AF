<div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; width: 100%;" wire:ignore.self>

  {{-- Card header --}}
  <div class="card-header">
    <h3 class="card-title">Liste des étudiants ayant suivi le cours</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
        <i class="fas fa-expand"></i>
      </button>
      <button type="button" class="btn btn-warning" wire:click='toogleStudentListAdd'>
        <i class="fa fa-plus"></i> Ajouter des étudiants</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">
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
      <span class="tag tag-danger">
        <ul class="row">
          @forelse ($cour->etudiants as $etudiant)
          <li class="col-md-6 my-2">
            {{ $etudiant->adhesion->nom }} {{ $etudiant->adhesion->prenom }} <button class="btn btn-danger btn-sm" wire:click='removeToCours({{$cour->id}}, {{ $etudiant->id }})'>Retirer</button>
          </li>
          @empty
          <p>Aucun étudiant suivie ce cours</p>
          @endforelse
        </ul>


      </span>
    </p>
  </div>
</div>