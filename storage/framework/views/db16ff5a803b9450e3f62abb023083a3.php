<?php $page = 'edit-product'; ?>

<?php $__env->startSection('content'); ?>
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Edit Product</h4>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <div class="page-btn">
                            <a href="<?php echo e(route('store.product-list')); ?>" class="btn btn-secondary"><i data-feather="arrow-left"
                                    class="me-2"></i>Back to Product</a>
                        </div>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                data-feather="chevron-up" class="feather-chevron-up"></i></a>
                    </li>
                </ul>

            </div>
            <?php echo $__env->make('store.storeAdmin.layout.partials.session', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- /edit -->
            <form class="row forms-sample w-full" action="<?php echo e(route('store.product.update')); ?>"  method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="productId" value="<?php echo e($package->id); ?>">
                <input type="hidden" name="oldImage" value="<?php echo e($package->product_image); ?>">
                <input type="hidden" class="catid"  value="<?php echo e($package->category); ?>">
                <input type="hidden" class="subcatid"  value="<?php echo e($package->subCategory_id); ?>">
                <input type="hidden" class="moduleid"  value="<?php echo e($package->module_id); ?>">
                <input type="hidden" class="package_size"  value="<?php echo e($package->package_size); ?>">
                <!-- <input type="hidden" class="unitName"  value="<?php echo e($package->unit); ?>"> -->



                <input type="hidden" class="module_id" name="module_id">

                <div class="form-group col-md-6 col-12 err_store">
                    <label style="font-weight:bold">Store</label>
                    <input type="hidden" name="store_id" id="store_id">
                    <select class="form-control h-11 cursor-pointer" id="changeStore" name="store_id" disabled>
                        <option data-module_id="" value="">Select Store</option>
                        <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option data-module_id="<?php echo e($store->module_id); ?>" value="<?php echo e($store->id); ?>" <?php echo e($package->store_id == $store->id ? 'selected' : ''); ?>><?php echo e($store->shop_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <span class="text-xs text-red-500 mt-2 errmsg_store"></span>
                </div>

                <div class="form-group col-md-6 col-12 err_module">
                    <label style="font-weight:bold">Module</label>
                    <input type="hidden" name="module_id" id="module_id">
                    <select class="form-control h-11 cursor-pointer module" id="module" onchange="moduleChange()" disabled>
                        <option value="">Select Module</option>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($module->id); ?>"><?php echo e($module->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <span class="text-xs text-red-500 mt-2 errmsg_module"></span>
                </div>

                <h4 class="card-title mb-6 col-12 p-0">Products</h4>
                <div class="form-group col-md-6 col-12 err_name">
                    <label>Product Name</label>
                    <input class="form-control" type="text" id="realName" name="name" value="<?php echo e($package->product_name); ?>">
                    
                    <input class="form-control" type="hidden" id="realImgName" name="realImgName">
                
                    <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
                </div>

                <div class="form-group col-md-6 col-12 err_barcode">
                    <label style="font-weight:bold">BarCode</label>
                    <input type="text" class="form-control" name="barcode" placeholder="Enter barcode" value="<?php echo e($package->barcode); ?>" readonly>
                    <span class="text-xs text-red-500 mt-2 errmsg_barcode"></span>
                </div>

                <div class="form-group col-md-6 col-12 err_category">
                    <label style="font-weight:bold">Category</label>
                    <!-- <select id="category"   class="form-control h-11 cursor-pointer category" name="category_id" onchange="categoryChange()" is="ms-dropdown" style="background:white !important;width:100%" >
                        <option value="">Select Category</option>
                    </select>
                    <span class="text-xs text-red-500 mt-2 errmsg_category"></span> -->
                    <select  id="category" class="form-control h-11 cursor-pointer category" name="category_id"  onchange="categoryChange()" style="background:white !important;width:100%" >
                        <option value="">Select Category</option>
                    </select>
                </div>

                <div class="form-group col-md-6 col-12 err_subcategory">
                    <label style="font-weight:bold">Sub Category</label>
                    <select id="subcategory"   class="form-control h-11 cursor-pointer subcategory" name="subcategory_id"  style="background:white !important;width:100%" >
                        <option value="">Select SubCategory</option>
                    </select>
                    <span class="text-xs text-red-500 mt-2 errmsg_subcategory"></span>
                </div>

                


                <!-- <div class="form-group col-md-3 col-12 err_package_weight">
                    <label style="font-weight:bold">Package Weight</label>
                    <input type="text" class="form-control" name="package_weight" value="<?php echo e($package->package_weight); ?>">
                    <span class="text-xs text-red-500 mt-2 errmsg_package_weight"></span>
                </div> -->
                <!-- <div class="form-group col-md-3 col-12 err_package_weight">
                    <label style="font-weight:bold">Package Size</label>
                    <select   class="form-control h-11 cursor-pointer package_size" name="package_size" style="background:white !important;width:100%" >
                        <option value="">Select Package Size</option>
                        <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($attribute->name); ?>" data-id="<?php echo e($attribute->id); ?>" <?php echo e($package->package_size == $attribute->name ? 'selected' : ''); ?>><?php echo e($attribute->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div> -->
                
                <div class="form-group col-md-6 col-12 err_qtn">
                    <label style="font-weight:bold">Qtn</label>
                    <input type="text" class="form-control" name="qtn" value="<?php echo e($package->quantity); ?>">
                    <span class="text-xs text-red-500 mt-2 errmsg_qtn"></span>
                </div>
                
                <div class="form-group col-md-6 col-12 err_unit">
                    <label style="font-weight:bold">Unit</label>
                    <select   class="form-control h-11 cursor-pointer unit" name="unit" style="background:white !important;width:100%" >
                        <option value="">Select Unit</option>
                        <?php $__currentLoopData = $unit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $units): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($units->name); ?>" <?php echo e($package->unit == $units->name ? 'selected' : ''); ?>><?php echo e($units->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <span class="text-xs text-red-500 mt-2 errmsg_unit"></span>
                </div>

                <div class="form-group col-6">
                    <label><b>Image</b></label>
                    <input type="file" name="productImage"  class="form-control" id="changeImg">
                    <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
                    <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
                        <img id="ItemImg2" src="<?php echo e(asset('public/admin/images/default_image.png')); ?>" alt="your image" class="rounded-lg" style="width: 100%" />
                    </div>
                </div>

                <h4 class="card-title mb-6 col-12 p-0">MRP Includes GST (PRICE per Unit)</h4>
                <div class="form-group col-md-4 col-12 err_mrp">
                    <label style="font-weight:bold">MRP</label>
                    <input type="text" class="form-control" name="mrp" value="<?php echo e($package->mrp); ?>">
                    <span class="text-xs text-red-500 mt-2 errmsg_mrp"></span>
                </div>
                <?php if($currentStore->store_type == 1 || $currentStore->store_type == 3): ?>
                <div class="form-group col-md-4 col-12 err_retail">
                    <label style="font-weight:bold">Retails Price</label>
                    <input type="text" class="form-control" name="retail_price" value="<?php echo e($package->retail_price); ?>">
                </div>
                <?php endif; ?>
                <?php if($currentStore->store_type == 2 || $currentStore->store_type == 3): ?>
                <div class="form-group col-md-4 col-12 err_wholesale_price">
                    <label style="font-weight:bold">Wholesale Price</label>
                    <input type="text" class="form-control" name="wholesale_price" value="<?php echo e($package->wholesale_price); ?>">
                    <span class="text-xs text-red-500 mt-2 errmsg_wholesale_price"></span>
                </div>
                <?php endif; ?>
                <div class="form-group col-md-4 col-12 err_purchase_price">
                    <label style="font-weight:bold">Purchase Price</label>
                    <input type="text" class="form-control" name="purchase_price" value="<?php echo e($package->purchase_price); ?>">
                    <span class="text-xs text-red-500 mt-2 errmsg_purchase_price"></span>
                </div>
                <div class="form-group col-md-4 col-12 err_member">
                    <label style="font-weight:bold">Member Price</label>
                    <input type="text" class="form-control" name="member_price" value="<?php echo e($package->members_price); ?>">
                </div>


                
                <h4 class="card-title mb-6 col-12 p-0">Stock</h4>
                <div class="form-group col-md-6 col-12 err_stock">
                    <label><b>Total stock</b></label>
                    <input type="text" class="form-control" name="stock" value="<?php echo e($package->stock); ?>">
                    <span class="text-xs text-red-500 mt-2 errmsg_stock"></span>
                </div>
                <div class="form-group col-md-6 col-12 err_low_stock">
                    <label><b>Low stock</b></label>
                    <input type="text" class="form-control" name="low_stock" value="<?php echo e($package->low_stock); ?>">
                    <span class="text-xs text-red-500 mt-2 errmsg_low_stock"></span>
                </div>

                <div class="form-group col-md-6 col-12 err_tag">
                    <label ><b>Tag</b></label>
                    <input type="text" class="form-control" placeholder="Tag1, Tag2, Tag3" name="tag" value="<?php echo e($package->tags); ?>">
                    <span class="text-xs text-red-500 mt-2 errmsg_tag"></span>
                </div>

                <div class="form-group col-md-6 col-12 err_expiry_date">
                    <label style="font-weight:bold">Expiry Date</label>
                    <input type="date" class="form-control" name="expiry_date" value="<?php echo e($package->expiry); ?>">
                    <span class="text-xs text-red-500 mt-2 errmsg_expiry_date"></span>
                </div>


                <div class="form-group col-md-6 col-12 err_brand">
                    <label ><b>Brand</b></label>
                    <input type="text" class="form-control" placeholder="Brand" name="brand" value="<?php echo e($package->brand); ?>">
                </div>

                <div class="form-group col-md-6 col-12 err_expiry_color">
                    <label style="font-weight:bold">Color</label>
                    <input type="text" class="form-control" placeholder="Enter color" name="color" value="<?php echo e($package->color); ?>">
                </div>

                <h4 class="card-title mb-6 col-12 p-0">Tax</h4>
                <div class="form-group col-md-4 col-12 err_hsn">
                    <label style="font-weight:bold">Hsn</label>
                    <input type="text" class="form-control" name="hsn" value="<?php echo e($package->hsn); ?>">
                </div>
                <div class="form-group col-md-4 col-12 err_gst">
                    <label><b>GST</b></label>
                    <input type="number" class="form-control" name="gst" value="<?php echo e($package->gst); ?>">
                    <span class="text-xs text-red-500 mt-2 errmsg_gst"></span>
                </div>
                <div class="form-group col-md-4 col-12 err_CESS">
                    <label><b>CESS</b></label>
                    <input type="number" class="form-control" name="CESS" value="<?php echo e($package->cess); ?>">
                    <span class="text-xs text-red-500 mt-2 errmsg_CESS"></span>
                </div>
                
                <div class="mt-4 col-12">
                    <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="">Submit</button>

                </div>
            </form>
            <!-- /edit -->

        </div>
    </div>


    <script>

        // Change Store
        $(document).ready(function(){
            var estore_id=$("#changeStore").val();
            var module_id=$(".moduleid").val();
        
            if(module_id==''){
                $(`#module option`).prop("selected",false);
                return;
            }
            $(`#module option[value="${module_id}"]`).prop("selected",true);
            $("#module").change();
            $('#module_id').val(module_id);
            var store_id = $('#changeStore').val();
            $('#store_id').val(estore_id);
            
            var id = $('.module').val();
            var catid = $('.catid').val();
            var subcatid = $('.subcatid').val();
            var url = '<?php echo e(route('store.product.getCategory',["id" => ":id"])); ?>';
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                async:false,
                success: function(data)
                {
                    console.log(data);
                    var categorys = data.data;
                    var htmlData = '<option value="">Select category</option>';
                    for (var i = 0; i < categorys.length; i++)
                    {
                        if(categorys[i].id == catid){
                            htmlData += '<option value="'+categorys[i].id+'" selected>'+categorys[i].name+'</option>';
                        }else{
                            htmlData += '<option value="'+categorys[i].id+'">'+categorys[i].name+'</option>';
                        }
                    }
                    $('.category').html(htmlData);

                }
            });

            if(catid)
            {
                var url = '<?php echo e(route('admin.product.getsubCategory',["id" => ":id"])); ?>';
                url = url.replace(':id', catid);
                $.ajax({
                    type: 'GET',
                    url: url,
                    async:false,
                    success: function(data)
                    {
                        $('.subcategory').empty();
                        console.log(data);
                        var subcategorys = data.data;
                        var htmlData = '<option value="">Select sub category</option>';
                        for (var i = 0; i < subcategorys.length; i++)
                        {
                            if(subcategorys[i].id == subcatid){
                                htmlData += '<option value="'+subcategorys[i].id+'" selected>'+subcategorys[i].name+'</option>';
                            }else{
                                htmlData += '<option value="'+subcategorys[i].id+'" >'+subcategorys[i].name+'</option>';
                            }
                        }
                        $('.subcategory').html(htmlData);
                    }
                });
            }

            // var packageid = $(".package_size").val();
            // var unitName = $(".unitName").val();
            // if(packageid)
            // {
            //     id = packageid;
            //     var url = '<?php echo e(route('store.product.getUnit',["id" => ":id"])); ?>';
            //     url = url.replace(':id', id);
            //     $.ajax({
            //         type: 'GET',
            //         url: url,
            //         async:false,
            //         success: function(data)
            //         {
            //             console.log(data);
            //             var units = data.data;
            //             var htmlData = '<option value="">Select unit</option>';
            //             for (var i = 0; i < units.length; i++)
            //             {
            //                 if(units[i].name == unitName){
            //                     htmlData += '<option value="'+units[i].name+'" selected>'+units[i].name+'</option>';
            //                 }else{
            //                     htmlData += '<option value="'+units[i].name+'" >'+units[i].name+'</option>';
            //                 }
            //             }
            //             $('.unit').html(htmlData);
            //         }
            //     });
            // }
            // else{
            //     $('.unit').html('<option value="">Select Unit</option>');
            // }
        })

        $("#changeStore").change(function(){
            var estore_id=$("option:selected",this).val();
            var module_id=$("option:selected",this).attr("data-module_id");
            if(module_id==''){
                $(`#module option`).prop("selected",false);
                return;
            }
            $(`#module option[value="${module_id}"]`).prop("selected",true);
            $("#module").change();
            $('#module_id').val(module_id);
            var store_id = $('#changeStore').val();
            $('#store_id').val(estore_id);
        })

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

        //get category

        function moduleChange()
        {
            var id = $('.module').val();
            console.log(id);

            if(id)
            {
                var url = '<?php echo e(route('store.product.getCategory',["id" => ":id"])); ?>';
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    async:false,
                    success: function(data)
                    {
                        console.log(data);
                        var categorys = data.data;
                        var htmlData = '<option value="">Select category</option>';
                        for (var i = 0; i < categorys.length; i++)
                        {
                            htmlData += '<option value="'+categorys[i].id+'" >'+categorys[i].name+'</option>';
                        }
                        $('.category').html(htmlData);
                    }
                });
            }
            else{
                $('.category').html('<option value="">Select Product</option>');
            }
        }

        $(document).on('change','.category',function()
        {
            var id = $('.category').val();
        
            if(id)
            {
                var url = '<?php echo e(route('admin.product.getsubCategory',["id" => ":id"])); ?>';
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    async:false,
                    success: function(data)
                    {
                        console.log(data);
                        var subcategorys = data.data;
                        var htmlData = '<option value="">Select sub category</option>';
                        for (var i = 0; i < subcategorys.length; i++)
                        {
                            htmlData += '<option value="'+subcategorys[i].id+'" >'+subcategorys[i].name+'</option>';
                        }
                        $('.subcategory').html(htmlData);
                    }
                });
            }
            else{
                $('.category').html('<option value="">Select Sub Category</option>');
            }
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('store.storeAdmin.layout.mainlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/billp5kj/public_html/resources/views/store/storeAdmin/edit-product.blade.php ENDPATH**/ ?>