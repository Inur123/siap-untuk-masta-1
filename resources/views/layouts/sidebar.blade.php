  <header class="app-header fixed-top">
    <div class="app-header-inner">
        <div class="container-fluid py-2">
            <div class="app-header-content">
                <div class="row justify-content-between align-items-center">
                    <!-- Tombol Sidebar (Mobile) -->
                    <div class="col-auto">
                        <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img">
                                <title>Menu</title>
                                <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                    stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- User Dropdown dan Tanggal/Waktu di sebelahnya (Desktop only) -->
                    <div class="col-auto d-flex align-items-center">
                        <!-- Tanggal dan Jam -->
                        <div class="d-none d-md-block me-3">
                            <span id="current-time" class="text-success"></span>
                        </div>

                        <!-- User Dropdown -->
                        <div class="app-utility-item app-user-dropdown dropdown">
                            <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown"
                                href="#" role="button" aria-expanded="false"><img
                                    src="{{ asset('template/assets/images/icon-profile.png') }}" alt="user profile" /></a>
                            <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
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
                    </div>
                    <!--//col-->
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
              <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
              <div class="app-branding">
                  <a class="app-logo" href=""><img class="logo-icon me-2"
                          src="{{ asset('template/assets/images/logo-masta24.png') }}" alt="logo" /><span
                          class="logo-text">MASTAMARU 2025</span>
                  </a>
              </div>
              <!--//app-branding-->

              <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
                  <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                      <li class="nav-item">
                          <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                          <a class="nav-link {{ request()->is('mahasiswa/dashboard') || request()->is('admin/dashboard') || request()->is('operator/dashboard') ? 'active' : '' }}"
                              href="{{ url(auth()->user()->role === 'mahasiswa' ? 'mahasiswa/dashboard' : (auth()->user()->role === 'operator' ? 'operator/dashboard' : 'admin/dashboard')) }}">
                              <span class="nav-icon">
                                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house-door"
                                      fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd"
                                          d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z" />
                                      <path fill-rule="evenodd"
                                          d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                                  </svg>
                              </span>
                              <span class="nav-link-text">Dashboard</span>
                          </a><!--//nav-link-->
                      </li>
                      @if (auth()->user()->role === 'admin')
                          <li class="nav-item has-submenu {{ request()->is('admin/*') ? 'active' : '' }}">
                              <a class="nav-link submenu-toggle {{ request()->is('admin/operators*') || request()->is('admin/operators*') || request()->is('admin/mahasiswa*') || request()->is('admin/users*') ? 'active' : '' }}"
                                  href="#" data-bs-toggle="collapse" data-bs-target="#submenu-1"
                                  aria-expanded="{{ request()->is('admin/*') ? 'true' : 'false' }}"
                                  aria-controls="submenu-1">
                                  <span class="nav-icon">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                          fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                                          <path
                                              d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                                          <path
                                              d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z" />
                                      </svg>
                                  </span>
                                  <span
                                      class="nav-link-text {{ request()->is('admin/users*') ? 'active' : '' }}">User</span>
                                  <span class="submenu-arrow">
                                      <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down"
                                          fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                          <path fill-rule="evenodd"
                                              d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                      </svg>
                                  </span>
                              </a>
                              <div id="submenu-1"
                                  class="collapse submenu submenu-1 {{ request()->is('admin/*') ? 'show' : '' }}"
                                  data-bs-parent="#menu-accordion">
                                  <ul class="submenu-list list-unstyled">
                                      <li class="submenu-item">
                                          <a class="submenu-link {{ request()->is('admin/users*') ? 'active' : '' }}"
                                              href="{{ url('admin/users') }}">Admin</a>
                                      </li>
                                      <li class="submenu-item">
                                          <a class="submenu-link {{ request()->is('admin/operator*') ? 'active' : '' }}"
                                              href="{{ url('admin/operators') }}">Pemandu</a>
                                      </li>
                                      <li class="submenu-item">
                                          <a class="submenu-link {{ request()->is('admin/mahasiswa*') ? 'active' : '' }}"
                                              href="{{ url('admin/mahasiswa') }}">Mahasiswa</a>
                                      </li>
                                  </ul>
                              </div>
                          </li>
                      @endif
                      <!--//nav-item-->
                      @if (auth()->user()->role === 'admin')
                          <li class="nav-item">
                              <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                              <a class="nav-link {{ request()->is('admin/group*') ? 'active' : '' }}"
                                  href="{{ url('admin/groups') }}">
                                  <span class="nav-icon">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                          fill="currentColor" class="bi bi-person-gear" viewBox="0 0 16 16">
                                          <path
                                              d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
                                      </svg>
                                  </span>
                                  <span class="nav-link-text">Data Kelompok</span> </a><!--//nav-link-->
                          </li>
                          <li class="nav-item">
                              <a class="nav-link {{ request()->is('admin/create-announcement') ? 'active' : '' }}"
                                  href="{{ route('admin.create_announcement') }}">
                                  <span class="nav-icon">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                          fill="currentColor" class="bi bi-megaphone" viewBox="0 0 16 16">
                                          <path
                                              d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 75 75 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0m-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233q.27.015.537.036c2.568.189 5.093.744 7.463 1.993zm-9 6.215v-4.13a95 95 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A61 61 0 0 1 4 10.065m-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68 68 0 0 0-1.722-.082z" />
                                      </svg>
                                  </span>
                                  <span class="nav-link-text">Buat Pengumuman</span>
                              </a>
                          </li>
                      @endif

                      @if (auth()->user()->role === 'admin')
                          <li class="nav-item">
                              <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                              <a class="nav-link {{ request()->is('kegiatan*') ? 'active' : '' }}"
                                  href="{{ url('kegiatan') }}">
                                  <span class="nav-icon">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                          fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                          <path
                                              d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                          <path fill-rule="evenodd"
                                              d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                      </svg>
                                  </span>
                                  <span class="nav-link-text">Data Kegiatan</span>
                              </a>
                              <!--//nav-link-->
                          </li>
                      @endif
                      @if (auth()->user()->role === 'admin')
                          <li class="nav-item">
                              <a class="nav-link {{ request()->is('absensi*') ? 'active' : '' }}"
                                  href="{{ url('absensi') }}">
                                  <span class="nav-icon">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                          fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">
                                          <path
                                              d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9z" />
                                          <path
                                              d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1zm1.038 3.018a6 6 0 0 1 .924 0 6 6 0 1 1-.924 0M0 3.5c0 .753.333 1.429.86 1.887A8.04 8.04 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5M13.5 1c-.753 0-1.429.333-1.887.86a8.04 8.04 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1" />
                                      </svg>
                                  </span>
                                  <span class="nav-link-text">Data Absensi</span>
                              </a>
                          </li>
                      @endif
                      @if (auth()->user()->role === 'admin' || auth()->user()->role === 'operator')
                          <li class="nav-item">
                              <a class="nav-link {{ request()->is('card*') ? 'active' : '' }}"
                                  href="{{ url('card') }}">
                                  <span class="nav-icon">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                          fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                                          <path
                                              d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5M.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5M4 4h1v1H4z" />
                                          <path d="M7 2H2v5h5zM3 3h3v3H3zm2 8H4v1h1z" />
                                          <path d="M7 9H2v5h5zm-4 1h3v3H3zm8-6h1v1h-1z" />
                                          <path
                                              d="M9 2h5v5H9zm1 1v3h3V3zM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8zm2 2H9V9h1zm4 2h-1v1h-2v1h3zm-4 2v-1H8v1z" />
                                          <path d="M12 9h2V8h-2z" />
                                      </svg>
                                  </span>
                                  <span class="nav-link-text">Scan Qr Absensi</span>
                              </a>
                          </li>
                      @endif




                      @if (auth()->user()->role === 'operator')
                          <li class="nav-item">
                              <a class="nav-link {{ request()->is('operator/absensi*') ? 'active' : '' }}"
                                  href="{{ url('operator/absensi') }}">
                                  <span class="nav-icon">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                          fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">
                                          <path
                                              d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9z" />
                                          <path
                                              d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1zm1.038 3.018a6 6 0 0 1 .924 0 6 6 0 1 1-.924 0M0 3.5c0 .753.333 1.429.86 1.887A8.04 8.04 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5M13.5 1c-.753 0-1.429.333-1.887.86a8.04 8.04 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1" />
                                      </svg>
                                  </span>
                                  <span class="nav-link-text">Data Absensi</span>
                              </a>
                          </li>
                      @endif

                      @if (auth()->user()->role === 'mahasiswa')
                          <li class="nav-item">
                              <a class="nav-link {{ request()->is('mahasiswa/absensi*') ? 'active' : '' }}"
                                  href="{{ url('mahasiswa/absensi') }}">
                                  <span class="nav-icon">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                          fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">
                                          <path
                                              d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9z" />
                                          <path
                                              d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1zm1.038 3.018a6 6 0 0 1 .924 0 6 6 0 1 1-.924 0M0 3.5c0 .753.333 1.429.86 1.887A8.04 8.04 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5M13.5 1c-.753 0-1.429.333-1.887.86a8.04 8.04 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1" />
                                      </svg>
                                  </span>
                                  <span class="nav-link-text">Data Absensi</span>
                              </a>
                          </li>

                      @endif
                          @if (auth()->user()->role === 'mahasiswa')
                          <li class="nav-item">
                              <a class="nav-link {{ request()->is('sertifikat/preview*') ? 'active' : '' }}"
                                  href="{{ route('sertifikat.preview') }}">
                                  <span class="nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0"/>
                                      </svg>
                                  </span>
                                  <span class="nav-link-text">Download Sertifikat</span>
                              </a>
                          </li>
                        @endif
                        @if (auth()->user()->role === 'mahasiswa' || auth()->user()->role === 'operator')
                          <li class="nav-item">
                            <a class="nav-link {{ request()->is('kritik-saran*') ? 'active' : '' }}"
                                href="{{ route('kritik-saran') }}">
                                <span class="nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z"/>
                                      </svg>
                                </span>
                                <span class="nav-link-text">Kritik dan Saran</span>
                            </a>
                        </li>
                      @endif

                      @if (auth()->user()->role === 'admin')
                          <li class="nav-item">
                              <a class="nav-link {{ request()->is('generate-certificate-admin') ? 'active' : '' }}"
                                  href="{{ url('/generate-certificate-admin') }}">
                                  <span class="nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0"/>
                                      </svg>
                                  </span>
                                  <span class="nav-link-text">Generate Sertifikat BY Name</span>
                              </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link {{ request()->is('login-history*') ? 'active' : '' }}"
                               href="{{ route('login-history') }}"> <!-- Menggunakan route() -->
                                <span class="nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-lock" viewBox="0 0 16 16">
                                        <path d="M10 7v1.076c.54.166 1 .597 1 1.224v2.4c0 .816-.781 1.3-1.5 1.3h-3c-.719 0-1.5-.484-1.5-1.3V9.3c0-.627.46-1.058 1-1.224V7a2 2 0 1 1 4 0M7 7v1h2V7a1 1 0 0 0-2 0M6 9.3v2.4c0 .042.02.107.105.175A.64.64 0 0 0 6.5 12h3a.64.64 0 0 0 .395-.125c.085-.068.105-.133.105-.175V9.3c0-.042-.02-.107-.105-.175A.64.64 0 0 0 9.5 9h-3a.64.64 0 0 0-.395.125C6.02 9.193 6 9.258 6 9.3"/>
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                      </svg>
                                </span>
                                <span class="nav-link-text">Cek Login </span>
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

  <script>
      function updateTime() {
          var now = new Date();
          var options = {
              weekday: 'long',
              year: 'numeric',
              month: 'long',
              day: 'numeric',
              hour: '2-digit',
              minute: '2-digit',
              second: '2-digit'
          };
          var formattedTime = now.toLocaleString('id-ID', options);
          document.getElementById("current-time").innerText = formattedTime;
      }

      setInterval(updateTime, 1000);
      updateTime(); // Inisialisasi waktu saat halaman dimuat
  </script>
