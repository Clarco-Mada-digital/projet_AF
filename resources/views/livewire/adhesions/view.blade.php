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
    <div class="input-group w-50 mb-3 ml-auto">
      <input type="search" class="form-control" spellcheck="false" name="membre_search"
        placeholder="Rechercher un membre" wire:model.live.debounce.500ms="search_membre" autocomplete="false">
      <div class="input-group-append">
        <span class="input-group-text"><i class="fa fa-search"></i></span>
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
          {{-- <th class="text-center">Paiement</th> --}}
          <th class="text-center">Action</th>
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
          <td class="text-center">{{ $membre->numCarte }}</td>
          <td>{{ $membre->nom }}</td>
          <td>{{ $membre->prenom }}</td>
          <td class="text-center">{{ $membre->telephone1 }}</td>
          <td class="text-center">
            <button class="btn btn-link @cannot('étudiants.edit') disabled @endcannot" spellcheck="false" wire:click='initUpdate({{ $membre->id }})' data-dismiss="modal">
              <i class="fa fa-edit" style="color: #FFC107;"></i>
            </button>
          </td>
        </tr>

        @empty
        <tr>
          <td class="text-center" colspan="6"> <img src="{{ asset('images/no_data.svg') }}" alt="Data empty"
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