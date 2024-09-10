<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> Activity <?php $__env->endSlot(); ?>
<?php $__env->slot('subTitle'); ?> Activity list <?php $__env->endSlot(); ?>
<?php $__env->slot('content'); ?>

<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Action </th>
                <th> Message </th>
                <th> Created AT </th>
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
              order: [],
              ajax: "<?php echo e(route('admin.activity')); ?>",
            //   columns: [
            //       {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            //       {data: 'name', name: 'name'},
            //       {data: 'action', name: 'action'},
            //   ]

            "columns": [
                {
                    "data": "action",
                },
                {
                    "data": "message",
                },
                {
                   "data": "datecurrent",
                },
            ],

          });
        });
</script>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/activity.blade.php ENDPATH**/ ?>