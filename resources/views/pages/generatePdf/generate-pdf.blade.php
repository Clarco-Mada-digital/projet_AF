<!DOCTYPE html>
<html lang="fr" id="element-to-print">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    * {
      font-family: 'Roboto', sans-serif;
      font-size: 11px;
    }
  </style>
  <title>Reçu de Paiement</title>
</head>

<body>
  <div class="container">
    <div class="header">
      <div class="logo w-75 text-center">
        <img src="../../images/logo/alliance-francaise-d-antsiranana-logo.png" alt="logo AF" width="250px">
      </div>
      <div class="title-container w-100 row">
        <div class="col-md-6 bg-red" style="background: red"></div>
        <h2 class="mx-2 col-md-3">Reçu de Paiement</h2>
        <div class="col-md-2 bg-red" style="background: red"></div>
      </div>
    </div>
    <section class="mt-5 container">
      <div class="row">
        <div class="col-md-6">
          {{-- table --}}
          <h3>Facturé à :</h3>
          <table class="table table-sm table-borderless">
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
    <hr class="w-50" style="margin: auto;">
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
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>{{ $paiements->motif }}</td>
                  <td class="text-end"> {{ $session->montant }} Ar</td>
                </tr>
                @if ($paiements->type == "Inscription a un cour")
                <tr>
                  <th scope="row">2</th>
                  <td> Adhesion au membre AF </td>
                  <td class="text-end"> {{ $price->montant }} Ar</td>
                </tr>
                @endif

              </tbody>
              <tfoot>
                <tr>
                  <th scope="text-lg">Total</th>
                  @if ($paiements->type == "Inscription a un cour")
                  <td colspan="2" class="text-end fw-bold fs-4">{{ $session->montant + $price->montant }} Ar</td>
                  @else
                  <td colspan="2" class="text-end fw-bold fs-4">{{ $session->montant }} Ar</td>
                  @endif
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

    </section>
  </div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    var element = document.getElementById('element-to-print');
    var opt = {
      hMargin:       0.3,
      filename:     'myfile.pdf',
      image:        { type: 'jpeg', quality: 0.98 },
      jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
    };
    html2pdf(element, opt);
  </script>
</body>

</html>