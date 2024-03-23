<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>
        {{ @$title != '' ? "$title |": '' }}
        {{ settings()->get('app_name', 'My APP') }}
    </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/libs/apex-charts/apex-charts.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('sneat') }}/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('sneat') }}/assets/js/config.js"></script>
    <link rel="stylesheet" href="{{ asset('font/css/all.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('sneat') }}/assets/js/ajax.js"></script>
    @yield('style')
    <style>
        .layout-navbar .navbar-dropdown .dropdown-menu{
            min-width: 22rem;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
    }
    </style>
    <script>
    //melihat bukti bayar
    const popupCenter = ({url, title, w, h}) => {
    // Fixes dual-screen position                             Most browsers      Firefox
    const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
    const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

    const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    const systemZoom = width / window.screen.availWidth;
    const left = (width - w) / 2 / systemZoom + dualScreenLeft
    const top = (height - h) / 2 / systemZoom + dualScreenTop
    const newWindow = window.open(url, title,
      `
      scrollbars=yes,
      width=${w / systemZoom},
      height=${h / systemZoom},
      top=${top},
      left=${left}
      `
    )

    if (window.focus) newWindow.focus();
}
    </script>
  </head>

  <body>
    <div class="overlay d-none" id="loading-overlay">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo mt-0" style="background-color: #649B4E">
            <a href="{{ route('setting.create') }}" class="app-brand-link">
        <img src="{{ asset('storage/images/megatama-b.png') }}" alt="Nama Instansi" class="mx-1 img-fluid navbar-logo d-flex justify-content-center" width="50">
              <span class="app-brand-text menu-text fw-bolder text-white">{{ settings()->get('app_name', 'My APP') }}</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1" style="background-color: #649B4E">
            <!-- Dashboard -->
            <li class="menu-item {{ Route::is('operator.beranda')? 'active' : '' }}">
              <a href="{{ route('operator.beranda') }}" class="menu-link text-white">
                <i class="menu-icon tf-icons bx bx-home-circle text-white"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <!-- Cards -->
            @can('operator')
            <li class="menu-item {{ Route::is('setting.*')? 'active' : '' }}">
              <a href="{{ route('setting.create') }}" class="menu-link text-white">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Basic">Pengaturan Aplikasi</div>
              </a>
            </li>
            <li class="menu-item {{ Route::is('user.*')? 'active' : '' }}">
              <a href="{{ route('user.index') }}" class="menu-link text-white">
                <i class="menu-icon tf-icons fa-solid fa-user-secret"></i>
                <div data-i18n="Basic">Data user</div>
              </a>
            </li>
            <li class="menu-item {{ Route::is('banksekolah.*')? 'active' : '' }}">
              <a href="{{ route('banksekolah.index') }}" class="menu-link text-white">
                <i class="menu-icon tf-icons fa fa-building-columns"></i>
                <div data-i18n="Basic">Data Rekening Sekolah</div>
              </a>
            </li>
            @endcan
            <li class="menu-item {{ Route::is('wali.*')? 'active' : '' }}">
              <a href="{{ route('wali.index') }}" class="menu-link text-white">
                <i class="menu-icon tf-icons fa fa-users"></i>
                <div data-i18n="Basic">Data Wali Murid</div>
              </a>
            </li>
            <li class="menu-item {{ Route::is('siswa.*')? 'active' : '' }}">
              <a href="{{ route('siswa.index') }}" class="menu-link text-white">
                <i class="menu-icon tf-icons bx bxs-graduation"></i>
                <div data-i18n="Basic">Data Siswa</div>
              </a>
            </li>
            @can('operator')
            <li class="menu-item {{ Route::is('biaya.*')? 'active' : '' }}">
              <a href="{{ route('biaya.index') }}" class="menu-link text-white">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div data-i18n="Basic">Data Biaya</div>
              </a>
            </li>
            <li class="menu-item {{ Route::is('jobstatus.*')? 'active' : '' }}">
              <a href="{{ route('jobstatus.index') }}" class="menu-link text-white">
                <i class="menu-icon tf-icons fa-solid fa-plus"></i>
                <div data-i18n="Basic">Buat Tagihan</div>
              </a>
            </li>

            <li class="menu-item {{ Route::is('tagihan.*')? 'active' : '' }}">
              <a href="{{ route('tagihan.index') }}" class="menu-link text-white">
                <i class="menu-icon tf-icons fa-solid fa-money-bills"></i>
                <div data-i18n="Basic">Data Tagihan</div>
              </a>
            </li>
            <li class="menu-item {{ Route::is('pembayaran.*')? 'active' : '' }}">
              <a href="{{ route('pembayaran.index') }}" class="menu-link text-white">
                <i class="menu-icon tf-icons fa-solid fa-money-check-dollar"></i>
                <div data-i18n="Basic">
                    Data Pembayaran
                    <span class="badge badge-center rounded-pill bg-danger">{{ auth()->user()->unreadNotifications->count()}}</span>
                </div>
              </a>
            </li>
            @endcan
            <li class="menu-item {{ Route::is('laporanform.*') || Route::is('laporantagihan.*')? 'active' : '' }}">
              <a href="{{ route('laporanform.create') }}" class="menu-link text-white">
                <i class="menu-icon tf-icons fa-solid fa-circle-info"></i>
                <div data-i18n="Basic">
                  Data Laporan
                </div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{ route('logout') }}" class="menu-link text-white">
                <i class="menu-icon tf-icons fa-solid fa-power-off"></i>
                <div data-i18n="Basic">Logout</div>
              </a>
            </li>
            {{-- boxicons --}}

          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>
            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                <!-- Search -->
                    <div class="d-flex justify-content-start">{{ settings()->get('app_name','My App') }}</div>
                  {{-- {!! Form::open(['route' => 'tagihan.index', 'method'=>'GET']) !!} --}}
                {{-- <div class="nav-item d-flex align-items-center">
                  <button type="submit" class="btn btn-link"><i class="bx bx-search fs-4 lh-0"></i></button>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Pencarian Data Tagihan"
                    aria-label="Search..."
                    name="q"
                    value="{{ request("q") }}"
                  />
                </div> --}}
                {{-- {!! Form::close() !!} --}}
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                      <i class="bx bx-bell bx-sm"></i>
                      <span class="badge bg-danger rounded-pill badge-notifications">
                        {{ auth()->user()->unreadNotifications->count()}}
                      </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end py-0">
                      <li class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                          <h5 class="text-body mb-0 me-auto">Notification</h5>
                          <form action="{{ route('readAll') }}" method="POST" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Mark all as read" data-bs-original-title="Mark all as read">
                            @csrf
                            <button type="submit" class="btn btn-sm"><i class="bx fs-4 bx-envelope-open"></i>
                            </button>
                        </form>
                        </div>
                      </li>
                      <li class="dropdown-notifications-list scrollable-container ps">
                        <ul class="list-group list-group-flush">
                            @foreach (auth()->user()->unreadNotifications as $notification)
                          <li class="list-group-item list-group-item-action dropdown-notifications-item">
                            <a href="{{ url($notification->data['url'].'?id='. $notification->id ) }}">
                            <div class="d-flex">
                              <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $notification->data['title'] }}</h6>
                                <p class="mb-0">{{ ucwords($notification->data['messages']) }}</p>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                              </div>
                              <div class="flex-shrink-0 dropdown-notifications-actions">
                                <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                              </div>
                            </div>
                            </a>
                          </li>
                          @endforeach
                        </ul>
                      <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></li>
                      <li class="dropdown-menu-footer border-top">
                        <a href="javascript:void(0);" class="dropdown-item d-flex justify-content-center p-3">
                          View all notifications
                        </a>
                      </li>
                    </ul>
                  </li>
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{ asset('sneat') }}/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="{{ asset('sneat') }}/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('user.edit', auth()->user()->id) }}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="alert alert-success d-none" role="alert" id="alert-message">
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                    </div>
                @endif
                @yield('content')
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('sneat') }}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('sneat') }}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('sneat') }}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('sneat') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{ asset('sneat') }}/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('sneat') }}/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('sneat') }}/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="{{ asset('sneat') }}/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('font/js/jquery.mask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.rupiah').mask("#.##0", {reverse: true});
            $('.select2').select2();
        });
    </script>
    @yield('js')
  </body>
</html>
