  <header class="app-header fixed-top">
    <div class="app-header-inner">
      <div class="container-fluid py-2">
        <div class="app-header-content">
          <div class="row justify-content-between align-items-center">
            <div class="col-auto">
              <a
                id="sidepanel-toggler"
                class="sidepanel-toggler d-inline-block d-xl-none"
                href="#"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="30"
                  height="30"
                  viewBox="0 0 30 30"
                  role="img"
                >
                  <title>Menu</title>
                  <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-miterlimit="10"
                    stroke-width="2"
                    d="M4 7h22M4 15h22M4 23h22"
                  ></path>
                </svg>
              </a>
            </div>
            <!--//col-->

            <div class="app-utilities col-auto">

              <!--//app-utility-item-->

              <!--//app-utility-item-->
              <div class="app-utility-item app-user-dropdown dropdown">
                <a
                  class="dropdown-toggle"
                  id="user-dropdown-toggle"
                  data-bs-toggle="dropdown"
                  href="#"
                  role="button"
                  aria-expanded="false"
                  ><img src="{{ asset('template/assets/images/icon-profile.png') }}" alt="user profile"
                /></a>
                <ul
                  class="dropdown-menu"
                  aria-labelledby="user-dropdown-toggle"
                >
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
                </ul>
              </div>
              <!--//app-user-dropdown-->
            </div>
            <!--//app-utilities-->
          </div>
          <!--//row-->
        </div>
        <!--//app-header-content-->
      </div>
      <!--//container-fluid-->
    </div>
    <!--//app-header-inner-->
    <div id="app-sidepanel" class="app-sidepanel">
      <div id="sidepanel-drop" class="sidepanel-drop"></div>
      <div class="sidepanel-inner d-flex flex-column">
        <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none"
          >&times;</a
        >
        <div class="app-branding">
          <a class="app-logo" href=""
            ><img
              class="logo-icon me-2"
              src="{{ asset('template/assets/images/logo-masta24.png') }}"
              alt="logo"
            /><span class="logo-text">MASTAMARU 2025</span>
            </a
          >
        </div>
        <!--//app-branding-->

        <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
          <ul class="app-menu list-unstyled accordion" id="menu-accordion">
            <li class="nav-item">
              <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
              <a class="nav-link {{ request()->is('mahasiswa/dashboard') || request()->is('admin/dashboard') || request()->is('operator/dashboard') ? 'active' : '' }}" href="{{ url(auth()->user()->role === 'mahasiswa' ? 'mahasiswa/dashboard' : (auth()->user()->role === 'operator' ? 'operator/dashboard' : 'admin/dashboard')) }}">
                    <span class="nav-icon">
                  <svg
                    width="1em"
                    height="1em"
                    viewBox="0 0 16 16"
                    class="bi bi-house-door"
                    fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z"
                    />
                    <path
                      fill-rule="evenodd"
                      d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"
                    />
                  </svg>
                </span>
                    <span class="nav-link-text">Dashboard</span>
            </a
              ><!--//nav-link-->
            </li>
            @if(auth()->user()->role === 'admin')
            <li class="nav-item has-submenu {{ request()->is('admin/*') ? 'active' : '' }}">
                <a
                    class="nav-link submenu-toggle {{ request()->is('admin/operators*') || request()->is('admin/operators*') || request()->is('admin/mahasiswa*') ||request()->is('admin/users*') ? 'active' : '' }}"
                    href="#"
                    data-bs-toggle="collapse"
                    data-bs-target="#submenu-1"
                    aria-expanded="{{ request()->is('admin/*') ? 'true' : 'false' }}"
                    aria-controls="submenu-1"
                >
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                            <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                        </svg>
                    </span>
                    <span class="nav-link-text {{ request()->is('admin/users*') ? 'active' : '' }}">User</span>
                    <span class="submenu-arrow">
                        <svg
                            width="1em"
                            height="1em"
                            viewBox="0 0 16 16"
                            class="bi bi-chevron-down"
                            fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"
                            />
                        </svg>
                    </span>
                </a>
                <div
                    id="submenu-1"
                    class="collapse submenu submenu-1 {{ request()->is('admin/*') ? 'show' : '' }}"
                    data-bs-parent="#menu-accordion"
                >
                    <ul class="submenu-list list-unstyled">
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ url('admin/users') }}">Admin</a>
                        </li>
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->is('admin/operator*') ? 'active' : '' }}" href="{{ url('admin/operators') }}">Pemandu</a>
                        </li>
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->is('admin/mahasiswa*') ? 'active' : '' }}" href="{{ url('admin/mahasiswa') }}">Mahasiswa</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            <!--//nav-item-->
            @if(auth()->user()->role === 'admin')
            <li class="nav-item">
              <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
              <a class="nav-link {{ request()->is('admin/group*') ? 'active' : '' }}" href="{{ url('admin/groups') }}">

                <span class="nav-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-gear" viewBox="0 0 16 16">
                      <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
                    </svg>
                </span>
                <span class="nav-link-text">Data Kelompok</span> </a
              ><!--//nav-link-->
            </li>
            @endif
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'operator')
    <li class="nav-item">
        <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
        <a class="nav-link {{ request()->is('kegiatan*') ? 'active' : '' }}" href="{{ url('kegiatan') }}">
            <span class="nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                  </svg>
            </span>
            <span class="nav-link-text">Data Kegiatan</span>
        </a>
        <!--//nav-link-->
    </li>
@endif
@if(auth()->user()->role === 'admin')
    <li class="nav-item">
        <a class="nav-link {{ request()->is('absensi*') ? 'active' : '' }}" href="{{ url('absensi') }}">
            <span class="nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm4.5 3.5a.5.5 0 0 1 .5.5v3h2v-3a.5.5 0 0 1 1 0v3.5a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V8a.5.5 0 0 1 .5-.5zM6 2a.5.5 0 0 1 .5-.5H9A.5.5 0 0 1 9.5 2v.5H6V2z"/>
                </svg>
            </span>
            <span class="nav-link-text">Data Absensi</span>
        </a>
    </li>
@endif
@if(auth()->user()->role === 'operator')
    <li class="nav-item">
        <a class="nav-link {{ request()->is('operator/absensi*') ? 'active' : '' }}" href="{{ url('operator/absensi') }}">
            <span class="nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm4.5 3.5a.5.5 0 0 1 .5.5v3h2v-3a.5.5 0 0 1 1 0v3.5a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V8a.5.5 0 0 1 .5-.5zM6 2a.5.5 0 0 1 .5-.5H9A.5.5 0 0 1 9.5 2v.5H6V2z"/>
                </svg>
            </span>
            <span class="nav-link-text">Data Absensi</span>
        </a>
    </li>
@endif



            <!--//nav-item-->
          </ul>
          <!--//app-menu-->
        </nav>
        <!--//app-nav-->

        <!--//app-sidepanel-footer-->
      </div>
      <!--//sidepanel-inner-->
    </div>
    <!--//app-sidepanel-->
  </header>
