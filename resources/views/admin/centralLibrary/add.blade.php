@component('admin.component')
@slot('title') Add product @endslot


@slot('subTitle') Basic Info @endslot
<style>
    .ms-dd .ms-list-option.option-selected, .ms-dd .ms-optgroup ul .ms-list-option.option-selected{
        background: transparent !important;
    }



</style>
@slot('content')


<form class="row forms-sample w-full" action="{{ route('admin.centralLibrary.store') }}"  method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" class="moduleid"  value="">

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

   
   

    <div class="form-group col-6">
        <label><b>Image</b></label>
        <input type="file" name="productImage"  class="form-control" id="changeImg">
        <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
        <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="ItemImg2" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>

    <div class="form-group col-6 err_image_Link">
        <label style="font-weight:bold">Image Link</label>
        <input type="text" class="form-control" name="image_Link" placeholder="Enter Image Link">
        <span class="text-xs text-red-500 mt-2 err_image_Link"></span>
    </div>

    <div class="form-group col-md-6 col-12 err_qtn">
        <label style="font-weight:bold">Qtn</label>
        <input type="number" class="form-control" name="qtn">
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

    <div class="form-group col-md-6 col-12 err_category">
        <label style="font-weight:bold">Category</label>
        <select id="category"   class="form-control h-11 cursor-pointer category" name="category_id" style="background:white !important;width:100%" >
            <option value="">Select Category</option>
            @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
            @endforeach
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

    <h4 class="card-title mb-6 col-12 p-0">MRP Includes GST (PRICE per Unit)</h4>
    <div class="form-group col-md-6 col-12 err_mrp">
        <label style="font-weight:bold">MRP</label>
        <input type="number" class="form-control" name="mrp">
        <span class="text-xs text-red-500 mt-2 errmsg_mrp"></span>
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
@endslot
@slot('script')


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

    //get category

    $(document).on('change','.category',function()
    {
        var id = $('.category').val();
       
        if(id)
        {
            var url = '{{ route('admin.product.getsubCategory',["id" => ":id"]) }}';
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
</script>


@endslot
@endcomponent
