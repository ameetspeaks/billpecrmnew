<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-center text-sm-left d-block d-sm-inline-block">
        
         <a href="<?php echo e(route('admin.dashboard')); ?>" target="_blank"><?php echo e(\App\Models\Setting::where('type','company_address')->first()->value ?? ''); ?></a> 
        </span> 

        <span class="text-center text-sm-left d-block d-sm-inline-block">
            <a href="<?php echo e(route('admin.dashboard')); ?>" target="_blank"><?php echo e(\App\Models\Setting::where('type','company_footer_text')->first()->value ?? ''); ?></a> 
        </span> 
    </div>
</footer>
<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/layouts/footer.blade.php ENDPATH**/ ?>