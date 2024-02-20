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

                <select class="form-control w-100 @error('dataTarifs.level_id') is-invalid @enderror" multiple
                  id="tarifLevel" wire:model='dataTarifs.level_id'>
                  @foreach ($levels as $level)
                  <option value="{{ $level['id'] }}">{{ $level['libelle'] }}</option>
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
                <select class="form-control w-100 @error('dataExamens.price_id') is-invalid @enderror"
                  id="codeExamen" wire:model='dataExamens.price_id'>
                  <option> --- Tarification --- </option>
                  @foreach ($prices as $price)
                  <option value="{{ $price['id'] }}">{{ $price['nom'] }} - {{ $price->levels->implode("libelle", " |
                    ")}}</option>
                  @endforeach
                </select>
                @endif

              </div>
              <button class="btn btn-success ml-3" wire:click='{{$submitFunction}}'>
                <i class="fa fa-spinner fa-spin" wire:loading wire:target='{{$submitFunction}}'></i>
                Enregistrer
              </button>
            </div>


          </div>
        </div>
      </div>
    </div>

  </div>