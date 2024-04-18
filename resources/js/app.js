import './bootstrap';

// Mes import
// import "admin-lte/plugins/jquery/jquery";
import "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js";
import "./jquery-barcode.min.js";

import "admin-lte/plugins/bootstrap/js/bootstrap.bundle";
import "admin-lte/dist/js/adminlte";
import "admin-lte/plugins/chart.js/Chart.min.js";
// import "admin-lte/plugins/moment/moment.min.js";

// bs-steeper js
// import "https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js";

// Nos SweetAlert
import Swal from 'sweetalert2/dist/sweetalert2.js'
import swal from 'sweetalert';
// window.Swal = Swal

// Importez la bibliothèque dans votre fichier JavaScript :  
// import Html5Qrcode from 'html5-qrcode';



window.addEventListener('ShowSuccessMsg', (e) => {
  Swal.fire({
    position: 'top-end',
    icon: e.detail[0]['type'] || 'info',
    toast: true,
    title: e.detail[0]['message'] || 'Opération effectué avec succès!',
    showConfirmButton: false,
    timer: 3000
  })
})

window.addEventListener('showModalSimpleMsg', (e) => {
  Swal.fire({
    title: "Attention !",
    text: e.detail[0]['message'] || 'Attention au Opération effectué !',
    icon: e.detail[0]['type'],
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK !"
  });
})

window.addEventListener('AlertDeleteConfirmModal', (e) => {
  swal({
    title: "êtes-vous sûr?",
    text: e.detail[0]['message'] || 'Attention au opération effectué',
    icon: e.detail[0]['type'],
    buttons: true,
    dangerMode: true,
    confirmButtonText: "Oui"
  })
    .then((willDelete) => {
      if (willDelete) {
        Livewire.dispatch('deleteConfirmed' + e.detail[0]['thinkDelete']);
        console.log('deleteConfirmed' + e.detail[0]['thinkDelete'])
      } else {
        swal("OK ! Opération annuler");
      }
    });
})
