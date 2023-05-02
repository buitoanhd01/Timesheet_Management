<!DOCTYPE html>
<html
  lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>@yield('title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico')}}" />

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    /> --}}

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />

  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          {{-- logo brand --}}
          @include('include.app-brand')

          <div class="menu-inner-shadow"></div>

          {{-- navbar  --}}
          @include('include.nav')
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          @include('include.navbar')

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            @yield('content')
            @include('include.modal')
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

    <input type="hidden" id="get_self_check_status" value="{{ route('get_self_check_status') }}">
    <input type="hidden" id="update_list_calendar" value="{{ route('update_list_calendar') }}">
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/extended-ui-perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js')}}"></script>

    <script src="{{ asset('assets/js/config.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/datepicker/css/bootstrap-datepicker3.standalone.css') }}">
    <script src="{{ asset('assets/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
      function removeTrailingSlash(str) {
        if (str.endsWith('/')) {
          return str.slice(0, -1);
        }
        return str;
      }
      const menuItems = document.querySelectorAll('.menu-item');

      menuItems.forEach((item) => {
        
        item.addEventListener('click', () => {
          
          menuItems.forEach((item) => {
            item.classList.remove('active');
          });
      
            
          item.classList.add('active');
      
        });
      });
      
      // Kiểm tra nếu đã có trạng thái active được lưu trữ trong Local Storage
      const activeMenuItem = window.location.href;
      if (activeMenuItem) {
        if (activeMenuItem.endsWith('/')) {
          activeMenuItemNew = activeMenuItem.slice(0, -1);
        } else {
          activeMenuItemNew = activeMenuItem;
        }
        // Thêm class active vào menu item có id được lưu trữ trong Local Storage
        let children = document.querySelector('a[href="' + activeMenuItemNew +'"]');
        children.parentElement.classList.add('active');
      } else {
        menuItems[0].classList.add('active');
      }

      const Toast = Swal.mixin({
      toast: true,
      position: 'middle-end',
      showConfirmButton: false,
      timer: 1000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })
    </script>

    @yield('scripts')

    {{-- <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script> --}}
  </body>
</html>
