<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>billpe - admin</title>


    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('public/admin/vendors/typicons.font/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/css/vertical-layout-light/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('public/admin/upload/1697545073-652e7b7162bf7.png') }}" />


    <style>
    .errorMsg {
        color: red;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
    }

    .login-container {
        max-width: 500px;
        margin: 100px auto;
    }
    </style>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="login-container">
                    <!-- Error Messages -->
                    @if (\Session::has('error'))
                    <div class="alert alert-danger text-center">
                        <ul>
                            <li class="errorMsg">{!! \Session::get('error') !!}</li>
                        </ul>
                    </div>
                    @endif


                    <!-- Login Form -->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Login via WhatsApp</h4>


                            <form method="post" action="{{ route('store.login.post') }}" id="loginForm">
                                @csrf
                                <div class="form-group">
                                    <label for="receiver_number">Enter WhatsApp Number</label>
                                    <input type="text" class="form-control" name="receiver_number" id="receiver_number"
                                        placeholder="WhatsApp Number" required>
                                </div>
                                <div class="otprow form-group" style="display:none">
                                    <label for="receiver_number">Enter OTP</label>
                                    <input type="text" class="form-control" name="otp" id="otp"
                                        placeholder="OTP" required>
                                </div>
                                


                                <div class="sendotprow text-center">
                                    <button type="button" class="sentotp btn btn-primary">Send WhatsApp Message</button>
                                </div>
                                
                                <div class="otprow text-center" style="display:none">
                                    <button type="button" class="verifyotp btn btn-primary">Verify OTP</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(".sentotp").on("click", function(){
            $.ajax({
                url:"{{ route('store.login.sendotpnew') }}",
                type:"post",
                data:{phone:$("#receiver_number").val(), "_token": "{{ csrf_token() }}"},
                dataType:"json",
                success:function(response){
                    if(response.status) {
                        $(".sendotprow").hide();
                        $(".otprow").show();
                    }
                }
                
            });
        })

        $(".verifyotp").on("click", function(){
            $.ajax({
                url:"{{ route('store.login.verifyotp') }}",
                type:"post",
                data:{phone:$("#receiver_number").val(),otp: $("#otp").val(), "_token": "{{ csrf_token() }}"},
                dataType:"json",
                success:function(response){
                    
                    if(response.status) {
                        location.href = response.redirect;
                    }
                }
                
            });
        });
    </script>
</body>

</html>