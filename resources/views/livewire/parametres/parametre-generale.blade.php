@section('title', 'Paramètre Generale')

@section('titlePage', 'PARAMÈTRE GENERALE')

<div>
    <h3 class="mb-5 pt-3">Paramètres Généraux</h3>
    <div class="row mt-4 mx-2">
        
        @foreach ($allData as $key => $niveaux)            
            @include('livewire.parametres.niveaux')           
        @endforeach        

    </div>
</div>