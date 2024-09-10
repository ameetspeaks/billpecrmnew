<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> Add Coupan <?php $__env->endSlot(); ?>

<?php $__env->slot('subTitle'); ?> add Coupan detail <?php $__env->endSlot(); ?>
<?php $__env->slot('content'); ?>

<form class="row forms-sample w-full" action="<?php echo e(route('admin.coupan.store')); ?>"  method="POST">
    <?php echo csrf_field(); ?>
    <div class="form-group col-4 err_name">
        <label>Coupan Name</label>
        <input type="text" name="name" class="form-control" placeholder="Coupan Name" required>
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-4 err_code">
        <label>Coupan Code</label>
        <input type="text" name="code" class="form-control" placeholder="Coupan Code" required>
        <span class="text-xs text-red-500 mt-2 errmsg_code"></span>
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

    <div class="form-group col-4 err_minimum_purchase">
        <label>Minimum Purchase</label>
        <input type="number" name="minimum_purchase" class="form-control" placeholder="Minimum Purchase" required>
        <span class="text-xs text-red-500 mt-2 errmsg_minimum_purchase"></span>
    </div>

    <div class="form-group col-md-4 col-12 err_package">
        <label for="packageSelect">Select Package:</label>
        <select class="form-control form-group h-11" id="packageSelect" name="package">
            <option value="all">All</option>
            <option value="trial">Trial</option>
            <option value="paid">Paid</option>
        </select>
    </div>

    <div class="form-group col-md-4 col-12 err_store">
        <label for="packageSelect">Select Store:</label>
        <select class="form-control select" name="selected_stores[]" id="store" multiple>
            <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($store->id); ?>"><?php echo e($store->shop_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="mt-4 col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="<?php echo e(route('admin.coupan.index')); ?>"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
<?php $__env->endSlot(); ?>
<?php $__env->slot('script'); ?>


<script>
    $('.select').select2({ placeholder: "Select Store" }).trigger('change');
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
</script>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/coupan/add.blade.php ENDPATH**/ ?>