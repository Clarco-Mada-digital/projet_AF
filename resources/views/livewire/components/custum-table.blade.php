<table class="table table-head-fixed text-nowrap">
    <thead>
        <tr>
            @foreach ($headerList as $list)
                <th>{{$list}}</th>
            @endforeach
            {{-- <th style="width: 5%"></th>
            <th class="text-center" style="width: 10%">N° Carte</th>
            <th style="width: 20%" wire:click="setOrderField('nom')">Nom</th>
            <th style="width: 20%" wire:click="setOrderField('prenom')">Prénom</th>
            <th class="text-center" style="width: 20%">Téléphone</th>
            <th class="text-center" style="width: 20%">Cour choisi</th>
            <th class="text-center" style="width: 5%">Action</th> --}}
        </tr>
    </thead>
    <tbody>
        @forelse ($datas as $data)
            <tr>
                @if ($profilDataTabs) 
                    <td>
                        @if ($data['profil'] != null)
                            <img class="img-circle"
                                src="{{ asset('storage/' . $data->profil) }}" width='50'
                                alt="profil etudiant">
                        @else
                            <img class="img-circle"
                                src="{{ 'https://eu.ui-avatars.com/api/?name=' . $data->nom . '&background=random' }}"
                                width='50' alt="profil etudiant">
                        @endif

                    </td>
                    @endif
                @foreach ($dataItems as $items)
                    
                    <td @if ($items['class'] != null)
                            class="{{$items['class']}}"
                        @endif
                        @if ($items['param'] != null)
                            {{$items['param']}}
                        @endif >
                            {{ $data[$items['nom']] }}
                    </td>
                   {{-- <td>{{ $items['class'] }}</td> --}}
                    
                @endforeach
                <td class="text-center">
                    <button class="btn btn-link" data-toggle="modal"
                        data-target="#view-etudiant{{ $data->id }}" spellcheck="false"> <i
                            class="fa fa-eye" style="color: #0DCAF0;"></i></button>
                    <button class="btn btn-link"
                        wire:click='initDataEtudiant({{ $data->id }})' spellcheck="false">
                        <i class="fa fa-edit" style="color: #FFC107;"></i></button>
                </td>
                {{-- <td>
                    @if ($etudiant->profil != null)
                        <img class="img-circle"
                            src="{{ asset('storage/' . $data->profil) }}" width='50'
                            alt="profil etudiant">
                    @else
                        <img class="img-circle"
                            src="{{ 'https://eu.ui-avatars.com/api/?name=' . $data->nom . '&background=random' }}"
                            width='50' alt="profil etudiant">
                    @endif

                </td>
                <td class="text-center">{{ $data->numCarte }}</td>
                <td>{{ $data->nom }}</td>
                <td>{{ $data->prenom }}</td>
                <td class="text-center">{{ $data->telephone1 }}</td>
                <td> {{ $data->cours->implode('libelle', ' | ') }} </td>
                <td class="text-center">
                    <button class="btn btn-link" data-toggle="modal"
                        data-target="#view-etudiant{{ $data->id }}" spellcheck="false"> <i
                            class="fa fa-eye" style="color: #0DCAF0;"></i></button>
                    <button class="btn btn-link"
                        wire:click='initDataEtudiant({{ $data->id }})' spellcheck="false">
                        <i class="fa fa-edit" style="color: #FFC107;"></i></button>
                </td> --}}
            </tr>

            {{-- Partie Modal view --}}
            <div class="modal fade" id="view-etudiant{{ $data->id }}"
                style="display: none; " aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-0 ">
                            {{-- @include('livewire.etudiants.view') --}}
                           @yield('modalView')

                        </div>
                    </div>
                </div>
            </div>
        @empty
            <tr>
                <td class="text-center" colspan="7"> <img
                        src="{{ asset('images/no_data.svg') }}" alt="Data empty"
                        width="200px">
                </td>
            </tr>
        @endforelse

    </tbody>
</table>
