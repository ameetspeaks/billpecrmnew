<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> Update Role <?php $__env->endSlot(); ?>

<?php $__env->slot('subTitle'); ?> Update Role detail <?php $__env->endSlot(); ?>
<?php $__env->slot('content'); ?>
<form class="row forms-sample w-full" action="<?php echo e(route('admin.role.update')); ?>" name="moduleData" method="POST">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="roleID" value="<?php echo e($role->id); ?>">
    <div class="form-group col-6 err_name">
        <label>Role Name</label>
        <input type="text" name="name" class="form-control" placeholder="Role Name" value="<?php echo e($role->name); ?>">
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-6">
        <label>Permissions</label><br>

        <?php $__currentLoopData = $permissions['allPermissionsLists']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(in_array($permission->id, $permissions['rolePermissions'])): ?>
            <input type="checkbox" name="permissions[]" value="<?php echo e($permission->id); ?>" checked>
            <lable><?php echo e($permission->name); ?></lable>
            <?php else: ?>
            <input type="checkbox" name="permissions[]" value="<?php echo e($permission->id); ?>">
            <lable><?php echo e($permission->name); ?></lable>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
    </div>



    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="<?php echo e(route('admin.role.index')); ?>"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
<?php $__env->endSlot(); ?>
<?php $__env->slot('script'); ?>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/role/edit.blade.php ENDPATH**/ ?>