<aside class="main-sidebar elevation-4 bg-white" style="height: 100%;">

    <div class="logo text-center " style="height: 15vh;">
        <div class="log-lg"
            style="background: url({{ asset('images/logo/alliance-francaise-d-antsiranana-logo.png') }}) center center /cover; height:100%; width:100%;">

        </div>
        {{-- <img src="{{ asset('images/logo/alliance-francaise-d-antsiranana-logo.png')}}" alt="AF_logo" class="w-75 logo-lg"> --}}
    </div>

    {{-- <div class="logo logo-sm text-center " style="height: 15%;">
        <img src="{{ asset('images/logo/alliance-francaise-d-antsiranana-logo.png')}}" alt="AF_logo" class="w-75">
    </div> --}}


    <div class="sidebar sidebar-menu">

        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
              <img src="images/profil/Avatar BC.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
              <a href="#" class="d-block">Admin AF</a>
          </div>
      </div> --}}

        {{-- <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
              <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                  aria-label="Search">
              <div class="input-group-append">
                  <button class="btn btn-sidebar">
                      <i class="fas fa-search fa-fw"></i>
                  </button>
              </div>
          </div>
      </div> --}}

        {{-- Mes menu --}}
        @livewire('asideMenu')

    </div>

</aside>
