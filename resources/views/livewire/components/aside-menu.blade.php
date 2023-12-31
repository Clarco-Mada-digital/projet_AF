<nav class="mt-2" style="font-size: .9rem;">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
                       
            <li class="nav-item">
                <a href="{{ route('home') }}" 
                    @class(['nav-link d-flex align-items-center','active' => request()->route()->getName() == 'home',])>
                    {{-- <ion-icon class="nav-icon" name="logo-windows"></ion-icon> --}}
                    <i class="nav-icon fa-fw fab fa-windows"></i>
                    <p>
                        TABLEAU DE BORD
                    </p>
                </a>

            </li>

        <li @class([
            'nav-item',
            'menu-open' => Str::contains(
                request()->route()->getName(),
                'etudiants'),
        ])>
            <a href="#" @class(['nav-link d-flex align-items-center','active-ancre' => Str::contains(request()->route()->getName(),'etudiants'),])>
                <i class="fa fa-users fa-w nav-icon" aria-hidden="true"></i>
                <p>
                    ÉTUDIANTS
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('etudiants-nouveau') }}" @class([
                        'nav-link',
                        'active' => request()->url() == route('etudiants-nouveau'),
                    ])>
                        {{-- <ion-icon class="nav-icon" name="pencil"></ion-icon> --}}
                        <i class="nav-icon fa fa-edit"></i>
                        <p>Inscription</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('etudiants-list') }}" @class([
                        'nav-link',
                        'active' => request()->url() == route('etudiants-list'),
                    ])>
                        {{-- <ion-icon class="nav-icon" name="people"></ion-icon> --}}
                        <i class="nav-icon fa fa-users"></i>
                        <p>Tous les étudiants</p>
                    </a>
                </li>
            </ul>
        </li>
        <li @class([
            'nav-item',
            'menu-open' => Str::contains(
                request()->route()->getName(),
                'cours'),
        ])>
            <a href="#" @class(['nav-link d-flex align-items-center','active-ancre' => Str::contains(request()->route()->getName(),'cours'),])>
                {{-- <ion-icon class="nav-icon" name="book"></ion-icon> --}}
                <i class="nav-icon fa-w fa fa-book"></i>
                <p>
                    COURS
                    <i class="right fas fa-angle-left"></i>
                    @if (count($cours) > 0)
                    <span class="right badge badge-danger">Nouveaux</span>                                
                    @endif
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('cours-nouveau') }}" @class([
                        'nav-link',
                        'active' => request()->url() == route('cours-nouveau'),
                    ])>
                        {{-- <ion-icon class="nav-icon" name="create"></ion-icon> --}}
                        <i class="nav-icon fa fa-edit"></i>
                        <p>Nouveau cours</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cours-list') }}" @class([
                        'nav-link',
                        'active' => request()->url() == route('cours-list'),
                    ])>
                        {{-- <ion-icon class="nav-icon" name="list-circle"></ion-icon> --}}
                        <i class="nav-icon fa fa-list"></i>
                        <p>Liste des cours</p>
                    </a>
                </li>
            </ul>
        </li>

        @cannot('manager')
            <li @class(['nav-item','menu-open' => Str::contains(request()->route()->getName(),'paiment'),])>
                <a href="{{route('paiements-paiement')}}"
                    @class(['nav-link d-flex align-items-center','active' => Str::contains(request()->route()->getName(),'paiements')])>
                    {{-- <ion-icon class="nav-icon" name="card"></ion-icon> --}}
                    <i class="nav-icon fa-fw fa fa-credit-card"></i>
                    <p>
                        PAIEMENTS
                    </p>
                </a>
            </li>
        @endcannot

        @cannot('manager')
            <li @class(['nav-item','menu-open' => Str::contains(request()->route()->getName(),'parametres'),])>
                <a href="#" @class([
                    'nav-link d-flex align-items-center',
                    'active-ancre' => Str::contains(
                        request()->route()->getName(),
                        'parametres'),
                ])>
                    {{-- <ion-icon class="nav-icon" name="settings"></ion-icon> --}}
                    <i class="nav-icon fa-fw fa fa-cogs"></i>
                    <p>
                        PARAMETRES
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('parametres-session') }}" @class([
                            'nav-link',
                            'active' => request()->url() == route('parametres-session'),
                        ])>
                            {{-- <ion-icon class="nav-icon" name="barcode-outline"></ion-icon> --}}
                            <i class="nav-icon far fa-circle"></i>
                            <p>Sessions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('parametres-user') }}" @class([
                            'nav-link',
                            'active' => request()->url() == route('parametres-user'),
                        ])>
                            {{-- <ion-icon class="nav-icon" name="people-circle-outline"></ion-icon> --}}
                            <i class="nav-icon fa fa-user-circle"></i>
                            <p>Utilisateurs</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('parametres-professeur') }}" @class([
                            'nav-link',
                            'active' => request()->url() == route('parametres-professeur'),
                        ])>
                            {{-- <ion-icon class="nav-icon" name="briefcase-outline"></ion-icon> --}}
                            <i class="nav-icon fa fa-graduation-cap"></i>
                            <p>Professeurs</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            {{-- <ion-icon class="nav-icon" name="finger-print-outline"></ion-icon> --}}
                            <i class="nav-icon fas fa-fingerprint"></i>
                            <p>Permissions</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endcannot


        @can('superAdmin')
            <li class="nav-item">
                <a href="#" class="nav-link align-items-center">
                    {{-- <ion-icon class="nav-icon" name="save"></ion-icon> --}}
                    <i class="nav-icon fa-fw fa fa-save"></i>
                    <p>
                        SAUVEGARDE
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <ion-icon class="nav-icon" name="save-outline"></ion-icon>
                            <p>Sauvegarde</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <ion-icon class="nav-icon" name="refresh-circle-outline"></ion-icon>
                            <p>Restoration</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

    </ul>
</nav>