<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        billpe - admin
     </title>

    <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendors/typicons.font/font/typicons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendors/css/vendor.bundle.base.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('public/admin/css/vertical-layout-light/style.css')); ?>">

    <link rel="shortcut icon" href="<?php echo e(asset('public/admin/upload/'.\App\Models\Setting::where('type','company_fav_icon')->first()->value)); ?>" />
</head>

<body>
  
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo text-center">
                                <img src="<?php echo e(asset('public/admin/upload/'.\App\Models\Setting::where('type','company_logo')->first()->value)); ?>" alt="logo" class="object-contain" />
                            </div>
                            <h4 class="text-center">Login</h4>
                            <form class="pt-3" name="login_form" onsubmit="return false;" method="POST">
                                <?php echo csrf_field(); ?>

                                <div class="form-group err_email">
                                    <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                                </div>
                                <div class="form-group err_password">
                                    <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" id="submit_login">SIGN IN</button>
                                </div>
                            </form>
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
    <script src="<?php echo e(asset('public/admin/vendors/js/vendor.bundle.base.js')); ?>"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="<?php echo e(asset('public/admin/js/off-canvas.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/hoverable-collapse.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/template.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/settings.js')); ?>"></script>
    <script src="<?php echo e(asset('public/admin/js/todolist.js')); ?>"></script>
    <!-- endinject -->

<script>

$('#submit_login').on('click', function(e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var form = document.login_form;
    var formData = new FormData(form);
    var url = '<?php echo e(route('admin.login.insert')); ?>';
    $.ajax({
        type: 'POST',
        url: url,
        processData: false,
        contentType: false,
        dataType: 'json',
        data: formData,
        dataSrc: "",
        beforeSend: function() {

            $('span.alerts').remove();
            $("div#divLoading").addClass('show');
        },
        // complete: function(data, status) {
        //     $("div#divLoading").removeClass('show');
        //     if (status.indexOf('error') > -1) {
        //         showSwalSomethingGoesWrong();
        //     }
        // },
        success: function(data) {
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

<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/login.blade.php ENDPATH**/ ?>