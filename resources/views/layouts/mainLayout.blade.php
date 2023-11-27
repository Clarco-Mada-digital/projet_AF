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

                </div>
            </div>

        </div>

        {{-- La section a droite d'ecran en slideBar --}}
        @guest
            ""
        @else
            @include('components.asideProfil')           
        @endguest



        {{-- Partie footer --}}
        <footer class="main-footer">

            <strong>Copyright &copy; 2023-2024 <a href="https://mada-digital.net">MADA-Digital</a>.</strong> All rights
            reserved.
            <div class="float-right d-none d-sm-inline text-danger">
                Alliance Française Antsiranana
            </div>
        </footer>
    </div>


</body>

</html>
