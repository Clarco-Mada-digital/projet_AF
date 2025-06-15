<div class="card card-primary shadow-lg m-0 p-0"
  style="transition: all 0.15s ease 0s; background:rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">

  <div class="card-body p-0 m-0">
    <div class="d-flex justify-content-center flex-column mr-1">
      <div class="card card-primary card-outline bg-transparent">
        <div class="card-body box-profile">
          <div class="text-center">
            <h2 class="text-white mb-3"> {{ $titleModal }} </h2>
            <div class="d-flex justify-content-center">
              <div class="w-100 d-flex justify-content-center align-items-center">

                <input class="form-control @error('newLevel') border-danger @enderror" type="text"
                  wire:model='{{$champ}}' wire:keydown.enter="{{$submitFunction}}">
                @error('editLevel') <span class="text-danger fs-3"> {{ $message }} </span> @enderror
                
                {{-- section pour tarifs --}}
                @if ($titleModal == 'edit tarifs')
                <input class="form-control mx-2 @error('dataTarifs.montant') border-danger @enderror" type="text"
                  placeholder="Montant" type="number" wire:model='dataTarifs.montant'>

                @if ($editTarifId->categories != "[]")
                <select class="form-control w-100 @error('dataTarifs.categorie_id') is-invalid @enderror"
                  id="codeCategorie" wire:model='dataTarifs.categorie_id'>
                  @foreach ($categories as $categorie)
                  <option value="{{ $categorie['id'] }}" {{ $editTarifId->categories->pluck('id')->contains($categorie['id']) ? 'selected' : '' }}>{{ $categorie['libelle'] }}</option>
                  @endforeach
                </select>
                @else
                <select class="form-control w-100 @error('dataTarifs.level_id') is-invalid @enderror" multiple
                  id="codeLevel" wire:model='dataTarifs.level_id'>
                  @foreach ($levels as $level)
                  <option value="{{ $level['id'] }}" {{ $editTarifId->levels->pluck('id')->contains($level['id']) ? 'selected' : '' }}>{{ $level['libelle'] }}</option>
                  @endforeach
                </select>
                @endif

                @endif

                {{-- section pour examen --}}
                @if ($titleModal == 'edit examens')
                <select class="form-control w-100 mx-2 @error('dataTarifs.level_id') is-invalid @enderror"
                  id="codeExamen" wire:model='dataExamens.level_id'>
                  @foreach ($levels as $level)
                  <option value="{{ $level['id'] }}" {{ $editTarifId->levels->pluck('id')->contains($level['id']) ? 'selected' : '' }}>{{ $level['libelle'] }}</option>
                  @endforeach
                </select>
                <select class="form-control w-100 mx-2 @error('dataTarifs.session_id') is-invalid @enderror"
                  id="codeExamen" wire:model='dataExamens.session_id'>
                  <option> --- Sessions --- </option>
                  @foreach ($sessions as $session)
                  <option value="{{ $session['id'] }}" {{ $editTarifId->sessions->pluck('id')->contains($session['id']) ? 'selected' : '' }}>{{ $session['nom'] }}</option>
                  @endforeach
                </select>
                <select class="form-control w-100 mx-2 @error('dataTarifs.price_id') is-invalid @enderror"
                  id="codeExamen" wire:model='dataExamens.price_id'>
                  @foreach ($prices as $price)
                  <option value="{{ $price['id'] }}" {{ $editTarifId->prices->pluck('id')->contains($price['id']) ? 'selected' : '' }}>{{ $price['nom'] }} - {{ $price->levels->implode("libelle", " |
                    ")}}</option>
                  @endforeach
                </select>
                @endif    
                
                {{-- section pour salles --}}
                @if ($titleModal == 'edit salles')
                <input class="form-control mx-2 @error('editDescSalle') is-invalid @enderror" type="text"
                  placeholder="Description" type="text" wire:model='editDescSalle'>
                @endif

              </div>
              <button class="btn btn-success ml-3" wire:click='{{$submitFunction}}'>
                <i class="fa fa-spinner fa-spin" wire:loading wire:target='{{$submitFunction}}'></i>
                Modifier
              </button>
            </div>


          </div>
        </div>
      </div>
    </div>

  </div>