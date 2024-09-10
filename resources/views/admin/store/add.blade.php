@component('admin.component')
@slot('title') Add New Store @endslot
@slot('subTitle') Store details @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.store.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="role_type" value="2">
    <div class="form-group col-6 err_name">
        <label>Store Name*</label>
        <input type="text" name="shop_name" class="form-control" placeholder="Store Name" required>
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-6 err_store_address">
        <label>Store address</label>
        <input type="text" name="address" class="form-control" placeholder="Store Address">
        <span class="text-xs text-red-500 mt-2 errmsg_store_address"></span>
    </div>

    <div class="form-group col-md-6 col-12 err_module_id">
        <label>Store Type*</label>
        <select class="form-control h-11" name="store_type" required>
            <option value="" class="font-medium">select type</option>
            @foreach ($storeTypes as $storeType)
                <option value="{{ $storeType->id }}" >{{ $storeType->name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_module_id"></span>
    </div>

    <div class="form-group col-md-6 col-12 err_module_id">
        <label>Store Category*</label>
        <select class="form-control h-11" name="store_category" required>
            <option value="" class="font-medium">select category</option>
            @foreach ($modules as $module)
                <option value="{{ $module->id }}" >{{ $module->name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_module_id"></span>
    </div>

    <div class="form-group col-6 err_cover">
        <label>Store Image</label>
        <input type="file" name="store_image" class="form-control  cursor-pointer" id="store_image">
        <span class="text-xs text-red-500 mt-2 errmsg_cover"></span>
        <div class="col-4  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="coverImg" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>

    <div class="form-group col-4 err_gst">
        <label>GST number</label>
        <input type="text" name="gst" class="form-control" placeholder="gst_number">
        <span class="text-xs text-red-500 mt-2 errmsg_gst"></span>
    </div>

    <div class="form-group col-4 err_gst">
        <label>City</label>
        <input type="text" name="city" class="form-control" placeholder="City">
        <span class="text-xs text-red-500 mt-2 errmsg_city"></span>
    </div>

    <div class="form-group col-4 err_gst">
        <label>Pin Code</label>
        <input type="text" name="pincode" class="form-control" placeholder="Pin Code">
        <span class="text-xs text-red-500 mt-2 errmsg_pin"></span>
    </div>



    <div class="form-group col-4 err_latitude">
        <label>Latitude</label>
        <input type="text" class="form-control latitude" name="latitude" placeholder="latitude" >
        <span class="text-xs text-red-500 mt-2 errmsg_latitude"></span>
    </div>

    <div class="form-group col-4 err_longitude">
        <label>Longitude</label>
        <input type="text" class="form-control longitude" name="longitude" placeholder="longitude" >
        <span class="text-xs text-red-500 mt-2 errmsg_longitude"></span>
    </div>



    {{-- OWNER INFORMATION --}}
    <h4 class="card-title  col-12 mt-4">Owner Information</h4>

    <div class="form-group col-4 err_f_name">
        <label>Name</label>
        <input type="text" class="form-control" name="name" placeholder="Name">
        <span class="text-xs text-red-500 mt-2 errmsg_f_name"></span>
    </div>

    <!-- <div class="form-group col-4 err_phone">
        <label>Role*</label>
        <select class="form-control h-11" name="role_type">
            <option value="" class="font-medium">select module</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" >{{ $role->name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_role_type"></span>
    </div> -->

    <div class="form-group col-4 err_phone">
        <label>Whatsapp Number*</label>
        <input type="number" class="form-control" name="whatsapp_no" placeholder="Whatsapp number" required>
        <span class="text-xs text-red-500 mt-2 errmsg_phone"></span>
    </div>

    <div class="form-group col-4 err_email">
        <label>Email</label>
        <input type="email" class="form-control" name="email" placeholder="Email">
        <span class="text-xs text-red-500 mt-2 errmsg_email"></span>
    </div>
   
    <div class="form-group col-4 err_password">
        <label>Password</label>
        <input type="password" class="form-control" name="password" placeholder="5+ characters required">
        <span class="text-xs text-red-500 mt-2 errmsg_password"></span>
    </div>

    <div class="form-group col-4 err_image">
        <label>Owner Image</label>
        <input type="file" name="image" class="form-control cursor-pointer" id="changeImg1">
        <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
        <div class="col-4  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="logoImg" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.store.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
   

</form>
@endslot
@slot('script')
<script>
    // SHOW IMAGE
    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#logoImg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#coverImg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#changeImg1").change(function(){
        readURL1(this);
    })

    $("#store_image").change(function(){
        readURL2(this);
    })

</script>

@endslot
@endcomponent

