import './bootstrap';

// Mes import
import "admin-lte/plugins/jquery/jquery";
import "admin-lte/plugins/bootstrap/js/bootstrap.bundle";
import "admin-lte/dist/js/adminlte";

// import ionicons
import "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js";
import "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js";

// import Calendar
import "https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.js";

// bs-steeper js
import "https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js";

// Nos SweetAlert
import Swal from 'sweetalert2/dist/sweetalert2.js'
import swal from 'sweetalert';
window.Swal = Swal

window.addEventListener('ShowSuccessMsg', (e) => {
  console.log(e)
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
  swal({
    title: "Attention !",
    text: e.detail[0]['message'] || 'Attention au Opération effectué !',
    icon: e.detail[0]['type'],
    buttons: true,
    // dangerMode: true,
  });
})

window.addEventListener('AlerDeletetConfirmModal', (e) => {
  swal({
    title: "êtes-vous sûr?",
    text:  e.detail[0]['message'] || 'Attention au opération effectué',
    icon:  e.detail[0]['type'],
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      Livewire.dispatch('deleteConfirmed');
      
    } else {
      swal("OK ! Opération annuler");
    }
  });
})


// checker preety bootstrap
// import "https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"


