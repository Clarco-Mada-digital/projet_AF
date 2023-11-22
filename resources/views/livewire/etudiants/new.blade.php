
<div class="row mx-4">
    <div class="col-md-12 d-flex align-items-center justify-content-between my-3">
        <h3>Nouveaux étudiants: </h3>
        <form action="">
            <div class="input-group input-group-lg">
                <input type="search" class="form-control form-control-lg" placeholder="Chercher l'information du membre"
                    value="" spellcheck="false" style="width:400px;">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-lg btn-info">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
  <div class="col-md-12">
      <div class="card card-default m-0">
          <div class="card-header bg-gradient-primary w-100 d-flex align-items-center">
              <h3 class="card-title flex-grow-1"><i class="fa fa-pen fa-2x mr-2"></i> Formulaire d'inscription</h3>
              <button type="button" class="btn btn-tool" data-card-widget="maximize" spellcheck="false">
                <i class="fas fa-expand"></i>
            </button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fa fa-times"></i>
            </button>
          </div>
          <div class="card-body p-0">
              <div class="bs-stepper" id="bs-stepper">
                  <div class="bs-stepper-header" role="tablist">

                      <div class="step" data-target="#info-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="info-part"
                              id="logins-part-trigger">
                              <span class="bs-stepper-circle">1</span>
                              <span class="bs-stepper-label">Information étudiant</span>
                          </button>
                      </div>
                      <div class="line"></div>
                      <div class="step" data-target="#cour-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="cour-part"
                              id="information-part-trigger">
                              <span class="bs-stepper-circle bg-gradient-info">2</span>
                              <span class="bs-stepper-label text-info">Choix des cours</span>
                          </button>
                      </div>
                      <div class="line"></div>
                      <div class="step" data-target="#paiement-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="paiement-part"
                              id="information-part-trigger">
                              <span class="bs-stepper-circle bg-gradient-warning">3</span>
                              <span class="bs-stepper-label text-warning">Paiement</span>
                          </button>
                      </div>
                      <div class="line"></div>
                      <div class="step" data-target="#facture-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="facture-part"
                              id="information-part-trigger">
                              <span class="bs-stepper-circle bg-gradient-success">4</span>
                              <span class="bs-stepper-label text-success">Facture</span>
                          </button>
                      </div>
                  </div>
                  <div class="bs-stepper-content">
                      <form action="#">
                          <div id="info-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group w-50">
                                          <label for="exampleInputFile">Image profil</label>
                                          <div class="input-group">
                                              <div class="custom-file">
                                                  <input type="file" class="custom-file-input" id="etudiantProfil">
                                                  <label class="custom-file-label" for="etudiantProfil">Choisir un
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
                                          <input type="text" class="form-control" id="etudiantNom">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="etudiantPrenom">Prénom</label>
                                          <input type="text" class="form-control" id="etudiantPrenom">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="etudiantPrenom">Sexe</label>
                                          <select class="custom-select" spellcheck="false" id="etudiantPrenom">
                                              <option> --- --- </option>
                                              <option>Homme</option>
                                              <option>Femme</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="etudiantBirth">Date de naissance</label>
                                          <input type="text" class="form-control" id="etudiantBirth">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="etudiantAddr">Adresse</label>
                                          <input type="text" class="form-control" id="etudiantAddr">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="etudiantProfession">Profession</label>
                                          <input type="text" class="form-control" id="etudiantProfession">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="etudiantEmail">Email</label>
                                          <input type="text" class="form-control" id="etudiantEmail">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="etudiantPhone">Téléphone</label>
                                          <input type="text" class="form-control" id="etudiantPhone">
                                      </div>
                                  </div>
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <div class="custom-control custom-checkbox">
                                              <input class="custom-control-input custom-control-input-danger"
                                                  type="checkbox" id="newMembre" required>
                                              <label for="newMembre" class="custom-control-label">Confirmer que
                                                  c'est un nouveaux membre</label>
                                          </div>
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
                                          <select class="custom-select" spellcheck="false" id="Sessions">
                                              <option>Session 002 23</option>
                                              <option>Session 001 24</option>
                                              <option>Session 002 24</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="etudiantNiveau">Niveaux</label>
                                          <select class="custom-select" spellcheck="false" id="etudiantNiveau">
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
                                                  <label for="courMalagasy" class="custom-control-label">Cour
                                                      Malagasy</label>
                                              </div>
                                          </div>
                                          <div class="form-group col-md-3">
                                              <div class="custom-control custom-checkbox">
                                                  <input class="custom-control-input" type="checkbox"
                                                      id="courFrancais">
                                                  <label for="courFrancais" class="custom-control-label">Cour
                                                      Français</label>
                                              </div>
                                          </div>

                                      </div>
                                  </div>
                              </div>
                              <button class="btn btn-primary" onclick="stepper.previous()">Précedent</button>
                              <button class="btn btn-primary" onclick="stepper.next()">Suivant</button>
                          </div>
                          <div id="paiement-part" class="content" role="tabpanel"
                              aria-labelledby="information-part-trigger">
                              <div class="row">
                                  <div class="info-box col-md-3 mb-3 bg-warning">
                                      <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                                      <div class="info-box-content">
                                          <span class="info-box-text">Montant total</span>
                                          <span class="info-box-number" style="font-size: 1.5rem;">20.000Ar</span>
                                      </div>

                                  </div>
                                  <div class="col-md-12 card card-warning">
                                      <div class="card-header">
                                          <h3 class="card-title">Paiement par</h3>
                                      </div>
                                      <div class="card-body row">
                                          <div class="custom-control custom-radio col-md-3">
                                              <input class="custom-control-input" type="radio" id="espece"
                                                  name="paiementPar">
                                              <label for="espece" class="custom-control-label">Espèce</label>
                                          </div>
                                          <div class="custom-control custom-radio col-md-3">
                                              <input class="custom-control-input" type="radio" id="cheque"
                                                  name="paiementPar">
                                              <label for="cheque" class="custom-control-label"> Chèque</label>
                                          </div>
                                          <div class="custom-control custom-radio col-md-3">
                                              <input class="custom-control-input" type="radio" id="carte"
                                                  name="paiementPar">
                                              <label for="carte" class="custom-control-label">Carte
                                                  banquaire</label>
                                          </div>

                                      </div>
                                  </div>
                                  <div class="col-md-12 card card-warning">
                                      <div class="card-header">
                                          <h3 class="card-title">Statue de paiement</h3>
                                      </div>
                                      <div class="card-body row">
                                          <div class="custom-control custom-radio col-md-3">
                                              <input class="custom-control-input" type="radio" id="totale"
                                                  name="statuePaiement">
                                              <label for="totale" class="custom-control-label">Totalement
                                                  payé</label>
                                          </div>
                                          <div class="custom-control custom-radio col-md-3">
                                              <input class="custom-control-input" type="radio" id="moitier"
                                                  name="statuePaiement">
                                              <label for="moitier" class="custom-control-label"> A moitier
                                                  paiyé</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <button class="btn btn-primary" onclick="stepper.previous()">Précedent</button>
                              <button class="btn btn-primary" onclick="stepper.next()">Suivant</button>
                          </div>
                          <div id="facture-part" class="content" role="tabpanel"
                              aria-labelledby="information-part-trigger">
                              <div class="col-md-12 card card-success">
                                  <div class="card-header">
                                      <h3 class="card-title">Facturation</h3>
                                  </div>
                                  <div class="card-body row">
                                      <div class="col-md-6">
                                          <button class="btn btn-success">Generer un facture</button>
                                      </div>
                                      <div class="col-md-6">
                                          <button class="btn btn-success">Envoyé la facture par email</button>
                                      </div>
                                  </div>
                              </div>
                              <button class="btn btn-primary" onclick="stepper.previous()">Précedent</button>
                              <button type="submit" class="btn btn-primary">Envoyer</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
