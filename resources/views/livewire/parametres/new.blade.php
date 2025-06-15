<div class="card card-primary shadow-lg m-0 p-0"
  style="transition: all 0.15s ease 0s; background:rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">

  <div class="card-body p-0 m-0">
    <div class="d-flex justify-content-center flex-column mr-1">
      <div class="card card-primary card-outline bg-transparent">
        <div class="card-body box-profile">
          <div class="text-center">
            <h2 class="text-white mb-3"> {{ Str::upper($titleModal) }} </h2>
            <div x-show="$wire.titleModal == 'nouveau tarifs'" class="form-group">
              <div class="custom-control custom-switch custom-switch-off-warning custom-switch-on-info">
                <label class="text-white mr-4 pr-4" for="customSwitch3">Par Niveaux</label>
                <input type="checkbox" class="custom-control-input" id="customSwitch3" spellcheck="false" wire:model='typeTarif'>
                <label class="custom-control-label text-white" for="customSwitch3">Par Catégorie</label>
              </div>
            </div>
            <div class="d-flex justify-content-center">
              <div class="w-100 d-flex justify-content-center align-items-center">

                <div class="w-100">
                  <input class="form-control @error($champ) border-danger @enderror" type="text"
                    placeholder="{{$titleModal}}" wire:model='{{$champ}}' wire:keydown.enter="{{$submitFunction}}">
                  {{-- message d'erreur --}}
                  @error($champ) <span class="text-danger fs-3"> {{ $message }} </span> @enderror
                </div>


                {{-- section pour tarifs --}}
                @if ($titleModal == 'nouveau tarifs')
                <input class="form-control mx-2 @error('dataTarifs.montant') border-danger @enderror" type="text"
                  placeholder="Montant" type="number" wire:model='dataTarifs.montant'>

                <select x-show="!$wire.typeTarif" class="form-control w-100 @error('dataTarifs.level_id') is-invalid @enderror" multiple
                  id="tarifLevel" wire:model='dataTarifs.level_id'>
                  @foreach ($levels as $level)
                  <option value="{{ $level['id'] }}">{{ $level['libelle'] }}</option>
                  @endforeach
                </select>
                <select x-show="$wire.typeTarif" class="form-control w-100 @error('dataTarifs.categorie_id') is-invalid @enderror"
                  id="tarifCategorie" wire:model='dataTarifs.categorie_id'>
                  @foreach ($categories as $categorie)
                  <option value="{{ $categorie['id'] }}">{{ $categorie['libelle'] }}</option>
                  @endforeach
                </select>
                @endif

                @if ($titleModal == 'nouveau examens')
                <select class="form-control w-100 mx-2 @error('dataExamens.level_id') is-invalid @enderror"
                  id="examLevel" wire:model='dataExamens.level_id'>
                  @foreach ($levels as $level)
                  <option value="{{ $level['id'] }}">{{ $level['libelle'] }}</option>
                  @endforeach
                </select>
                <select class="form-control w-100 mx-2 @error('dataExamens.session_id') is-invalid @enderror"
                  id="examSession" wire:model='dataExamens.session_id'>
                  <option> --- Sessions --- </option>
                  @foreach ($sessions as $session)
                  <option value="{{ $session['id'] }}">{{ $session['nom'] }}</option>
                  @endforeach
                </select>
                <select class="form-control w-100 @error('dataExamens.price_id') is-invalid @enderror" id="codeExamen"
                  wire:model='dataExamens.price_id'>
                  <option> --- Tarification --- </option>
                  @foreach ($prices as $price)
                  <option value="{{ $price['id'] }}">{{ $price['nom'] }} - {{ $price->levels->implode("libelle", " |
                    ")}}</option>
                  @endforeach
                </select>
                @endif

                @if ($titleModal == 'nouveau salles')
                <input class="form-control mx-2 @error('descSalle') border-danger @enderror" type="text"
                  placeholder="Description" wire:model='descSalle'>
                @endif

              </div>
              <button class="btn btn-success ml-3" wire:click='{{$submitFunction}}' style="height: 40px;">
                <i class="fa fa-spinner fa-spin" wire:loading wire:target='{{$submitFunction}}'></i>
                Enregistrer
              </button>
            </div>


          </div>
        </div>
      </div>
    </div>

  </div>