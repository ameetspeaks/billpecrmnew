<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> CentralLibrary Product <?php $__env->endSlot(); ?>
<?php $__env->slot('subTitle'); ?> CentralLibrary list <?php $__env->endSlot(); ?>
<?php $__env->slot('content'); ?>

<div class="text-right col-12">
   
  
</div>
<div class="text-right col-12 d-flex justify-end gap-1">
    <button type="button" class="btn btn-outline-secondary btn-fw text-capitalize" data-toggle="modal" data-target="#exampleModal">Export By Module</button>

    <a href="<?php echo e(route('admin.centralLibrary.add')); ?>">
        <button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Add product</button>
    </a>
    <form action="#" class="" method="POST" name="importFileForm" id="importFileForm" style="position: relative" enctype='multipart/form-data'>
       <?php echo csrf_field(); ?>

       <div style=" z-index: 99999;position: absolute;width: 100%;height: 100%;display:none" id="hideSpinner">
           <div class="spinner-grow text-primary " style=" position: absolute;left: 33%;top: 12%;"></div>
       </div>

       <input type="file" name="productExcel" id="productExcel" class="form-control" style="visibility: hidden;position: absolute;width:0%">
       <button type="button" id="productExcelBtn" class="btn btn-outline-secondary text-white bg-blue-700 btn-fw">Import</button>
    </form>
    <a href="<?php echo e(route('admin.centralLibrary.export')); ?>"><button type="button" class="btn btn-outline-secondary btn-fw  text-capitalize">Export</button></a>
</div>

<!-- Modal Export BY Module -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Export By Module</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="row forms-sample w-full" action="<?php echo e(route('admin.centralLibrary.exportByModule')); ?>" name="moduleData" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group col-md-6 col-12 err_module">
                    <label style="font-weight:bold">Module</label>
                    <select class="form-control h-11 cursor-pointer module select" id="module" name="module_id">
                        <option value="">Select Module</option>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($module->id); ?>"><?php echo e($module->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <span class="text-xs text-red-500 mt-2 errmsg_module"></span>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Export</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
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
                <th> Image </th>
                <th> Name </th>
                <th> Barcode </th>
                <th> Unit</th>
                <th> Qtn</th>
                <th> Status </th>
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
            ajax: "<?php echo e(route('admin.centralLibrary.getDatatable')); ?>",
            
            "columns": [
                {
                    "data": "product_image",
                    "render": function(data, type, row) {
                        console.log(row)
                        if(row.product_image){
                            return ' <img src="'+row.product_image+'" alt="Image"> ' ;
                        }else{
                            var firstLetter = row.product_name.slice(0,1);
                            return '<button type="button" class="btn btn-light">'+firstLetter+'</button>';
                        }
                    },
                },
                {
                    "data": "product_name",
                },
                {
                    "data": "barcode",
                },
                {
                    "data": "unit",
                },
                {
                    "data": "quantity",
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        console.log(row)
                        if(row.status == 1){
                            return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="centralLib" checked> <span class="slider round"></span> </label> ' ;
                        }else{
                            return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="centralLib"> <span class="slider round"></span> </label> ' ;
                        }
                    },
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        console.log(row)
                            
                        return ' <a href=" <?php echo e(url('admin/editCentralProduct')); ?>/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a> <a href="#" ><button class="btn btn-primary btn-sm" id="remove" data-id="' + data +'">Delete<button></a>';
                        
                    },
                },
               
            ],
        });
    });


    // function changestatus(id) {
    //     var statusName = $(this).attr('data-statusName');
    //     alert(id)
    //     alert(statusName)
        
    //     var url = '<?php echo e(route('admin.centralLibrary.changeStatus',["id" => ":id"])); ?>';
    //     url = url.replace(':id', id);
    //     $.ajax({
    //         type: 'GET',
    //         url: url,
    //         dataSrc: "",
    //         success: function(data)
    //         {
    //             $('.table').DataTable().ajax.reload();
    //         }
    //     });
    // }

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

                var url = '<?php echo e(route('admin.centralLibrary.delete',["id" => ":id"])); ?>';
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

    // Select file for Import Excel file

    $('#productExcelBtn').click(function(){
            $("#productExcel").click();
    });

    $("#productExcel").change(function(){
            $("#importFileForm").submit();
    });

    $("#importFileForm").submit(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = document.importFileForm;
        console.log(form);
        var formData = new FormData(form);
        var url = '<?php echo e(route('admin.centralLibrary.import')); ?>';
        $("#hideSpinner").show();
        $.ajax({
            type: 'POST',
            url: url,
            processData: false,
            contentType: false,
            dataType: 'json',
            data: formData,
            dataSrc: "",
            complete: function(data)
            {
                $("#hideSpinner").hide();
                $("#importFileForm").trigger('reset');
                $('#showExportError').empty();
            },
            success: function(data)
            {
                console.log("yes");
                console.log(data);
                if(data.status==0){
                    $(".errmsg_productExcel").text(data.error1.productExcel[0]);
                }else if(data.status==1){
                    $(".errmsg_productExcel").text("");
                    $(".successmsg_productExcel").text(data.success);
                    $('.table').DataTable().ajax.reload();
                }else{
                    $(".errmsg_productExcel").text(data.error);
                }

            },error:function(error){
                console.log("no");
                console.log(error);
                console.log(error.responseJSON);
                if(error.responseJSON.errors!=undefined){
                    $(".errmsg_productExcel").text(error.responseJSON.errors[0][0]);
                }else{

                    $(".errmsg_productExcel").text(error.statusText);

                }

                $(".successmsg_productExcel").text("");

            }

        }); //End Ajax

    }) //End Submit Form

</script>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/centralLibrary/index.blade.php ENDPATH**/ ?>