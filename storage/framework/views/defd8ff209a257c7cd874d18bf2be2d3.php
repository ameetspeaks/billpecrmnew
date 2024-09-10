<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> permissions <?php $__env->endSlot(); ?>
<?php $__env->slot('subTitle'); ?> permissions list <?php $__env->endSlot(); ?>
<?php $__env->slot('content'); ?>
<div class="text-right col-12">
    <a href="<?php echo e(route('admin.permission.add')); ?>">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Permission</button>
    </a>
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Name </th>
            </tr>
        </thead>
        <tbody>
          
        </tbody>
    </table>
</div>
<?php $__env->endSlot(); ?>
<?php $__env->slot('script'); ?>
<script type="text/javascript">
    $(function () {
          var table = $('#myTable').DataTable({
              processing: true,
              serverSide: true,
              ajax: "<?php echo e(route('admin.permission.getDatatable')); ?>",
                "columns": [
                    {
                        "data": "name",
                    },
                ],

          });
        });
</script>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/permission/index.blade.php ENDPATH**/ ?>