<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        billpe - admin
     </title>

    <link rel="stylesheet" href="{{ asset('public/admin/vendors/typicons.font/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/vendors/css/vendor.bundle.base.css') }}">

    <link rel="stylesheet" href="{{ asset('public/admin/css/vertical-layout-light/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('public/admin/upload/1697545073-652e7b7162bf7.png')}}" />
</head>

<style>
    .errorMsg{
        color: red;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
    }
</style>

<body>
  
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper">
                <!-- <h3 class="errorMsg"></h3> -->
               
                @if (\Session::has('error'))
                    <div class="alert alert-danger" style="margin-right: 450px;margin-left: 450px;">
                        <ul>
                            <li class="errorMsg">{!! \Session::get('error') !!}</li>
                        </ul>
                    </div>
                @endif
                <div id="otpless-login-page"></div>
            </div>

            <form method="post" id="loginForm">
                @csrf
                <input type="hidden" name="otp_token" id="otp_token">
            </form>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="{{ asset('public/admin/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{ asset('public/admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('public/admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('public/admin/js/template.js') }}"></script>
    <script src="{{ asset('public/admin/js/settings.js') }}"></script>
    <script src="{{ asset('public/admin/js/todolist.js') }}"></script>
    <!-- endinject -->
    <script id="otpless-sdk" type="text/javascript" src="https://otpless.com/v2/auth.js" data-appid="2ut63h4v"></script>


    <script type="text/javascript"> 
        function otpless(otplessUser) {
            // console.log(JSON.stringify(otplessUser));
            $('#otp_token').val(otplessUser.token);
            // console.log(otplessUser.token);

            $('form#loginForm').submit();
            // var verifyToken = otplessUser.token;
            // $('.errorMsg').text(' ');
            // $.ajax({
            //     url: "",
            //     method: 'post',
            //     data: { "_token" : "{{csrf_token()}}", "verifyToken": verifyToken},
            //     success: function(data){
            //         console.log(data)
            //         if(data.status == 401){
            //             $('.errorMsg').text(data.error);
            //         }
            //         if (data.status == 1) {
            //             window.location.href = data.redirect;
            //         }
            //     }
            // });
        }
    </script>
</body>

</html>

