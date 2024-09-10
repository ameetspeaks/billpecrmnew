<?php $page = 'add-product'; ?>

@extends('store.storeAdmin.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>New Product</h4>
                        <h6>Create new product</h6>
                    </div>
                </div>
                    
                <div>     
                    <div style=" z-index: 99999;position: absolute;width: 100%;height: 100%;display:none" id="hideSpinner1">
                        <div class="spinner-grow text-primary " style=" position: absolute;left: 33%;top: 12%;"></div>
                        <input type="file" name="productExcel" id="productExcel" class="form-control" style="visibility: hidden;position: absolute;width:0%">
                    </div>

                    <div class="page-btn import">
                        <button type="submit" id="productExcelBtn" class="btn btn-outline-secondary btn-fw color me-2" id=""><i
                                data-feather="download"></i>Import Product</button>
                    </div>
                </div>
                
                <div class="page-btn import">
                    <a href="{{ route('store.product.productExport') }}"><button class="btn btn-outline-secondary btn-fw color me-2" id=""><i
                            data-feather="download"></i>Export Product</button></a>
                </div>
               
                <ul class="table-top-head">
                    <li>
                        <div class="page-btn">
                            <a href="{{ route('store.product-list') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                                    class="me-2"></i>Back to Product</a>
                        </div>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                data-feather="chevron-up" class="feather-chevron-up"></i></a>
                    </li>
                </ul>
    
            </div>
            
            @include('store.storeAdmin.layout.partials.session')
            <div class="text-right col-12">
            <span class="text-xs text-red-500 mt-2 errmsg_productExcel" style="color:red"></span>
            <div>
                <ul id="showExportError">
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    @endif
                </ul>
            </div>
            </div>

            <div class="text-right col-12">
                <span class="text-xs text-green-500 mt-2 successmsg_productExcel" style="color:red"></span>
            </div>
            <!-- /add -->
            <form class="row forms-sample w-full" action="{{ route('store.product.store') }}"  method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="moduleid"  value="">

                <div class="form-group col-md-6 col-12 err_store">
                    <label style="font-weight:bold">Store</label>
                    <input type="hidden" name="store_id" id="store_id">
                    <select class="form-control h-11 cursor-pointer" id="changeStoreProduct" name="store_id" disabled>
                        <option data-module_id="" value="">Select Store</option>
                        @foreach ($stores as $store)
                            <option data-module_id="{{$store->module_id}}" value="{{ $store->id }}" {{ Session::get('store_id') == $store->id ? 'selected':'' }} >{{ $store->shop_name }}</option>
                        @endforeach
                    </select>
                    <span class="text-xs text-red-500 mt-2 errmsg_store"></span>
                </div>

                <div class="form-group col-md-6 col-12 err_module">
                    <label style="font-weight:bold">Module</label>
                    <input type="hidden" name="module_id" id="module_id">
                    <select disabled class="form-control h-11 cursor-pointer module" id="module" onchange="moduleChange()">
                        <option value="">Select Module</option>
                        @foreach ($modules as $module)
                            <option value="{{ $module->id }}">{{ $module->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-xs text-red-500 mt-2 errmsg_module"></span>
                </div>

                <h4 class="card-title mb-6 col-12 p-0">Products</h4>
                <div class="form-group col-md-6 col-12 err_name">
                    <label style="font-weight:bold">Product Name</label>
                    <input class="form-control" type="text" id="realName" name="name" >
                    {{-- <input class="form-control" type="text" id="realName" name="name"> --}}
                    <input class="form-control" type="hidden" id="realImgName" name="realImgName">
                
                    <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
                </div>

                <div class="form-group col-md-6 col-12 err_barcode">
                    <label style="font-weight:bold">BarCode</label>
                    <input type="text" class="form-control" name="barcode" placeholder="Enter barcode">
                    <span class="text-xs text-red-500 mt-2 errmsg_barcode"></span>
                </div>

                <div class="form-group col-md-6 col-12 err_category">
                    <label style="font-weight:bold">Category</label>
                    <select id="category"   class="form-control h-11 cursor-pointer category" name="category_id"  style="background:white !important;width:100%" >
                        <option value="">Select Category</option>
                    </select>
                    <span class="text-xs text-red-500 mt-2 errmsg_category"></span>
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
                    <input type="text" class="form-control" name="package_weight">
                    <span class="text-xs text-red-500 mt-2 errmsg_package_weight"></span>
                </div> -->

                <!-- <div class="form-group col-md-3 col-12 err_package_weight">
                    <label style="font-weight:bold">Package Size</label>
                    <select   class="form-control h-11 cursor-pointer package_size" name="package_size" style="background:white !important;width:100%" >
                        <option value="">Select Package Size</option>
                        @foreach ($attributes as $attribute)
                            <option value="{{ $attribute->name }}" data-id="{{ $attribute->id }}">{{ $attribute->name }}</option>
                        @endforeach
                    </select>
                </div> -->

                <div class="form-group col-md-6 col-12 err_qtn">
                    <label style="font-weight:bold">Qtn</label>
                    <input type="text" class="form-control" name="qtn">
                    <span class="text-xs text-red-500 mt-2 errmsg_qtn"></span>
                </div>
                
                <div class="form-group col-md-6 col-12 err_unit">
                    <label style="font-weight:bold">Unit</label>
                    <select   class="form-control h-11 cursor-pointer unit" name="unit" style="background:white !important;width:100%" >
                        <option value="">Select Unit</option>
                        @foreach ($unit as $units)
                            <option value="{{ $units->name }}">{{ $units->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-xs text-red-500 mt-2 errmsg_unit"></span>
                </div>

                <div class="form-group col-6">
                    <label><b>Image</b></label>
                    <input type="file" name="productImage"  class="form-control" id="changeImg">
                    <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
                    <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
                        <img id="ItemImg2" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
                    </div>
                </div>


                <h4 class="card-title mb-6 col-12 p-0">MRP Includes GST (PRICE per Unit)</h4>
                <div class="form-group col-md-4 col-12 err_mrp">
                    <label style="font-weight:bold">MRP</label>
                    <input type="text" class="form-control" name="mrp">
                    <span class="text-xs text-red-500 mt-2 errmsg_mrp"></span>
                </div>
                @if($currentStore->store_type == 1 || $currentStore->store_type == 3)
                <div class="form-group col-md-4 col-12 err_retail">
                    <label style="font-weight:bold">Retails Price</label>
                    <input type="text" class="form-control" name="retail_price">
                </div>
                @endif
                @if($currentStore->store_type == 2 || $currentStore->store_type == 3)
                <div class="form-group col-md-4 col-12 err_sell_price">
                    <label style="font-weight:bold">WholeSale Price</label>
                    <input type="text" class="form-control" name="wholesale_price">
                    <span class="text-xs text-red-500 mt-2 errmsg_sell_price"></span>
                </div>
                @endif
                <div class="form-group col-md-4 col-12 err_purchase_price">
                    <label style="font-weight:bold">Purchase Price</label>
                    <input type="text" class="form-control" name="purchase_price">
                    <span class="text-xs text-red-500 mt-2 errmsg_purchase_price"></span>
                </div>
            
                <div class="form-group col-md-4 col-12 err_member">
                    <label style="font-weight:bold">Member Price</label>
                    <input type="text" class="form-control" name="member_price">
                </div>
            
                <h4 class="card-title mb-6 col-12 p-0">Stock</h4>
                <div class="form-group col-md-6 col-12 err_stock">
                    <label><b>Total stock</b></label>
                    <input type="text" class="form-control" name="stock">
                    <span class="text-xs text-red-500 mt-2 errmsg_stock"></span>
                </div>
                <div class="form-group col-md-6 col-12 err_low_stock">
                    <label><b>Low stock</b></label>
                    <input type="text" class="form-control" name="low_stock">
                    <span class="text-xs text-red-500 mt-2 errmsg_low_stock"></span>
                </div>
                
                <div class="form-group col-md-6 col-12 err_tag">
                    <label ><b>Tag</b></label>
                    <input type="text" class="form-control" placeholder="Tag1, Tag2, Tag3" name="tag">
                    <span class="text-xs text-red-500 mt-2 errmsg_tag"></span>
                </div>

                <div class="form-group col-md-6 col-12 err_expiry_date">
                    <label style="font-weight:bold">Expiry Date</label>
                    <input type="date" class="form-control" name="expiry_date">
                    <span class="text-xs text-red-500 mt-2 errmsg_expiry_date"></span>
                </div>


                <div class="form-group col-md-6 col-12 err_brand">
                    <label ><b>Brand</b></label>
                    <input type="text" class="form-control" placeholder="Brand" name="brand">
                </div>

                <div class="form-group col-md-6 col-12 err_expiry_color">
                    <label style="font-weight:bold">Color</label>
                    <input type="text" class="form-control" placeholder="Enter color" name="color">
                </div>

                <h4 class="card-title mb-6 col-12 p-0">Tax</h4>
                <div class="form-group col-md-4 col-12 err_hsn">
                    <label style="font-weight:bold">HSN</label>
                    <input type="text" class="form-control" name="hsn">
                </div>
                <div class="form-group col-md-4 col-12 err_gst">
                    <label><b>GST</b></label>
                    <input type="number" class="form-control" name="gst">
                    <span class="text-xs text-red-500 mt-2 errmsg_gst"></span>
                </div>
                <div class="form-group col-md-4 col-12 err_CESS">
                    <label><b>CESS</b></label>
                    <input type="number" class="form-control" name="CESS">
                    <span class="text-xs text-red-500 mt-2 errmsg_CESS"></span>
                </div>
                
                <div class="mt-4 col-12">
                    <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="">Submit</button>

                </div>
            </form>
            <!-- /add -->

        </div>
    </div>

    <script>

        $(document).ready(function(){
            var estore_id=$("#changeStoreProduct").val();
            var module_id=$('#changeStoreProduct option:selected').data('module_id');
           
            if(module_id==''){
                $(`#module option`).prop("selected",false);
                return;
            }
            $(`#module option[value="${module_id}"]`).prop("selected",true);
            $("#module").change();
            $('#module_id').val(module_id);

            var store_id = $('#changeStoreProduct').val();
            $('#store_id').val(estore_id);
        })

        // Change Store
        $("#changeStoreProduct").change(function(){
            var estore_id=$("#changeStoreProduct").val();
            var module_id=$("option:selected",this).attr("data-module_id");
            if(module_id==''){
                $(`#module option`).prop("selected",false);
                return;
            }
            $(`#module option[value="${module_id}"]`).prop("selected",true);
            $("#module").change();
            $('#module_id').val(module_id);
            var store_id = $('#changeStoreProductx`').val();
            $('#estore_id').val(estore_id);
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

        $(".package_size").change(function()
        {
            // var id = $('.package_size').val();
            var id = $("option:selected",this).attr('data-id');
            if(id)
            {
                var url = '{{ route('store.product.getUnit',["id" => ":id"]) }}';
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    async:false,
                    success: function(data)
                    {
                        console.log(data);
                        var units = data.data;
                        var htmlData = '<option value="">Select unit</option>';
                        for (var i = 0; i < units.length; i++)
                        {
                            htmlData += '<option value="'+units[i].name+'" >'+units[i].name+'</option>';
                        }
                        $('.unit').html(htmlData);
                    }
                });
            }
            else{
                $('.unit').html('<option value="">Select Unit</option>');
            }
        })

        function moduleChange()
        {
            var id = $('.module').val();
            console.log(id);

            if(id)
            {
                var url = '{{ route('store.product.getCategory',["id" => ":id"]) }}';
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
                var url = '{{ route('store.product.getsubCategory',["id" => ":id"]) }}';
                url = url.replace(':id', id);
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
                            htmlData += '<option value="'+subcategorys[i].id+'" >'+subcategorys[i].name+'</option>';
                        }
                        $('.subcategory').append(htmlData);
                    }
                });
            }
            else{
                $('.category').html('<option value="">Select Sub Category</option>');
            }
        })


        // Select file for Import Excel file

        $('#productExcelBtn').click(function(){
                $("#productExcel").click();
        });

        $("#productExcel").change(function(){
            $("#hideSpinner1").show();
            
            var formData = new FormData();
            var productExcel = $('#productExcel').prop('files')[0]; 
            formData.append('productExcel', productExcel);
          
            var url = '{{route('store.product.uploadProductExcel')}}';
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN' : $('input[name="_token"]').val()
                },
                type: 'POST',
                url: url,
                contentType: 'multipart/form-data',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                complete: function(data)
                {
                    $("#hideSpinner1").hide();
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
        });

            

    </script>
@endsection



