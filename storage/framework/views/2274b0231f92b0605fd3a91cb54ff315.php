<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> role <?php $__env->endSlot(); ?>
<?php $__env->slot('subTitle'); ?> role list <?php $__env->endSlot(); ?>
<?php $__env->slot('content'); ?>
<div class="text-right col-12">
  
    <a href="<?php echo e(route('admin.role.add')); ?>">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Role</button>
    </a>

</div>
<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Name </th>
                <th> Action </th>
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
              ajax: "<?php echo e(route('admin.role.getDatatable')); ?>",
            //   columns: [
            //       {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            //       {data: 'name', name: 'name'},
            //       {data: 'action', name: 'action'},
            //   ]

            "columns": [
                {
                    "data": "name",
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                     
                        return ' <a href=" <?php echo e(url('admin/editRole')); ?>/' + data +'" " class="text-primary d-inline-block edit-item-btn"><button class="btn btn-primary btn-sm">Edit<button></a>';

                    },
                },
            ],

          });
        });
</script>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/role/index.blade.php ENDPATH**/ ?>