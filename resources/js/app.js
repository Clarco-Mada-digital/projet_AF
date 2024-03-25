import './bootstrap';
import './intlTelInput';

// Mes import

// import "admin-lte/plugins/jquery/jquery";
import "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js";

import "admin-lte/plugins/bootstrap/js/bootstrap.bundle";
import "admin-lte/dist/js/adminlte";
import "admin-lte/plugins/chart.js/Chart.min.js";
import "admin-lte/plugins/moment/moment.min.js";
// import "admin-lte/plugins/inputmask/jquery.inputmask.min.js";
// import "admin-lte/dist/js/demo.js";
import "https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"


// import Calendar
import "https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.js";

// bs-steeper js
import "https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js";

// Nos SweetAlert
import Swal from 'sweetalert2/dist/sweetalert2.js'
import swal from 'sweetalert';
window.Swal = Swal

// Alpine JS
// import Alpine from 'alpinejs'
 
// window.Alpine = Alpine
 
// Alpine.start()

// Input Mask
// $(".phone").inputmask("(999)-99-99-999-99");
let PhoneInputList = document.querySelectorAll('.phone');
let phoneList = [...PhoneInputList].map(PhoneInput => new intlTelInput(PhoneInput, {
  initialCountry: 'mg'
}));

// Tooltip definition
// const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
// const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

window.addEventListener('ShowSuccessMsg', (e) => {
  swal({
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



// checker pretty bootstrap
// import "https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/5.2.1/icheck-bootstrap.min.css"


