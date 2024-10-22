<!DOCTYPE html>

<html lang="zxx">



<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BillPe Billing APP</title>

    <!-- favicon  -->

    <link rel="shortcut icon" href="{{asset('billpeapp/assets/images/favicon.png')}}" type="image/x-icon">

    <!-- faremwork of css -->

    <link rel="stylesheet" href="{{asset('billpeapp/assets/css/bootstrap-lib/bootstrap.min.css')}}">

    <!-- style sheet of css        -->

    <link rel="stylesheet" href="{{asset('billpeapp/assets/css/style.css')}}">

    <!-- Responsive sheet of css -->

    <link rel="stylesheet" href="{{asset('billpeapp/assets/css/responsive.css')}}">

    <!-- fonts awsome icon link           -->

    <link rel="stylesheet" href="{{asset('billpeapp/assets/font-awesome-lib/icon/font-awesome.min.css')}}">

    <!-- slick-slider link css -->

    <link rel="stylesheet" href="{{asset('billpeapp/assets/css/slick.min.css')}}">

    <!-- animation of css -->

    <link rel="stylesheet" href="{{asset('billpeapp/assets/css/aos.css')}}">



     <!-- jQuery -->

     <script src="{{ asset('build/js/jquery-3.7.1.min.js') }}"></script>



</head>

<body>

    <div class="site-wrapper">

        @yield('content')



        <!-- ======== 1.13. footer section ========  -->

        @if (!Route::is([ '404', 'coming' ]))

            @include('billpeapp/layout/footer')

        @endif

        <!-- ======== End of 1.13. footer section ========  -->

    </div>

    <!-- end site wrapper -->

    <!-- button back to top -->

    <button onclick="scrollToTop()" id="backToTopBtn"><i class="fa-solid fa-arrow-turn-up"></i></button>



    <!-- bootstrap min javascript -->

    <script src="{{asset('billpeapp/assets/js/javascript-lib/bootstrap.min.js')}}"></script>

    <!-- j Query -->

    <script src="{{asset('billpeapp/assets/js/jquery.js')}}"></script>

    <!-- slick slider js -->

    <script src="{{asset('billpeapp/assets/js/slick.min.js')}}"></script>

    <!-- main javascript -->

    <script src="{{asset('billpeapp/assets/js/custom.js')}}"></script>

    <!-- counter javascript file -->

    <script src="{{asset('billpeapp/assets/js/waypoints.min.js')}}"></script>

    <!-- animation from javascript -->

    <script src="{{asset('billpeapp/assets/js/aos.js')}}"></script>

    <script>

        AOS.init({

            once: true,

            duration: 1500,

        });





      </script>

</body>



</html>
