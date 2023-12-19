<div class="card card-primary shadow-lg mb-0" style="transition: all 0.15s ease 0s; height: 100%; width: 100%;">
  <div class="card-header">
      <h3 class="card-title"><i class="fa fa-edit fa-2x mr-2"></i> Modifier profil etudiant de professeur</h3>
      <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
              <i class="fas fa-expand"></i>
          </button>
          <button type="button" class="btn btn-warning" data-toggle="modal" spellcheck="false" data-dismiss="modal" wire:click='updateProfesseur'>
              <i class="fa fa-save"></i> <i class="fa fa-spinner fa-spin" wire:loading wire:target='updateProfesseur'></i> Enregistrer la modification</button>
          <button type="button" class="btn btn-danger" wire:click="toogleSectionName('list')">
              <i class="fa fa-chevron-left mr-2"> Retour</i>
          </button>
      </div>

  </div>

  <div class="card-body row">
      <div class="col-md-12 card card-primary card-outline mx-auto">
          <div class="card-body box-profile">
              <div class="row">
                  <div class="col-12 d-flex flex-md-column align-items-center">
                      @if ($editProfesseur != [])
                          <label class="d-flex flex-column justify-content-center w-25 mx-auto">
                              @if ($photo)
                                  <img class="profile-user-img img-fluid img-circle"
                                      src="{{ $photo->temporaryUrl() }}">
                                      <button class="btn btn-warning btn-sm mt-2" wire:click="set('photo', '')">Reset</button>
                              @else
                                  <img class="profile-user-img img-fluid img-circle"
                                      src="{{ $editProfesseur['profil'] ? asset('storage/' . $editProfesseur['profil']) : 'https://eu.ui-avatars.com/api/?name=' . $editProfesseur['nom'] . '&background=random' }}"
                                      alt="Professeur profile picture">
                              @endif
                              <input type="file" wire:model='photo' style="display: none;">
                          </label>
                      @else
                          <img class="profile-user-img img-fluid img-circle" src=""
                              alt="Professeur profile picture">
                      @endif
                      <i class="fa fa-spinner fa-spin text-center fa-2x" wire:loading wire:target='photo'
                          style="position: absolute; top:20%; left:48%; color:#FFC107;"></i>
                      
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <label for="etudiantNom">Nom</label>
                          <input type="text" class="form-control @error('editEtudiant.nom') is-invalid @enderror"
                              id="etudiantNom" wire:model='editProfesseur.nom'>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <label for="etudiantPrenom">Prénom</label>
                          <input type="text"
                              class="form-control @error('editEtudiant.prenom') is-invalid @enderror"
                              id="etudiantPrenom" wire:model='editProfesseur.prenom'>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <label for="etudiantPrenom">Sexe</label>
                          <select class="custom-select @error('editEtudiant.sexe') is-invalid @enderror"
                              spellcheck="false" id="etudiantPrenom" wire:model='editProfesseur.sexe'>
                              <option value=""> --- --- </option>
                              <option value="M">Homme</option>
                              <option value="F">Femme</option>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <label for="etudiantProfession">Nationalité</label>
                          <input type="text" class="form-control" id="etudiantNationalite"
                              wire:model='editProfesseur.nationalite'>
                      </div>
                  </div>
                  <div class="col-md-8">
                      <div class="form-group">
                          <label for="etudiantAddr">Adresse</label>
                          <input type="text"
                              class="form-control @error('editProfesseur.adresse') is-invalid @enderror"
                              id="etudiantAddr" wire:model='editProfesseur.adresse'>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="etudiantEmail">Email</label>
                          <input type="text"
                              class="form-control @error('editProfesseur.email') is-invalid @enderror"
                              id="etudiantEmail" wire:model='editProfesseur.email'>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="etudiantPhone">Téléphone</label>
                          <input type="text"
                              class="form-control @error('editProfesseur.telephone1') is-invalid @enderror"
                              id="etudiantPhone" wire:model='editProfesseur.telephone1'>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="etudiantPhone">Seconde téléphone</label>
                          <input type="text" class="form-control" id="etudiantPhone"
                              wire:model='editProfesseur.telephone2'>
                      </div>
                  </div>
              </div>

          </div>

      </div>
      {{-- <div class="col-md-6 card card-primary card-outline row">

          <div class=" card-body col-md-12 ">
              <div class="row">
                  <div class="col-md-12">
                      <h4>List des cours</h4>
                      <div class="row mt-4">
                          @foreach ($editCoursList['cours'] as $cour)
                              <div class="form-group col-md-4">
                                  <div class="custom-control custom-checkbox">
                                      <input class="custom-control-input" type="checkbox"
                                          id="cour{{ $cour['cour_id'] }}"
                                          @if ($cour['active']) checked @endif
                                          wire:model.lazy="nscList.cours.{{ $loop->index }}.active">
                                      <label for="cour{{ $cour['cour_id'] }}"
                                          class="custom-control-label">{{ $cour['cour_libelle'] }}</label>
                                  </div>
                              </div>
                          @endforeach
                      </div>
                  </div>
              </div>
          </div>
      </div> --}}
  </div>
</div>
