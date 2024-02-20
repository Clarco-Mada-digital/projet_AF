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
  <title id="titlePage">Reçu de Paiement du {{ $etudiant->nom }}</title>
</head>

<body>
  <div class="container">

    <div class="header">
      <div class="logo w-75 text-center m-0 p-0">
        <img class="m-0 p-0" src="../../images/logo/alliance-francaise-d-antsiranana-logo.png" alt="logo AF"
          width="120px">
      </div>
      <div class="title-container w-100 row">
        <div style="background: red; width: 55%;"></div>
        <h2 style="width: 35%">Reçu de Paiement</h2>
        <div style="background: red; margin-left: auto; width:10%;"></div>
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
                <th scope="row">Prénom :</th>
                <td>{{ $etudiant['prenom'] }}</td>
              </tr>
              <tr>
                <th scope="row">Date de naissance :</th>
                <td>{{ Date('d M, Y', strtotime($etudiant['dateNaissance'])) }}</td>
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
                <td> {{ $paiements['moyenPaiement'] }} </td>
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
                <th scope="row">Prénom :</th>
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
                <th scope="row">Rôle chez Alliance :</th>
                <td> {{ $auth->roles->implode('name', ' | ')}} </td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </section>
    <hr class="w-50" style="margin: auto;">
    <section class="w-100 row">
      <div class="col-md-4"></div>
      <div class="col-md-8">
        <h3>Détails de la facture :</h3>
        <div class="card">
          <div class="card-body">
            <table class="table">
              {{-- entête du tableau --}}
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Motifs</th>
                  <th scope="col">Montant</th>
                </tr>
              </thead>

              {{-- contenu du tableau --}}
              <tbody>
                @if ($paiements->type == "Inscription a un cour" || $paiements->type == "Reinscription a un cour")
                <tr>
                  <th scope="row">1</th>
                  <td>{{ $paiements->type }} @if ($cours != null) ({{ $cours->libelle }}) @endif</td>
                  <td class="text-end"> <span
                      class="@if ($session->dateFinPromo > Carbon\Carbon::now()) text-decoration-line-through @endif">{{
                      $session->montant }} Ar</span> @if ($session->dateFinPromo > Carbon\Carbon::now()) {{
                    $session->montantPromo }} @endif</td>
                </tr>
                @endif
                @if ($paiements->type == "Inscription a un examen" || $paiements->type == "Reinscription a un examen")
                <tr>
                  <th scope="row">1</th>
                  <td>{{ $paiements->type }} ({{ $examen->libelle }})</td>
                  <td class="text-end"> {{ $examen->price->montant }} Ar</td>
                </tr>
                @endif

                @if ($paiements->type == "Inscription a un cour" || $paiements->type == "Inscription a un examen")
                <tr>
                  <th scope="row">2</th>
                  <td> Adhesion au membre AF </td>
                  <td class="text-end"> {{ $price->montant }} Ar</td>
                </tr>
                @endif

              </tbody>

              {{-- pied du tableau --}}
              <tfoot>
                <tr>
                  <th class="text-lg fs-3">Total</th>
                  @if ($paiements->type == "Inscription a un cour")
                  @if ($session->dateFinPromo > Carbon\Carbon::now())
                  <td colspan="2" class="text-end fw-bold fs-4">{{ $session->montantPromo + $price->montant }} Ar <br>
                    <span class="nomberToLetter">{{ $session->montantPromo + $price->montant }}</span></td>
                  @else
                  <td colspan="2" class="text-end fw-bold fs-4">{{ $session->montant + $price->montant }} Ar <br>
                    <span class="nomberToLetter">{{ $session->montant + $price->montant }}</span></td>
                  @endif
                  @endif
                  @if ($paiements->type == "Inscription a un examen")
                  <td colspan="2" class="text-end fw-bold fs-4">{{ $examen->price->montant + $price->montant }} Ar <br>
                    <span class="nomberToLetter">{{ $examen->price->montant + $price->montant }}</span></td>
                  @endif
                  @if ($paiements->type == "Reinscription a un cour")
                  @if ($session->dateFinPromo > Carbon\Carbon::now())
                  <td colspan="2" class="text-end fw-bold fs-4">{{ $session->montantPromo }} Ar <br>
                    <span class="nomberToLetter">{{ $session->montantPromo }}</span></td>
                  @else
                  <td colspan="2" class="text-end fw-bold fs-4">{{ $session->montant }} Ar <br>
                    <span class="nomberToLetter">{{ $session->montant }}</span></td>
                  @endif
                  @endif
                  @if ($paiements->type == "Reinscription a un examen")
                  <td colspan="2" class="text-end fw-bold fs-4">{{ $examen->price->montant }} Ar <br>
                    <span class="nomberToLetter">{{ $examen->price->montant }}</span></td>
                  @endif
                </tr>
                <tr>
                  @if ($paiements->montantRestant != 0)
                  <th class="fs-5 text-success">Montant payé : {{ $paiements->montant - $paiements->montantRestant }} Ar <br><span class="nomberToLetter">{{ $paiements->montant - $paiements->montantRestant }}</span>
                  </th>
                  <td class="fs-5 text-end text-danger fw-bold" colspan="2">Montant restant : {{
                    $paiements->montantRestant }} Ar <br><span class="nomberToLetter">{{ $paiements->montantRestant }}</span></td>
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
  <script src="../../js/nombreEnLettre.js"></script>
  <script>
    var element = document.getElementById('element-to-print');
    const titlePage = document.querySelector('#titlePage');
    let nbToLetter = document.querySelectorAll('.nomberToLetter');
    nbToLetter.forEach(element => {
      chiffre = Number(element.textContent);
      element.textContent = NumberToLetter(chiffre)+" ariary";
      console.log(chiffre);
    });

    var opt = {
      hMargin:       0.3,
      filename:     titlePage.textContent + ".pdf",
      image:        { type: 'jpeg', quality: 0.98 },
      jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' },
      pagebreaks: { mode: ['css', 'legacy'], avoid: 'img' }
    };
    html2pdf(element, opt);
  </script>
</body>

</html>