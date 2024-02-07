<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Reçu de Paiement</title>
</head>

<body>
  <div class="container">
    <div class="header">
      <div class="logo w-75 text-center">
        <img src="../../public/images/logo/alliance-francaise-d-antsiranana-logo.png" alt="logo AF" width="250px">
      </div>
      <div class="title-container w-100 row" >
        <div class="col-md-6 bg-red" ></div>
        <h2 class="mx-2 col-md-3" >Reçu de Paiement</h2>
        <div class="col-md-2 bg-red" ></div>
      </div>
    </div>
    <section class="mt-5 container">
      <div class="row">
        <div class="col-md-6">
          {{-- table --}}
          <h3>Facturé à :</h3>
          <table class="table table-sm table-striped table-borderless">
            <tbody>
              <tr>
                <th scope="row">Nom :</th>
                <td>{{ $etudiant['nom'] }}</td>
              </tr>
              <tr>
                <th scope="row">Prenom :</th>
                <td>{{ $etudiant['prenom'] }}</td>
              </tr>
              <tr>
                <th scope="row">Date :</th>
                <td>{{ $etudiant['dateNaissance'] }}</td>
              </tr>
              <tr>
                <th scope="row">Email :</th>
                <td>{{ $etudiant['email'] }}</td>
              </tr>
              <tr>
                <th scope="row">Téléphones :</th>
                <td>{{ $etudiant['telephone1'] }} - {{ $etudiant['telephone2'] }}</td>
              </tr>
              <tr>
                <th scope="row">Adresse :</th>
                <td>{{ $etudiant['adresse'] }}</td>
              </tr>
              <tr>
                <th scope="row">Méthode de paiement :</th>
                <td>Larry the Bird</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-6">
          {{-- table --}}
          <h3>Payé à :</h3>
          <table class="table table-sm table-striped table-borderless">
            <tbody>
              <tr>
                <th scope="row">Nom :</th>
                <td>{{ $auth->nom}}</td>
              </tr>
              <tr>
                <th scope="row">Prenom :</th>
                <td>{{ $auth->prenom}}</td>
              </tr>
              <tr>
                <th scope="row">Téléphone :</th>
                <td>{{ $auth->telephone1}}</td>
              </tr>
              <tr>
                <th scope="row">Email :</th>
                <td>{{ $auth->email}}</td>
              </tr>
              <tr>
                <th scope="row">Adresse :</th>
                <td> {{ $auth->adresse}} </td>
              </tr>
              <tr>
                <th scope="row">Role chez Alliance :</th>
                <td> {{ $auth->roles->implode('name', ' | ')}} </td>
              </tr>
            </tbody>
          </table>
        </div>
        
      </div>
    </section>
    <hr class="w-50 text-center">
    <section class="w-100 row">
      <div class="col-md-5"></div>
      <div class="col-md-7">
        <h3>Détails de la facture :</h3>
        <div class="card">
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Motifs</th>
                  <th scope="col">Montant</th>
                  <th scope="col" class="text-center">Total</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>{{ $paiements->motif }}</td>
                  <td> {{ $paiements->montant }} </td>
                  <td class="text-center text-bold">{{ $paiements->montant }} Ar</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th scope="text-lg">Total</th>
                  <td colspan="3" class="text-right text-bold text-lg">{{ $paiements->montant }} Ar</td>
                </tr>
              </tfoot>
            </table>
        </div>
      </div>
      
    </section>
  </div>

</body>

</html>