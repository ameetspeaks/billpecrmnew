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
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/admin/upload/'.\App\Models\Setting::where('type','company_fav_icon')->first()->value) }}">

    @include('store.storeAdmin.layout.partials.head')
</head>

@if (Route::is(['store.chat']))

    <body class="main-chat-blk">
@endif
@if (!Route::is(['store.chat', 'store.under-maintenance', 'store.coming-soon', 'store.error-404', 'store.error-500','store.two-step-verification-3','store.two-step-verification-2','store.two-step-verification','store.email-verification-3','store.email-verification-2','store.email-verification','store.reset-password-3','store.reset-password-2','store.reset-password','store.forgot-password-3','store.forgot-password-2','store.forgot-password','store.register-3','store.register-2','store.register','store.signin-3','store.signin-2','store.signin','store.success','store.success-2','store.success-3']))

    <body>
@endif
@if (Route::is(['store.under-maintenance', 'store.coming-soon', 'store.error-404', 'store.error-500']))

    <body class="error-page">
@endif
@if (Route::is(['store.two-step-verification-3','store.two-step-verification-2','store.two-step-verification','store.email-verification-3','store.email-verification-2','store.email-verification','store.reset-password-3','store.reset-password-2','store.reset-password','store.forgot-password-3','store.forgot-password-2','store.forgot-password','store.register-3','store.register-2','store.register','store.signin-3','store.signin-2','store.signin','store.success','store.success-2','store.success-3']))

    <body class="account-page">
@endif
@component('store.storeAdmin.components.loader')
@include('store.storeAdmin.layout.partials.session')
@endcomponent
<!-- Main Wrapper -->
@if (!Route::is(['store.lock-screen']))
    <div class="main-wrapper">
@endif
@if (Route::is(['store.lock-screen']))
    <div class="main-wrapper login-body">
@endif
@if (!Route::is(['store.under-maintenance', 'store.coming-soon','store.error-404','store.error-500','store.two-step-verification-3','store.two-step-verification-2','store.two-step-verification','store.email-verification-3','store.email-verification-2','store.email-verification','store.reset-password-3','store.reset-password-2','store.reset-password','store.forgot-password-3','store.forgot-password-2','store.forgot-password','store.register-3','store.register-2','store.register','store.signin-3','store.signin-2','store.signin','store.success','store.success-2','store.success-3','store.lock-screen']))
    @include('store.storeAdmin.layout.partials.header')
@endif
@if (!Route::is(['store.pos', 'store.under-maintenance', 'store.coming-soon','store.error-404','store.error-500','store.two-step-verification-3','store.two-step-verification-2','store.two-step-verification','store.email-verification-3','store.email-verification-2','store.email-verification','store.reset-password-3','store.reset-password-2','store.reset-password','store.forgot-password-3','store.forgot-password-2','store.forgot-password','store.register-3','store.register-2','store.register','store.signin-3','store.signin-2','store.signin','store.success','store.success-2','store.success-3','store.lock-screen']))
    @include('store.storeAdmin.layout.partials.sidebar')
    @include('store.storeAdmin.layout.partials.collapsed-sidebar')
    @include('store.storeAdmin.layout.partials.horizontal-sidebar')
@endif
@yield('content')
</div>
<!-- /Main Wrapper -->
@include('store.storeAdmin.layout.partials.theme-settings')
@component('store.storeAdmin.components.modalpopup')
@endcomponent
@include('store.storeAdmin.layout.partials.footer-scripts')
</body>

</html>
