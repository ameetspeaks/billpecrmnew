<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> Order <?php $__env->endSlot(); ?>
<?php $__env->slot('subTitle'); ?> Order list <?php $__env->endSlot(); ?>
<?php $__env->slot('content'); ?>


<div class="text-right col-12">
    
    
</div>

<div class="text-right col-12">
 <span class="text-xs text-red-500 mt-2 errmsg_productExcel"></span>
 <div>
    <ul id="showExportError">
        <?php if($errors->any()): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="text-danger"><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </ul>
 </div>
</div>

<div class="text-right col-12">
    <span class="text-xs text-green-500 mt-2 successmsg_productExcel"></span>
</div>

<div class="table-responsive mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th> Order Id </th>
                <th> Order Date </th>
                <th> Customer Information</th>
                <th> Store </th>
                <th> Total Amount </th>
                <th> Order Status </th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<?php $__env->endSlot(); ?>
<?php $__env->slot('script'); ?>
<script>

    $(function () {
        var table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: "<?php echo e(route('admin.order.allOrder')); ?>",

            "columns": [
                {
                    "data": "order_number",
                },
                {
                    "data": "date",
                },
                {
                    "data": "customer.name",
                },
                {
                    "data": "store.shop_name",
                },
                {
                    "data": "total_amount",
                },
                {
                    "data": "order_status",
                    "render": function(data, type, row) {
                        console.log(row)
                        return ' <button class="btn btn-primary btn-sm">'+row.order_status.name+'<button> ';
                    },
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        console.log(row)

                        // return ' <ul>  <li ><a href=" <?php echo e(url('admin/editProduct')); ?>/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a></li>  <li><a href="#" > </ul>';
                        return ' <ul>  <li ><a href=" <?php echo e(url('admin/ViewOrder')); ?>/' + data +'" " ><button class="btn btn-success btn-sm">View<button></a></li>  <li><a href="#" > </ul>';

                    },
                },

            ],
        });
    });


    //remove product
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

                var url = '<?php echo e(route('admin.product.delete',["id" => ":id"])); ?>';
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

    //change status
    $(document).on('click','.changeStatus', function(){
        var id = $(this).attr('data-id');
        var statusName = $(this).attr('data-statusName');

        $.ajax({
                url: "<?php echo e(route('admin.centralLibrary.changeStatus')); ?>",
                method: 'post',
                data: { "_token" : "<?php echo e(csrf_token()); ?>", 'id': id , 'statusName': statusName},
                success: function(data){
                   console.log(data)
                   $('.table').DataTable().ajax.reload();
                }
        });

    })

</script>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/order/allOrder.blade.php ENDPATH**/ ?>