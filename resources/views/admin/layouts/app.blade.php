<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- Fav Icon --}}
    <link rel="shortcut icon" href="{{ asset('admin/upload/'.\App\Models\Setting::where('type','company_fav_icon')->first()->value) }}" />
    <link rel="stylesheet" href="{{ asset('admin/multiSelector/filter_multi_select.css') }}" />

    {{-- My Custom Files --}}
    <link rel="stylesheet" href="{{ asset('public\admin\customFiles\css\custom.css') }}" />
    {{-- END:: My Custom Files --}}


    <title>
      billpe - admin
   </title>



    <link rel="stylesheet" href="{{ asset('admin/vendors/typicons.font/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/imageDropdown/dist/css/dd.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.base.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/css/vertical-layout-light/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">


    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link href="{{ asset('admin/searchDropDown/select2.min.css') }}" rel="stylesheet" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

    {{-- Multiple selector --}}
    <link rel="stylesheet" href="{{asset("public\admin\select2\select2.css")}}">

    <!-- jQuery -->
    <script src="{{ asset('build/js/jquery-3.7.1.min.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <style>
          ::after, ::before{
              border-color:red !important;
            }

            .loader,
        .loader:after {
            border-radius: 50%;
            width: 10em;
            height: 10em;
        }
        .loader {
            margin: 60px auto;
            font-size: 10px;
            position: relative;
            text-indent: -9999em;
            z-index: 999999;
            border-top: 1.1em solid #e3e3e3;
            border-right: 1.1em solid #e3e3e3;
            border-bottom: 1.1em solid #e3e3e3;
            border-left: 1.1em solid #31855e;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
            -webkit-animation: load8 1.1s infinite linear;
            animation: load8 1.1s infinite linear;
        }
        @-webkit-keyframes load8 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes load8 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        #loadingDiv {
            position:absolute;;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background-color:transparent;
        }

      /* Multiple Select DropDwon PLugins */
      .ms-parent button span{
        top: 50%;
          left: 50%;
          transform: translate(-105%,-50%);
      }
      .ms-parent button{
        border:none !important;
        height: 18px;
      }

    </style>


  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
        @include('admin/layouts/header')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        <div class="theme-setting-wrapper">
          <div id="settings-trigger"><i class="typcn typcn-cog-outline"></i></div>
          <div id="theme-settings" class="settings-panel">
            <i class="settings-close typcn typcn-delete-outline"></i>
            <p class="settings-heading">SIDEBAR SKINS</p>
            <div class="sidebar-bg-options" id="sidebar-light-theme">
              <div class="img-ss rounded-circle bg-light border mr-3"></div>
              Light
            </div>
            <div class="sidebar-bg-options selected" id="sidebar-dark-theme">
              <div class="img-ss rounded-circle bg-dark border mr-3"></div>
              Dark
            </div>
            <p class="settings-heading mt-2">HEADER SKINS</p>
            <div class="color-tiles mx-0 px-4">
              <div class="tiles success"></div>
              <div class="tiles warning"></div>
              <div class="tiles danger"></div>
              <div class="tiles primary"></div>
              <div class="tiles info"></div>
              <div class="tiles dark"></div>
              <div class="tiles default border"></div>
            </div>
          </div>
        </div>
        <!-- partial -->
        <!-- partial:partials/_sidebar.html -->
        @include('admin.layouts.sidebar')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
            @include('admin.layouts.footer')
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->


    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('admin/vendors/js/vendor.bundle.base.js') }}"></script>

    <script src="{{ asset('admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/js/template.js') }}"></script>
    <script src="{{ asset('admin/js/settings.js') }}"></script>
    <script src="{{ asset('admin/js/todolist.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>




     {{-- My Custom Files --}}
     <script src="{{asset('public\admin\customFiles\js\custom.js')}}"></script>
     {{-- END:: My Custom Files --}}

    {{-- search dropdown --}}
    <script src="{{ asset('admin/searchDropDown/select2.min.js') }}"></script>


    {{-- sweet alert --}}
    <script src="{{ asset('js/sweetalert.js') }}"></script>

    <!-- plugin js for this page -->
    <script src="{{ asset('admin/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/imageDropdown/dist/js/dd.min.js') }}"></script>
    <!-- End plugin js for this page -->

    <!-- Custom js for this page-->
    <script src="{{ asset('admin/js/dashboard.js') }}"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>


    <!-- End custom js for this page-->
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

     <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    @stack('js')

        {{-- Multi selector --}}
        <script src="{{asset('admin/multiSelector/filter-multi-select-bundle.min.js')}}"></script>

        {{-- MultiSelector  --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

        {{-- Multiple Selector --}}
        <script src="{{asset("public\admin\select2\select2.js")}}"></script>

        <script>
          $(document).ready(function() {
              $('.js-example-basic-single').select2();
          });
        </script>
  </body>
</html>
