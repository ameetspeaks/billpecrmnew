<?php $__env->startSection('content'); ?>
    <div class="row  align-items-center mb-4">
        <div class="col-sm-6">
            <h3 class="mb-0 font-weight-bold text-2xl text-capitalize"><?php echo e($title); ?></h3>
        </div>
        <div class="col-sm-6">
            
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h4 class="card-title mb-3"><?php echo e($subTitle); ?></h4>
                    </div>
                    <div class="row col-12 m-0">
                        <?php echo e($content); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
 
<?php echo e($script); ?>

<?php $__env->stopPush(); ?>


<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/billp5kj/public_html/resources/views/admin/component.blade.php ENDPATH**/ ?>