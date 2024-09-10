<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> Edit Sub Zone <?php $__env->endSlot(); ?>

<?php $__env->slot('subTitle'); ?> edit sub Zone detail <?php $__env->endSlot(); ?>
<?php $__env->slot('content'); ?>
<form class="row forms-sample w-full" action="<?php echo e(route('admin.subzone.update')); ?>" name="moduleData" method="POST">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="subzone_id" value="<?php echo e($subZone->id); ?>">
    <div class="form-group col-6 err_zone">
        <label>Zone</label>
        <select class="form-control" name="zone_id" required>
            <option value="">Select Zone</option>
            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($zone->id); ?>" <?php echo e($subZone->zone_id == $zone->id ? 'selected' : ''); ?>><?php echo e($zone->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <span class="text-xs text-red-500 mt-2 err_zone"></span>
    </div>
    <div class="form-group col-6 err_name">
        <label>Sub Zone Name</label>
        <input type="text" name="name" class="form-control" placeholder="Sub Zone Name" value="<?php echo e($subZone->name); ?>" required>
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-6 err_zone">
        <label>Store</label>
        <select class="form-control select" name="store_id[]" multiple required>
            <?php 
                $storesarray = explode(',',$subZone->store_id);
            ?>
            <option value="">Select Zone</option>
            <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($store->id); ?>" <?php echo e(in_array($store->id,$storesarray) ? "selected" : ""); ?>><?php echo e($store->shop_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <span class="text-xs text-red-500 mt-2 err_zone"></span>
    </div>
    
    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="<?php echo e(route('admin.subzone.index')); ?>"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
<?php $__env->endSlot(); ?>
<?php $__env->slot('script'); ?>
<script>
    $('.select').select2({ placeholder: "Select Store" }).trigger('change');
</script>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/subzone/edit.blade.php ENDPATH**/ ?>