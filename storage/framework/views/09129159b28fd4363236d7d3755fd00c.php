<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> Loyalty Point  <?php $__env->endSlot(); ?>
<?php $__env->slot('subTitle'); ?>Loyalty Point  list@endslot
<?php $__env->slot('content'); ?>
<div class="text-right col-12">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Role')): ?>
    <a href="<?php echo e(route('admin.loyaltypoint.add')); ?>">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Loyalty Point</button>
    </a>
    <?php endif; ?>
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Module Name </th>
                <th> 1 INR Point </th>
                <th> Maximum Point </th>
                <th> Minimun point to convert </th>
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
              order: [],
              ajax: "<?php echo e(route('admin.loyaltypoint.index')); ?>",

                "columns": [
                    {
                        "data": "module.name",
                    },
                    {
                        "data": "one_INR_point_amount",
                    },
                    {
                        "data": "min_point_per_order",
                    },
                    {
                        "data": "max_point_to_convert",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                        console.log(row)
                            return ' <ul>  <li ><a href=" <?php echo e(url('admin/editLoyalty')); ?>/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a></li>  <li><a href="#" ><button class="btn btn-primary btn-sm" id="remove" data-id="' + data +'">Delete<button></a></li> </ul>';

                        },
                    },
                ],

          });
        });

        $(document).on('click', '#remove', function(){
            var id = $(this).attr('data-id');

            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                if(result.value){

                    var url = '<?php echo e(route('admin.loyaltypoint.delete',["id" => ":id"])); ?>';
                    url = url.replace(':id', id);
                    $.ajax({
                        type: 'GET',
                        url: url,
                        success: function(data)
                        {
                            if(data.status == false){
                                Swal.fire(data.title,data.message,data.type);
                            }
                            Swal.fire(
                                "Deleted!",
                                "Deleted successfully.",
                                "success"
                            ).then(function() {
                                $('.table').DataTable().ajax.reload();
                            });
                        }
                    });

                }
            });
        })

</script>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/loyaltypoint/index.blade.php ENDPATH**/ ?>