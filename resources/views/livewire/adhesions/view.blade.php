<div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; width: 100%;">
  <div class="card-header">
    <h3 class="card-title">Listes des membres</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
        <i class="fas fa-expand"></i>
      </button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">
        <i class="fa fa-times"></i>
      </button>
    </div>

  </div>

  <div class="card-body">
    <div class="d-flex justify-content-between aligne-items-center">
      <div class="d-flex align-items-center">
        <div class="mb-3" style="width: 18vmin;">
          <div class="form-group">
            {{-- <label for="filteredLevelForm">Catégories :</label> --}}
            <select class="form-control" id="filteredCat" aria-label="Filter form"
              wire:model.live="filterByCat">
              <option value="" selected>Catégories</option>
              @foreach ($categories as $categorie)
              <option value="{{ $categorie->id }}">{{ $categorie->libelle }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="input-group w-50 mb-4 pb-2">
        <input type="search" class="form-control" spellcheck="false" name="membre_search"
          placeholder="Rechercher un membre" wire:model.live.debounce.500ms="search_membre" autocomplete="false">
        <div class="input-group-append">
          <span class="input-group-text"><i class="fa fa-search"></i></span>
        </div>
      </div>
    </div>

    <table class="table table-head-fixed text-nowrap table-striped table-bordered">
      {{-- table header --}}
      <thead>
        <tr>
          <th style="width: 5%;">Profil</th>
          <th class="text-center" wire:click="setOrderField('numCarte')">N° de carte</th>
          <th wire:click="setOrderField('nom')">Nom</th>
          <th wire:click="setOrderField('prenom')">Prénom</th>
          <th class="text-center">Téléphone</th>
          <th class="text-center">Catégorie</th>
          <th class="text-center">Date fin d'adhésion</th>
          {{-- <th class="text-center">Paiement</th> --}}
          <th style="width: 10%;" class="text-center">Action</th>
        </tr>
      </thead>

      {{-- table body --}}
      <tbody>
        @forelse ($membres as $membre)
        <tr class=" @if ($membre->finAdhesion < Carbon\Carbon::today()) text-danger @endif ">
          <td>
            @if ($membre->profil != null)
            <img class=" img-circle" src="{{ asset('storage/' . $membre->profil) }}" width='50' alt="profil etudiant">
            @else
            <img class="img-circle"
              src="{{ 'https://eu.ui-avatars.com/api/?name=' . $membre->nom . '&background=random' }}" width='50'
              alt="profil etudiant">
            @endif

          </td>
          <td class="text-center">{{ $membre->numCarte }} </td>
          <td>{{ $membre->nom }}</td>
          <td>{{ $membre->prenom }}</td>
          <td class="text-center">{{ $membre->telephone1 }} </td>
          <td class="text-center">{{ $membre->categorie->libelle }} </td>
          <td class="text-center">{{ Carbon::createFromFormat('Y-m-d', $membre->finAdhesion)->diffForHumans() }} </td>
          <td class="text-center">
            <button class="btn btn-link text-warning @cannot('étudiants.edit') disabled @endcannot"             wire:click="initUpdate({{ $membre->id }}, 'update')" data-dismiss="modal">
              <i class="fa fa-edit text-warning" ></i><br> Éditer
            </button>
            <button class="btn btn-link text-info @cannot('étudiants.new') disabled @endcannot" 
            wire:click="initUpdate({{ $membre->id }}, 'reInscription')" data-dismiss="modal">
              <i class="fa fa-pen text-info" ></i><br> Inscription
            </button>
          </td>
        </tr>

        @empty
        <tr>
          <td class="text-center" colspan="8"> <img src="{{ asset('images/no_data.svg') }}" alt="Data empty"
              width="200px">
          </td>
        </tr>
        @endforelse

      </tbody>
    </table>

  </div>
  <div class="card-footer clearfixr">
    <div class="float-right">
      {{ $membres->links() }}
    </div>
  </div>
</div>