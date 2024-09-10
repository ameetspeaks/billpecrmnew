<?php if(session()->has('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session()->get('error')); ?>

        </div>
    <?php endif; ?>
    <?php if(session()->has('message')): ?>
        <div class="alert alert-success">
            <?php echo e(session()->get('message')); ?>

        </div>
    <?php endif; ?><?php /**PATH /home4/billp5kj/public_html/resources/views/store/storeAdmin/layout/partials/session.blade.php ENDPATH**/ ?>