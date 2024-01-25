<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('components.header')

<body class="hold-transition sidebar-mini">

    <div class="wrapper">

        {{-- Partie nav bar --}}
        @include('components.navBar')

        {{-- Partie Menu --}}
        @include('components.asideMenu')

        <div class="content-wrapper">

            <!-- Right Side Of menu Navbar -->
            {{-- <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Accueil</h1>
                        </div>

                    </div>
                </div>
            </div> --}}

            <div class="content">
                <div class="container-fluid">

                    {{-- No contenu de la page home --}}
                    @yield('content')
                    
                    @isset($slot)
                        {{ $slot }}
                    @endisset
                </div>
            </div>

        </div>

        {{-- La section a droite d’écran en slideBar --}}
        @guest
        ""
        @else
        @livewire('AsideProfil')

        {{-- Partie Modal view --}}
        <div class="modal fade" id="viewProfil" style="display: none; " aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content bg-transparent"
                    style="background: url('{{ asset('images/logo/alliance-francaise-d-antsiranana-logo.png') }}') center center /cover;">
                    <div class="modal-body p-0">
                        @include('livewire.profils.view')
                    </div>
                </div>
            </div>
        </div>
        @livewire('EditProfil')

        @endguest



        {{-- Partie footer --}}
        <footer class="main-footer">

            <strong>Copyright &copy; 2023-2024 Alliance Française Antsiranana.</strong> All rights
            reserved.
            <div class="float-right d-none d-sm-inline text-danger">
                Désigné et développé avec ❤️ par <a href="https://mada-digital.net"
                    style="color: inherit;font-weight: bold;">MADA-Digital</a>
            </div>
        </footer>
    </div>


    @vite(['resources/js/app.js'])
</body>

</html>