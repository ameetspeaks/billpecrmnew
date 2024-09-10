<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>billpe - store</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('public/admin/upload/'.\App\Models\Setting::where('type','company_fav_icon')->first()->value)); ?>">

    <?php echo $__env->make('store.storeAdmin.layout.partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<?php if(Route::is(['store.chat'])): ?>

    <body class="main-chat-blk">
<?php endif; ?>
<?php if(!Route::is(['store.chat', 'store.under-maintenance', 'store.coming-soon', 'store.error-404', 'store.error-500','store.two-step-verification-3','store.two-step-verification-2','store.two-step-verification','store.email-verification-3','store.email-verification-2','store.email-verification','store.reset-password-3','store.reset-password-2','store.reset-password','store.forgot-password-3','store.forgot-password-2','store.forgot-password','store.register-3','store.register-2','store.register','store.signin-3','store.signin-2','store.signin','store.success','store.success-2','store.success-3'])): ?>

    <body>
<?php endif; ?>
<?php if(Route::is(['store.under-maintenance', 'store.coming-soon', 'store.error-404', 'store.error-500'])): ?>

    <body class="error-page">
<?php endif; ?>
<?php if(Route::is(['store.two-step-verification-3','store.two-step-verification-2','store.two-step-verification','store.email-verification-3','store.email-verification-2','store.email-verification','store.reset-password-3','store.reset-password-2','store.reset-password','store.forgot-password-3','store.forgot-password-2','store.forgot-password','store.register-3','store.register-2','store.register','store.signin-3','store.signin-2','store.signin','store.success','store.success-2','store.success-3'])): ?>

    <body class="account-page">
<?php endif; ?>
<?php $__env->startComponent('store.storeAdmin.components.loader'); ?>
<?php echo $__env->make('store.storeAdmin.layout.partials.session', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->renderComponent(); ?>
<!-- Main Wrapper -->
<?php if(!Route::is(['store.lock-screen'])): ?>
    <div class="main-wrapper">
<?php endif; ?>
<?php if(Route::is(['store.lock-screen'])): ?>
    <div class="main-wrapper login-body">
<?php endif; ?>
<?php if(!Route::is(['store.under-maintenance', 'store.coming-soon','store.error-404','store.error-500','store.two-step-verification-3','store.two-step-verification-2','store.two-step-verification','store.email-verification-3','store.email-verification-2','store.email-verification','store.reset-password-3','store.reset-password-2','store.reset-password','store.forgot-password-3','store.forgot-password-2','store.forgot-password','store.register-3','store.register-2','store.register','store.signin-3','store.signin-2','store.signin','store.success','store.success-2','store.success-3','store.lock-screen'])): ?>
    <?php echo $__env->make('store.storeAdmin.layout.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php if(!Route::is(['store.pos', 'store.under-maintenance', 'store.coming-soon','store.error-404','store.error-500','store.two-step-verification-3','store.two-step-verification-2','store.two-step-verification','store.email-verification-3','store.email-verification-2','store.email-verification','store.reset-password-3','store.reset-password-2','store.reset-password','store.forgot-password-3','store.forgot-password-2','store.forgot-password','store.register-3','store.register-2','store.register','store.signin-3','store.signin-2','store.signin','store.success','store.success-2','store.success-3','store.lock-screen'])): ?>
    <?php echo $__env->make('store.storeAdmin.layout.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('store.storeAdmin.layout.partials.collapsed-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('store.storeAdmin.layout.partials.horizontal-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php echo $__env->yieldContent('content'); ?>
</div>
<!-- /Main Wrapper -->
<?php echo $__env->make('store.storeAdmin.layout.partials.theme-settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->startComponent('store.storeAdmin.components.modalpopup'); ?>
<?php echo $__env->renderComponent(); ?>
<?php echo $__env->make('store.storeAdmin.layout.partials.footer-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH /home4/billp5kj/public_html/resources/views/store/storeAdmin/layout/mainlayout.blade.php ENDPATH**/ ?>