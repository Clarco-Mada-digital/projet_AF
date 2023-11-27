@section('title', 'etudiant')

<div>

    <div @if ($state != 'view') style="display: none;" @endif>
        <h3 class="mb-5 pt-3">Listes étudiants</h3>
        <div class="row m-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-gradient-primary">
                        <h3 class="card-title d-flex align-items-center"> <i class="fa fa-users fa-2x mr-2"></i> Liste des
                            étudiants</h3>
                        <div class="card-tools d-flex align-items-center">
                            <a href="{{ route('etudiants-nouveau') }}" class="btn btn-link text-light mr-4" >
                                <i class="fa fa-user-plus"></i> Nouvel étudiant</a>
                            <div class="input-group input-group-md" style="width: 250px;">
                                <input type="search" name="table_search" class="form-control float-right"
                                    placeholder="Search" wire:model.live.debounce.500ms="search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0 table-striped" >
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 5%"></th>
                                    <th class="text-center" style="width: 10%">N° Carte</th>
                                    <th style="width: 20%" wire:click="setOrderField('nom')">Nom</th>
                                    <th style="width: 20%" wire:click="setOrderField('prenom')">Prénom</th>
                                    <th class="text-center" style="width: 20%">Téléphone</th>
                                    <th class="text-center" style="width: 20%">Cour choisi</th>
                                    <th class="text-center" style="width: 5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($etudiants as $etudiant)
                                    <tr>
                                        <td>
                                            @if ($etudiant->profil != '')
                                                <img class="img-circle" src="{{ asset('storage/' . $etudiant->profil) }}" width='50'
                                                    alt="profil etudiant">
                                            @else
                                                <img class="img-circle" src="{{ 'https://eu.ui-avatars.com/api/?name=' . $etudiant->nom . '&background=random' }}"
                                                    width='50' alt="profil etudiant">
                                            @endif

                                        </td>
                                        <td class="text-center">{{ $etudiant->numCarte }}</td>
                                        <td>{{ $etudiant->nom }}</td>
                                        <td>{{ $etudiant->prenom }}</td>
                                        <td class="text-center">{{ $etudiant->telephone1 }}</td>
                                        <td> {{ $etudiant->cours->implode('nom', ' | ') }} </td>
                                        <td class="text-center">
                                            <button class="btn btn-link" data-toggle="modal"
                                                data-target="#view-etudiant{{ $etudiant->id }}" spellcheck="false"> <i
                                                    class="fa fa-eye"></i></button>
                                            <button class="btn btn-link"
                                                wire:click='initDataEtudiant({{ $etudiant->id }})' spellcheck="false">
                                                <i class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>

                                    {{-- Partie Modal view --}}
                                    <div class="modal fade" id="view-etudiant{{ $etudiant->id }}"
                                        style="display: none; " aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-0 " style="height: 60vh; width: 75vw;">
                                                    @include('livewire.etudiants.view')

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfixr">
                        <div class="float-right">
                            {{ $etudiants->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div @if ($state != 'edit') style="display: none;" @endif>
        <h3 class="mb-5 pt-3">Modifier étudiant</h3>
        <div class="row m-4 p-0">
            @include('livewire.etudiants.edit')
        </div>
        {{-- <div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; height: 100%; width: 100%;">
            <div class="card-header">
                <h3 class="card-title">Modification du profil étudiant</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-body p-0">
                            <div class="bs-stepper">
                                <div class="bs-stepper-header" role="tablist">
                                    <div class="step" data-target="#info-part">
                                        <button type="button" class="step-trigger" role="tab"
                                            aria-controls="info-part" id="logins-part-trigger">
                                            <span class="bs-stepper-circle">1</span>
                                            <span class="bs-stepper-label">Information étudiant</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#cour-part">
                                        <button type="button" class="step-trigger" role="tab"
                                            aria-controls="cour-part" id="information-part-trigger">
                                            <span class="bs-stepper-circle bg-gradient-info">2</span>
                                            <span class="bs-stepper-label text-info">Choix des cours</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="bs-stepper-content">
                                    <form action="#">
                                        <div id="info-part" class="content" role="tabpanel"
                                            aria-labelledby="logins-part-trigger">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group w-50">
                                                        <label for="exampleInputFile">Image profil</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="etudiantProfil">
                                                                <label class="custom-file-label"
                                                                    for="etudiantProfil">Choisir un
                                                                    image</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">Upload</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="etudiantNom">Nom</label>
                                                        <input type="text" class="form-control" id="etudiantNom"
                                                            wire:model='editEtudiant.nom'>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="etudiantPrenom">Prénom</label>
                                                        <input type="text" class="form-control"
                                                            id="etudiantPrenom" wire:model='editEtudiant.prenom'>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="etudiantPrenom">Sexe</label>
                                                        <select class="custom-select" spellcheck="false"
                                                            id="etudiantPrenom" wire:model='editEtudiant.sexe'>
                                                            <option> --- --- </option>
                                                            <option>Homme</option>
                                                            <option>Femme</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="etudiantBirth">Date de naissance</label>
                                                        <input type="text" class="form-control"
                                                            id="etudiantBirth">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="etudiantAddr">Adresse</label>
                                                        <input type="text" class="form-control" id="etudiantAddr"
                                                            wire:model='editEtudiant.adresse'>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="etudiantProfession">Profession</label>
                                                        <input type="text" class="form-control"
                                                            id="etudiantProfession"
                                                            wire:model='editEtudiant.profession'">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="etudiantEmail">Email</label>
                                                        <input type="text" class="form-control" id="etudiantEmail"
                                                            wire:model='editEtudiant.email'>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="etudiantPhone">Téléphone</label>
                                                        <input type="text" class="form-control" id="etudiantPhone"
                                                            wire:model='editEtudiant.telephone1'>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="etudiantPhone">Seconde téléphone</label>
                                                        <input type="text" class="form-control" id="etudiantPhone"
                                                            wire:model='editEtudiant.telephone2'>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" onclick="stepper.next()">Suivant</button>
                                        </div>
                                        <div id="cour-part" class="content" role="tabpanel"
                                            aria-labelledby="information-part-trigger">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Sessions">Session</label>
                                                        <select class="custom-select" spellcheck="false"
                                                            id="Sessions">
                                                            <option>Session 002 23</option>
                                                            <option>Session 001 24</option>
                                                            <option>Session 002 24</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="etudiantNiveau">Niveaux</label>
                                                        <select class="custom-select" spellcheck="false"
                                                            id="etudiantNiveau">
                                                            <option> --- --- </option>
                                                            <option>Niveau Debutante</option>
                                                            <option>Niveau Intermediaire</option>
                                                            <option>Niveau avancée</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 card card-info">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Liste des cours</h3>
                                                    </div>
                                                    <div class="card-body row">
                                                        <div class="form-group col-md-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox"
                                                                    id="courMalagasy">
                                                                <label for="courMalagasy"
                                                                    class="custom-control-label">Cour
                                                                    Malagasy</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox"
                                                                    id="courFrancais">
                                                                <label for="courFrancais"
                                                                    class="custom-control-label">Cour
                                                                    Français</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary"
                                                onclick="stepper.previous()">Précedent</button>
                                            <button class="btn btn-primary" onclick="stepper.next()">Modifier</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>

    {{-- <div @if ($state != 'new') style="display: none;" @endif>
        @include('livewire.etudiants.new')
    </div> --}}

</div>




{{-- Script for page edit --}}
{{-- <script>
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })
</script> --}}
