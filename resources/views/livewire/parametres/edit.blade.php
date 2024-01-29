<div class="card card-primary shadow-lg m-0 p-0"
  style="transition: all 0.15s ease 0s; background:rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">

  <div class="card-body p-0 m-0">
    <div class="d-flex justify-content-center flex-column mr-1">
      <div class="card card-primary card-outline bg-transparent">
        <div class="card-body box-profile">
          <div class="text-center">
            <h2 class="text-white mb-3"> {{ $titleModal }} </h2>
            <div class="d-flex justify-content-center">
              <div class="w-100">
                <input class="form-control @error('newLevel') border-danger @enderror" type="text" wire:model='{{$champ}}' wire:keydown.enter="{{$submitFunction}}">
                @error('editLevel') <span class="text-danger fs-3"> {{ $message }} </span> @enderror
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