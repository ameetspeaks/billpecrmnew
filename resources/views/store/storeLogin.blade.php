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

<body>
  
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo text-center">
                                <img src="{{asset('public/admin/upload/1697545099-652e7b8befc57.png')}}" alt="logo" class="object-contain" />
                            </div>
                            <h4 class="text-center">Store Login</h4>
                            <div id="sendOTP">
                                <form class="pt-3" name="login_form" onsubmit="return false;" method="POST">
                                    @csrf

                                    <div class="form-group err_phone">
                                        <input type="number" name="phone" class="form-control form-control-lg" id="exampleInputphone" placeholder="Whatsapp Number">
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn verifybtn" id="send_otp">SEND OTP</button>
                                    </div>
                                </form>
                            </div>
                            <span class="msg"></span>
                            <div id="verifyOTP">
                                <form class="pt-3" name="otp_form" onsubmit="return false;" method="POST">
                                    @csrf

                                    <div class="form-group err_otp">
                                        <input type="text" name="otp" class="form-control form-control-lg" id="exampleInputotp" placeholder="Otp">
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn verifybtn" id="verify_otp">VERIFY OTP</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

<script>

    $(document).ready(function(){
        $('#verifyOTP').hide();
    })

    $('#send_otp').on('click', function (e) {
        e.preventDefault();
        var phone = $('#exampleInputphone').val();
        
        $.ajax({
                url: "{{ route('store.login.sendotp') }}",
                method: 'post',
                data: { "_token" : "{{csrf_token()}}", 'phone': phone },
                beforeSend: function() {
                    $('span.alerts').remove();
                    $("div#divLoading").addClass('show');
                },
                success: function(data){
                    $('.msg').empty();
                    console.log(data)
                    if (data.status == 401) {

                        $.each(data.error1, function(index, value) {
                            console.log('.err_' + index + ' input')
                            $('.err_' + index + ' input').addClass(
                                'border border-danger');
                            $('.err_' + index).append(
                                '<span class="small alerts text-danger">' +
                                value + '</span>');
                        });
                    }
                    if(data.status == 1)
                    {
                        $('.msg').append(data.msg);
                        $('#sendOTP').hide();
                        $('#verifyOTP').show();
                    }
                }
        });
    });


    $('#verify_otp').on('click', function (e) {
        e.preventDefault();
        var phone = $('#exampleInputphone').val();
        var otp = $('#exampleInputotp').val();
       
        $.ajax({
            url: "{{ route('store.login.verifyotp') }}",
            method: 'post',
            data: { "_token" : "{{csrf_token()}}", 'phone': phone , "otp": otp},
            beforeSend: function() {
                $('span.alerts').remove();
                $("div#divLoading").addClass('show');
            },
            success: function(data){
                console.log(data)
                if (data.status == 401) {

                    $.each(data.error1, function(index, value) {
                        console.log('.err_' + index + ' input')
                        $('.err_' + index + ' input').addClass(
                            'border border-danger');
                        $('.err_' + index).append(
                            '<span class="small alerts text-danger">' +
                            value + '</span>');
                    });
                }
                if (data.status == 1) {
                    window.location.href = data.redirect;
                }
                
            }
        });
    });

</script>
</body>

</html>

