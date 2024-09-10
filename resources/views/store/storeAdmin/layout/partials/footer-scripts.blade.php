 <!-- jQuery -->
 <script src="{{ URL::asset('public/build/js/jquery-3.7.1.min.js') }}"></script>

 <!-- Feather Icon JS -->
 <script src="{{ URL::asset('public/build/js/feather.min.js') }}"></script>

 <!-- Slimscroll JS -->
 <script src="{{ URL::asset('public/build/js/jquery.slimscroll.min.js') }}"></script>

 <!-- Bootstrap Core JS -->
 <script src="{{ URL::asset('public/build/js/bootstrap.bundle.min.js') }}"></script>

 <!-- Chart JS -->
 <script src="{{ URL::asset('public/build/plugins/apexchart/apexcharts.min.js') }}"></script>
 <script src="{{ URL::asset('public/build/plugins/apexchart/chart-data.js') }}"></script>

 <!-- Sweetalert 2 -->
 <script src="{{ URL::asset('public/build/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
 <script src="{{ URL::asset('public/build/plugins/sweetalert/sweetalerts.min.js') }}"></script>

 <!-- Swiper JS -->
 <script src="{{ URL::asset('public/build/plugins/swiper/swiper.min.js') }}"></script>

 <!-- FancyBox JS -->
 <script src="{{ URL::asset('public/build/plugins/fancybox/jquery.fancybox.min.js') }}"></script>

 <!-- Select2 JS -->
 <script src="{{ URL::asset('public/build/plugins/select2/js/select2.min.js') }}"></script>

 <!-- Datetimepicker JS -->
 <script src="{{ URL::asset('public/build/js/moment.min.js') }}"></script>
 <script src="{{ URL::asset('public/build/js/bootstrap-datetimepicker.min.js') }}"></script>
 <script src="{{ URL::asset('public/build/plugins/daterangepicker/daterangepicker.js') }}"></script>

 @if (Route::is(['todo']))
     <!-- Datetimepicker CSS -->
     <script src="{{ URL::asset('public/build/plugins/moment/moment.min.js') }}"></script>
 @endif

 <!-- Bootstrap Tagsinput JS -->
 <script src="{{ URL::asset('public/build/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>

 <!-- Datatable JS -->
 <script src="{{ URL::asset('public/build/js/jquery.dataTables.min.js') }}"></script>
 <script src="{{ URL::asset('public/build/js/dataTables.bootstrap5.min.js') }}"></script>

 <!-- Summernote JS -->
 <script src="{{ URL::asset('public/build/plugins/summernote/summernote-bs4.min.js') }}"></script>

 <!-- Mobile Input -->
 <script src="{{ URL::asset('public/build/plugins/intltelinput/js/intlTelInput.js') }}"></script>

 <script src="{{ URL::asset('public/build/js/plyr-js.js') }}"></script>

 <!-- Owl Carousel -->
 <script src="{{ URL::asset('public/build/js/owl.carousel.min.js') }}"></script>

 <!-- Sticky-sidebar -->
 <script src="{{ URL::asset('public/build/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
 <script src="{{ URL::asset('public/build/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

 @if (Route::is(['store.sales-dashboard']))
     <!-- Map JS -->
     <script src="{{ URL::asset('public/build/plugins/jvectormap/jquery-jvectormap-2.0.5.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/jvectormap/jquery-jvectormap-world-mill.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/jvectormap/jquery-jvectormap-ru-mill.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/jvectormap/jquery-jvectormap-us-aea.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/jvectormap/jquery-jvectormap-uk_countries-mill.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/jvectormap/jquery-jvectormap-in-mill.js') }}"></script>
     <script src="{{ URL::asset('public/build/js/jvectormap.js') }}"></script>
 @endif

 @if (Route::is('store.calendar'))
     <!-- Full Calendar JS -->
     <script src="{{ URL::asset('public/build/js/jquery-ui.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/fullcalendar/jquery.fullcalendar.js') }}"></script>
 @endif

 @if (Route::is(['store.ui-clipboard']))
     <!-- Clipboard JS -->
     <script src="{{ URL::asset('public/build/plugins/clipboard/clipboard.min.js') }}"></script>
 @endif

 @if (Route::is(['store.ui-drag-drop']))
     <!-- Dragula JS -->
     <script src="{{ URL::asset('public/build/plugins/dragula/js/dragula.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/dragula/js/drag-drop.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/dragula/js/draggable-cards.js') }}"></script>
 @endif

 @if (Route::is(['store.ui-rating']))
     <!-- Rater JS -->
     <script src="{{ URL::asset('public/build/plugins/rater-js/index.js') }}"></script>
     <!-- Internal Ratings JS -->
     <script src="{{ URL::asset('public/build/js/ratings.js') }}"></script>
 @endif

 @if (Route::is(['store.ui-counter']))
     <!-- Stickynote JS -->
     <script src="{{ URL::asset('public/build/plugins/countup/jquery.counterup.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/countup/jquery.waypoints.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/countup/jquery.missofis-countdown.js') }}"></script>
 @endif

 @if (Route::is(['store.ui-text-editor']))
     <!-- Summernote JS -->
     <script src="{{ URL::asset('public/build/plugins/summernote/summernote-bs4.min.js') }}"></script>
 @endif

 @if (Route::is(['store.ui-rangeslider']))
     <!-- Rangeslider JS -->
     <script src="{{ URL::asset('public/build/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/ion-rangeslider/js/custom-rangeslider.js') }}"></script>
 @endif

 @if (Route::is(['store.form-mask']))
     <!-- Mask JS -->
     <script src="{{ URL::asset('public/build/js/jquery.maskedinput.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/js/mask.js') }}"></script>
 @endif

 @if (Route::is(['store.ui-scrollbar']))
     <!-- Plyr JS -->
     <script src="{{ URL::asset('public/build/plugins/scrollbar/scrollbar.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/scrollbar/custom-scroll.js') }}"></script>
 @endif

 @if (Route::is(['store.ui-stickynote']))
     <!-- Stickynote JS -->
     <script src="{{ URL::asset('public/build/js/jquery-ui.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/stickynote/sticky.js') }}"></script>
 @endif

 @if (Route::is(['store.ui-toasts']))
     <!-- Mask JS -->
     <script src="{{ URL::asset('public/build/plugins/toastr/toastr.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/toastr/toastr.js') }}"></script>
 @endif

 @if (Route::is(['store.ui-lightbox']))
     <script src="{{ URL::asset('public/build/plugins/lightbox/glightbox.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/lightbox/lightbox.js') }}"></script>
 @endif

 @if (Route::is(['store.chart-c3']))
     <!-- Chart JS -->
     <script src="{{ URL::asset('public/build/plugins/c3-chart/d3.v5.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/c3-chart/c3.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/c3-chart/chart-data.js') }}"></script>
 @endif

 @if (Route::is(['store.chart-flot']))
     <!-- Chart JS -->
     <script src="{{ URL::asset('public/build/plugins/flot/jquery.flot.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/flot/jquery.flot.fillbetween.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/flot/jquery.flot.pie.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/flot/chart-data.js') }}"></script>
 @endif

 @if (Route::is(['store.lightbox']))
     <!-- lightbox JS -->
     <script src="{{ URL::asset('public/build/plugins/lightbox/glightbox.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/lightbox/lightbox.js') }}"></script>
 @endif

 @if (Route::is(['store.chart-js']))
     <!-- Chart JS -->
     <script src="{{ URL::asset('public/build/plugins/chartjs/chart.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/chartjs/chart-data.js') }}"></script>
 @endif

 @if (Route::is(['store.chart-morris']))
     <!-- Chart JS -->
     <script src="{{ URL::asset('public/build/plugins/morris/raphael-min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/morris/morris.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/morris/chart-data.js') }}"></script>
 @endif

 @if (Route::is(['store.chart-peity']))
     <!-- Chart JS -->
     <script src="{{ URL::asset('public/build/plugins/peity/jquery.peity.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/peity/chart-data.js') }}"></script>
 @endif

 @if (Route::is(['store.form-select2']))
     <script src="{{ URL::asset('public/build/js/custom-select2.js') }}"></script>
 @endif

 @if (Route::is(['store.form-fileupload']))
     <!-- Fileupload JS -->
     <script src="{{ URL::asset('public/build/plugins/fileupload/fileupload.min.js') }}"></script>
 @endif

 @if (Route::is(['store.form-wizard']))
     <!-- Wizard JS -->
     <script src="{{ URL::asset('public/build/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/twitter-bootstrap-wizard/prettify.js') }}"></script>
     <script src="{{ URL::asset('public/build/plugins/twitter-bootstrap-wizard/form-wizard.js') }}"></script>
 @endif

 <!-- Custom JS -->
 <script src="{{ URL::asset('public/build/js/theme-script.js') }}"></script>
 <script src="{{ URL::asset('public/build/js/script.js') }}"></script>

 <script>
    $(document).on('change', '.changeStore', function(){
        var id = $('.changeStore').val();
        var url = '{{ route('store.changeStore',["id" => ":id"]) }}';
        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            async:false,
            success: function(data)
            {
                console.log(data);
                location.reload();
            }
        });
    })
 </script>