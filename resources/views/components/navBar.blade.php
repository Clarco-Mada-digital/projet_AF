<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <div class="d-flex align-items-center">
        <div class="">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </div>
        <div class="">
            <ul class="breadcrumb bg-transparent mt-3">
                <h4 style="font-size: 1.2rem;">@yield('titlePage')</h4>
                {{-- <li class="breadcrumb-item"><a href="#">Accueil ></a></li> --}}
                {{-- <li class="breadcrumb-item active">Acceuil</li> --}}
            </ul>
        </div>
    </div>

    <ul class="navbar-nav ml-auto d-flex align-items-center">

        {{-- <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
              <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
              <form class="form-inline">
                  <div class="input-group input-group-sm">
                      <input class="form-control form-control-navbar" type="search" placeholder="Search"
                          aria-label="Search">
                      <div class="input-group-append">
                          <button class="btn btn-navbar" type="submit">
                              <i class="fas fa-search"></i>
                          </button>
                          <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                              <i class="fas fa-times"></i>
                          </button>
                      </div>
                  </div>
              </form>
          </div>
      </li> --}}

        {{-- <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-comments"></i>
              <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <a href="#" class="dropdown-item">

                  <div class="media">
                      <img src="dist/img/user1-128x128.jpg" alt="User Avatar"
                          class="img-size-50 mr-3 img-circle">
                      <div class="media-body">
                          <h3 class="dropdown-item-title">
                              Brad Diesel
                              <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                          </h3>
                          <p class="text-sm">Call me whenever you can...</p>
                          <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                      </div>
                  </div>

              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">

                  <div class="media">
                      <img src="dist/img/user8-128x128.jpg" alt="User Avatar"
                          class="img-size-50 img-circle mr-3">
                      <div class="media-body">
                          <h3 class="dropdown-item-title">
                              John Pierce
                              <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                          </h3>
                          <p class="text-sm">I got your message bro</p>
                          <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                      </div>
                  </div>

              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">

                  <div class="media">
                      <img src="dist/img/user3-128x128.jpg" alt="User Avatar"
                          class="img-size-50 img-circle mr-3">
                      <div class="media-body">
                          <h3 class="dropdown-item-title">
                              Nora Silvester
                              <span class="float-right text-sm text-warning"><i
                                      class="fas fa-star"></i></span>
                          </h3>
                          <p class="text-sm">The subject goes here</p>
                          <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                      </div>
                  </div>

              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
      </li> --}}
        {{-- <li class="nav-item user-panel  d-flex">
          <div class="image">
              <img src="images/profil/Avatar BC.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
              <a href="#" class="d-block">Admin AF</a>
          </div>
      </li> --}}

        <!-- Authentication Links -->
        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif

            {{-- @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif --}}
        @else
            <li class="nav-item dropdown ">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a id="navbarDropdown" class="nav-link d-flex text-truncate" href="#" role="button" data-widget="control-sidebar"
                    data-slide="true" aria-expanded="false" v-pre>
                    <img src="{{ Auth::user()->profil ? asset('storage/'.Auth::user()->profil) : 'https://eu.ui-avatars.com/api/?name=' . Auth::user()->nom . '&background=random' }}"
                        class="img-rounded elevation-2 mr-2" alt="User Image">
                    {{ Auth::user()->nom }} {{ Auth::user()->prenom }}
                </a>

                {{-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" data-widget="control-sidebar" data-slide="true" href="#"
                      role="button">
                      <i class="fa fa-user"></i>
                      Profil
                  </a>
                  <hr />
                  <a class="dropdown-item" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                      <i class="fa fa-power-out" aria-hidden="true"></i>
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
              </div> --}}
            </li>
        @endguest
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
              role="button">
              <i class="fas fa-th-large"></i>
          </a>
      </li> --}}
    </ul>
</nav>
