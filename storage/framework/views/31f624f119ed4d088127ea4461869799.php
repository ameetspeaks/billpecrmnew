<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> Add Customer Coupan <?php $__env->endSlot(); ?>

<?php $__env->slot('subTitle'); ?> add Customer Coupan detail <?php $__env->endSlot(); ?>
<?php $__env->slot('content'); ?>



<form class="row forms-sample w-full" action="<?php echo e(route('admin.customerCoupan.store')); ?>"  method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="form-group col-6  zone">
        <label>Zone</label>
        <select class="form-control select selectZone" name="zone_id" id="zone_id">
            <option value="">Select Zone</option>
            <option value="all">All</option>
            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($zone->id); ?>"><?php echo e($zone->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_zone"></span>
    </div>

    <!-- <div class="form-group col-6  zone">
        <label>Sub Zone</label>
        <select class="form-control select subzones" name="subzone_id" id="subzone_id">
            <option value="">Select Sub Zone</option>
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_zone"></span>
    </div> -->

    <div class="form-group col-6  module">
        <label>Module</label>
        <select class="form-control select selectModule" name="module_id" id="module_id">
            <option value="">Select Module</option>
            <option value="all">All</option>
            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($module->id); ?>"><?php echo e($module->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_discount₹"></span>
    </div>

    <div class="form-group col-6">
        <label>Category</label>
        <select class="form-control select category" name="category_id" id="category_id">
            <option value="">Select Category</option>
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_discount₹"></span>
    </div>

    <div class="form-group col-6">
        <label>Store</label>
        <select class="form-control select store" name="store_id" >
            <option value="">Select Store</option>
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_discount₹"></span>
    </div>

    <div class="form-group col-6">
        <label><b>Image</b></label>
        <input type="file" name="image"  class="form-control" id="changeImg">
        <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
        <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="ItemImg2" src="<?php echo e(asset('public/admin/images/default_image.png')); ?>" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>

    <div class="form-group col-4 err_title">
        <label>Title</label>
        <input type="text" name="title" class="form-control" placeholder="title" required>
        <span class="text-xs text-red-500 mt-2 errmsg_title"></span>
    </div>

    <div class="form-group col-4 err_sub_heading">
        <label>Sub Heading</label>
        <input type="text" name="sub_heading" class="form-control" placeholder="Sub Heading" required>
        <span class="text-xs text-red-500 mt-2 err_sub_heading"></span>
    </div>


    <div class="form-group col-4 errmsg_discount%">
        <label>Discount</label>
        <input type="number" name="discount" class="form-control" placeholder="Discount" required>
        <span class="text-xs text-red-500 mt-2 errmsg_discount%"></span>
    </div>

    <div class="form-group col-4 errmsg_discount₹">
        <label>Discount Type</label>
        <select class="form-control" name="discountType" required>
            <option value="">Select Type</option>
            <option value="%">%</option>
            <option value="₹">₹</option>
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_discount₹"></span>
    </div>

    <div class="form-group col-4 err_start_date">
        <label>Start Date</label>
        <input type="date" name="start_date" class="form-control" placeholder="Start Date" required>
        <span class="text-xs text-red-500 mt-2 errmsg_start_date"></span>
    </div>

    <div class="form-group col-4 err_end_date">
        <label>End Date</label>
        <input type="date" name="end_date" class="form-control" placeholder="Start Date" required>
        <span class="text-xs text-red-500 mt-2 errmsg_end_date"></span>
    </div>

    <div class="form-group col-4 err_coupan_code">
        <label>Coupan Code</label>
        <input type="text" name="coupan_code" class="form-control" placeholder="Coupan Code" required>
        <span class="text-xs text-red-500 mt-2 err_coupan_code"></span>
    </div>

    <div class="form-group col-4 err_maximum_discount">
        <label>Maximum Discunt Amount</label>
        <input type="text" name="maximum_discount" class="form-control" placeholder="Maximum Discunt Amount" required>
        <span class="text-xs text-red-500 mt-2 err_maximum_discount"></span>
    </div>

    <div class="form-group col-4 err_minimum_purchase">
        <label>Minimum Purchase</label>
        <input type="number" name="minimum_purchase" class="form-control" placeholder="Minimum Purchase" required>
        <span class="text-xs text-red-500 mt-2 errmsg_minimum_purchase"></span>
    </div>

    <div class="mt-4 col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="<?php echo e(route('admin.customerCoupan.index')); ?>"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
<?php $__env->endSlot(); ?>
<?php $__env->slot('script'); ?>


<script>
    // SHOW IMAGE

    function readURL(input) {
        var image=input.files[0].size;
        if(image > 200000) {
            $('.errmsg_image').html('File size maximum 200kB.');
            $('#changeImg').val('');
            $('#ItemImg2').prop('src', null);
        }else{
            $('.errmsg_image').html('');
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#ItemImg2').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

    }

    $("#changeImg").change(function(){
        readURL(this);
    })
    // $('.module').hide();
    // $('.category').hide();

    $('.select').select2().trigger('change');
    $(document).on('change','#packageSelect', function(){
        var packageSelect = $('#packageSelect').val();

        $.ajax({
                url: '<?php echo e(route('admin.getStoreByPackage')); ?>',
                method: 'post',
                data: { "_token" : "<?php echo e(csrf_token()); ?>", 'packageSelect': packageSelect },
                success: function(data){
                    console.log(data)
                    $('#store').empty();
                    $.each(data.stores, function(index, value){
                        console.log(value)
                        store = '<option value="'+value.id+'">'+value.shop_name+'</option>'
                        $('#store').append(store);
                    })
                }
        });
    })

    $(document).on('change','.selectZone', function(){
        var zone_id = $('.selectZone').val();
        $.ajax({
                url: '<?php echo e(route('admin.customerCoupan.getSubZone')); ?>',
                method: 'post',
                data: { "_token" : "<?php echo e(csrf_token()); ?>", 'zone_id': zone_id },
                success: function(data){
                    console.log(data)
                    $('.subzones').empty();
                    subzones = '<option value="">Select Sub Zones</option>'+
                               '<option value="all">All</option>'
                    $.each(data.subzones, function(index, value){
                        subzones += '<option value="'+value.id+'">'+value.name+'</option>'
                    })
                    $('.subzones').append(subzones);

                }
        });
    })

    $(document).on('change','.selectModule', function(){
        var module_id = $('.selectModule').val();
        $.ajax({
                url: '<?php echo e(route('admin.customerCoupan.getCategoryandStore')); ?>',
                method: 'post',
                data: { "_token" : "<?php echo e(csrf_token()); ?>", 'module_id': module_id },
                success: function(data){
                    console.log(data)
                    $('.category').empty();
                    category = '<option value="">Select Category</option>'+
                               '<option value="all">All</option>'
                    $.each(data.categorys, function(index, value){
                        category += '<option value="'+value.id+'">'+value.name+'</option>'
                    })
                    $('.category').append(category);

                    $('.store').empty();
                    store = '<option value="">Select Store</option>'+
                               '<option value="all">All</option>'
                    $.each(data.stores, function(index, value){
                        store += '<option value="'+value.id+'">'+value.shop_name+'</option>'
                    })
                    $('.store').append(store);

                }
        });
    })
</script>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/customerCoupan/add.blade.php ENDPATH**/ ?>