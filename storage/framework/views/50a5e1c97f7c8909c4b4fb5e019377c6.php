<!-- Your Blade View Code -->
<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> Paid User Detail <?php $__env->endSlot(); ?>
<?php $__env->slot('subTitle'); ?> Paid User Details <?php $__env->endSlot(); ?>
<?php $__env->slot('content'); ?>
<div class="text-right col-12">
  
    <a href="<?php echo e(route('admin.exportPaidUser')); ?>">
        <button type="button" class="btn btn-outline-secondary btn-fw">Export</button>
    </a>

</div>

    <div class="table-responsive mt-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> User Name </th>
                    <th> User Phone </th>
                    <th> Shop Name </th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
    </div>
<?php $__env->endSlot(); ?>
<?php $__env->slot('script'); ?>
<script>
    var table;

    $(document).ready(function () {
        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: "<?php echo e(route('admin.totalPaidUser')); ?>",
            },
          
            "columns": [
                {
                    "data": "user.name",
                },
                {
                    "data": "user.whatsapp_no",
                },
                {
                    "data": "shop_name",
                },
            ],
        });
    });
</script>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/totalPaidUser.blade.php ENDPATH**/ ?>