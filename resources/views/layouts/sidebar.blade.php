{{-- <aside class="left-sidebar">

    <div>
      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="./index.html" class="text-nowrap logo-img">
          <img src="../assets/images/logos/logo-light.svg" alt="" />
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
          <i class="ti ti-x fs-8"></i>
        </div>
      </div>

      <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
            <span class="hide-menu">Home</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link {{ request()->is(auth()->user()->role === 'mahasiswa' ? 'mahasiswa/dashboard' : 'admin/dashboard') ? 'active' : '' }}"
               href="{{ url(auth()->user()->role === 'mahasiswa' ? 'mahasiswa/dashboard' : 'admin/dashboard') }}"
               aria-expanded="false">
                <span>
                    <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Dashboard</span>
            </a>
          </li>

          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
            <span class="hide-menu">Data</span>
          </li>

          @if(auth()->user()->role === 'admin')
            <li class="sidebar-item">
                <a class="sidebar-link {{ request()->is('admin/users') ? 'active' : '' }}" href="{{ url('admin/users') }}" aria-expanded="false">
                    <span>
                        <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
                    </span>
                    <span class="hide-menu">User</span>
                </a>
            </li>
          @endif


          @if(auth()->user()->role === 'admin')
          <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('admin.create_announcement') ? 'active' : '' }}" href="{{ route('admin.create_announcement') }}" aria-expanded="false">
                <span>
                    <!-- Ganti dengan ikon yang valid -->
                    <iconify-icon icon="solar:megaphone-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                  <span class="hide-menu">Pengumuman</span>
              </a>
          </li>
      @endif


        </ul>
        <div class="unlimited-access hide-menu bg-primary-subtle position-relative mb-7 mt-7 rounded-3">
          <div class="d-flex">
            <div class="unlimited-access-title me-3">
              <h6 class="fw-semibold fs-4 mb-6 text-dark w-75">Upgrade to pro</h6>
              <a href="#" target="_blank" class="btn btn-primary fs-2 fw-semibold lh-sm">Buy Pro</a>
            </div>
            <div class="unlimited-access-img">
              <img src="../assets/images/backgrounds/rocket.png" alt="" class="img-fluid">
            </div>
          </div>
        </div>
      </nav>

    </div>

  </aside> --}}


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
                  ><img src="{{ asset('template/assets/images/user.png') }}" alt="user profile"
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
          <a class="app-logo" href="index.html"
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
                    class="nav-link submenu-toggle {{ request()->is('admin/operators*') || request()->is('admin/operators*') ||request()->is('admin/users*') ? 'active' : '' }}"
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
            {{-- absensi segera hadir --}}
            {{-- <li class="nav-item has-submenu">
              <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
              <a
                class="nav-link submenu-toggle"
                href="#"
                data-bs-toggle="collapse"
                data-bs-target="#submenu-2"
                aria-expanded="false"
                aria-controls="submenu-2"
              >
                <span class="nav-icon">
                  <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                      <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                      <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                    </svg>
                </span>
                <span class="nav-link-text">Absensi</span>
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
                  </span
                ><!--//submenu-arrow--> </a
              ><!--//nav-link-->
              <div
                id="submenu-2"
                class="collapse submenu submenu-2"
                data-bs-parent="#menu-accordion"
              >
                <ul class="submenu-list list-unstyled">
                  <li class="submenu-item">
                    <a class="submenu-link" href="notifications.html"
                      >Data Absen</a
                    >
                  </li>
                  <li class="submenu-item">
                    <a class="submenu-link" href="account.html">Absen Kegiatan</a>
                  </li>
                  <!-- <li class="submenu-item">
                    <a class="submenu-link" href="settings.html">Mahasiswa</a>
                  </li>
                   -->
                </ul>
              </div>
            </li> --}}

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
