 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/css/bootstrap.min.css')); ?>">

 <!-- Datetimepicker CSS -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/daterangepicker/daterangepicker.css')); ?>">
 <link rel="stylesheet" href="<?php echo e(url('public/build/css/bootstrap-datetimepicker.min.css')); ?>">

 <!-- animation CSS -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/css/animate.css')); ?>">

 <!-- Select2 CSS -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/select2/css/select2.min.css')); ?>">

 <!-- Fontawesome CSS -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/fontawesome/css/fontawesome.min.css')); ?>">
 <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/fontawesome/css/all.min.css')); ?>">

 <!-- Feathericon CSS -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/css/feather.css')); ?>">

 <!-- Fancybox -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/fancybox/jquery.fancybox.min.css')); ?>">

 <!-- Summernote CSS -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/summernote/summernote-bs4.min.css')); ?>">

 <!-- Bootstrap Tagsinput CSS -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')); ?>">

 <!-- Datatable CSS -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/css/dataTables.bootstrap5.min.css')); ?>">

 <!-- Mobile CSS-->
 <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/intltelinput/css/intlTelInput.css')); ?>">
 <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/intltelinput/css/demo.css')); ?>">

 <link rel="stylesheet" href="<?php echo e(url('public/build/css/plyr.css')); ?>">

 <!-- Owl Carousel -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/css/owl.carousel.min.css')); ?>">

 <?php if(Route::is(['store.sales-dashboard'])): ?>
     <!-- Map CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/jvectormap/jquery-jvectormap-2.0.5.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.calendar'])): ?>
     <!-- Full Calander CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/fullcalendar/fullcalendar.min.css')); ?>">
 <?php endif; ?>

 <!-- Swiper CSS -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/swiper/swiper.min.css')); ?>">

 <!-- Boxicons CSS -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/boxicons/css/boxicons.min.css')); ?>">

 <?php if(Route::is(['store.ui-stickynote', 'store.ui-timeline'])): ?>
     <!-- Sticky CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/stickynote/sticky.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.ui-scrollbar'])): ?>
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/scrollbar/scroll.min.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.ui-toasts'])): ?>
     <!-- Toatr CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/toastr/toatr.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.ui-lightbox'])): ?>
     <!-- Lightbox CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/lightbox/glightbox.min.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.ui-clipboard', 'store.ui-drag-drop'])): ?>
     <!-- Dragula CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/dragula/css/dragula.min.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.icon-feather'])): ?>
     <!-- Feather CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/icons/feather/feather.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.icon-flag'])): ?>
     <!-- Pe7 CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/icons/flags/flags.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.icon-ionic'])): ?>
     <!-- Ionic CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/icons/ionic/ionicons.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.icon-material'])): ?>
     <!-- Material CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/material/materialdesignicons.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.icon-pe7'])): ?>
     <!-- Pe7 CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/icons/pe7/pe-icon-7.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.icon-simpleline'])): ?>
     <!-- Simpleline CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/simpleline/simple-line-icons.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.icon-themify'])): ?>
     <!-- Themify CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/icons/themify/themify.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.icon-typicon'])): ?>
     <!-- Pe7 CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/icons/typicons/typicons.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.icon-weather'])): ?>
     <!-- Pe7 CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/icons/weather/weathericons.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.ui-rangeslider'])): ?>
     <!-- Rangeslider CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/ion-rangeslider/css/ion.rangeSlider.min.css')); ?>">
 <?php endif; ?>

 <?php if(Route::is(['store.form-wizard'])): ?>
     <!-- Wizard CSS -->
     <link rel="stylesheet" href="<?php echo e(url('public/build/plugins/twitter-bootstrap-wizard/form-wizard.css')); ?>">
 <?php endif; ?>

 <!-- Main CSS -->
 <link rel="stylesheet" href="<?php echo e(url('public/build/css/style.css')); ?>">

<script src="<?php echo e(URL::asset('public/build/js/jquery-3.7.1.min.js')); ?>"></script>

<?php /**PATH /home4/billp5kj/public_html/resources/views/store/storeAdmin/layout/partials/head.blade.php ENDPATH**/ ?>