<aside class="control-sidebar control-sidebar-dark">

    <div class="pt-5">

        <div class="card card-widget widget-user-2">

            <div class="widget-user-header bg-info">
                <div class="widget-user-image">
                    <img class="img-rounded elevation-2 mt-2"
                        src="{{ Auth::user()->profil ? Auth::user()->profil : asset('images/profil/Avatar BC.png') }}"
                        alt="User Avatar">
                </div>

                <h3 class="widget-user-username fs-3">{{ userFullName() }}</h3>
                <h5 class="widget-user-desc fs-4">{{ Auth::user()->role->nom }}</h5>

            </div>
            <div class="card-body p-0 bg-secondary">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Voir profil <span class="float-right badge bg-info"> <i class="fa fa-eye"></i> </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Mettre à jour mon profil <span class="float-right badge bg-primary"> <i
                                    class="fa fa-edit"></i> </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}<span class="float-right badge bg-danger"> <ion-icon
                                    name="log-out-outline"></ion-icon> </span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</aside>
