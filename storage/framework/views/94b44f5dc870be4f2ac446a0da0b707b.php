<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> Add Customer Coupan <?php $__env->endSlot(); ?>

<?php $__env->slot('subTitle'); ?> add Customer Coupan detail <?php $__env->endSlot(); ?>
<?php $__env->slot('content'); ?>



<form class="row forms-sample w-full" action="<?php echo e(route('admin.charges.store')); ?>"  method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="form-group col-6  zone">
        <label>Zone</label>
        <select class="form-control select selectZone" name="zone_id" id="zone_id" required>
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

    <div class="form-group col-6 err_name">
        <label>Name</label>
        <input type="text" name="name" class="form-control" placeholder="Name" required>
        <span class="text-xs text-red-500 mt-2 err_name"></span>
    </div>

    <div class="form-group col-6 err_amount">
        <label>Amount</label>
        <input type="text" name="amount" class="form-control" placeholder="Amount" required>
        <span class="text-xs text-red-500 mt-2 err_amount"></span>
    </div>

    <div class="form-group col-6 err_minimum_cart_value">
        <label>Minimum Cart Value</label>
        <input type="text" name="minimum_cart_value" class="form-control" placeholder="Minimum Cart Value" required>
        <span class="text-xs text-red-500 mt-2 err_minimum_cart_value"></span>
    </div>

    <div class="form-group col-6 err_start_time">
        <label>Start Time</label>
        <input type="time" name="start_time" class="form-control" placeholder="Start Time">
        <span class="text-xs text-red-500 mt-2 err_start_time"></span>
    </div>

    <div class="form-group col-6 err_end_time">
        <label>End Time</label>
        <input type="time" name="end_time" class="form-control" placeholder="End Time">
        <span class="text-xs text-red-500 mt-2 err_end_time"></span>
    </div>

    <div class="form-group col-6 err_occurring">
        <label>Occurring</label>
        <select class="form-control" name="occurring" id="occurring">
            <option value="">Select Occurring</option>
            <option value="once">Once</option>
            <option value="daily">Daily</option>
            <option value="permanent">permanent</option>
        </select>
    </div>

    <div class="form-group col-6">
        <label><b>Image</b></label>
        <input type="file" name="image"  class="form-control" id="changeImg">
        <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
        <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="ItemImg2" src="<?php echo e(asset('public/admin/images/default_image.png')); ?>" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>

    <div class="mt-4 col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="<?php echo e(route('admin.charges.index')); ?>"><div class="btn btn-light">Cancel</div></a>
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

</script>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/charges/add.blade.php ENDPATH**/ ?>