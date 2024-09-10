@component('admin.component')
@slot('title') Edit Store @endslot
@slot('subTitle') Edit details @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.store.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="store_id" value="{{$store->id}}">
    <input type="hidden" name="old_image" value="{{$store->store_image}}">

    <div class="form-group col-6 err_name">
        <label>Store Name*</label>
        <input type="text" name="shop_name" class="form-control" placeholder="Store Name" value="{{$store->shop_name}}" required>
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-6 err_store_address">
        <label>Store address</label>
        <input type="text" name="address" class="form-control" value="{{$store->address}}" placeholder="Store Address">
        <span class="text-xs text-red-500 mt-2 errmsg_store_address"></span>
    </div>

    <div class="form-group col-md-6 col-12 err_module_id">
        <label>Store Type*</label>
        <select class="form-control h-11" name="store_type" required>
            <option value="" class="font-medium">select type</option>
            @foreach ($storeTypes as $storeType)
                <option value="{{ $storeType->id }}" {{$store->store_type == $storeType->id ? 'selected' : ''}}>{{ $storeType->name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_module_id"></span>
    </div>

    <div class="form-group col-md-6 col-12 err_module_id">
        <label>Store Category*</label>
        <select class="form-control h-11" name="store_category" required>
            <option value="" class="font-medium">select module</option>
            @foreach ($modules as $module)
                <option value="{{ $module->id }}" {{$store->module_id == $module->id ? 'selected' : ''}} >{{ $module->name }}</option>
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
        <input type="text" name="gst" class="form-control" value="{{$store->gst}}" placeholder="gst_number">
        <span class="text-xs text-red-500 mt-2 errmsg_gst"></span>
    </div>
    

    <div class="form-group col-4 err_gst">
        <label>City</label>
        <input type="text" name="city" class="form-control" value="{{$store->city}}" placeholder="City">
        <span class="text-xs text-red-500 mt-2 errmsg_city"></span>
    </div>

    <div class="form-group col-4 err_gst">
        <label>Pin Code</label>
        <input type="text" name="pincode" class="form-control" value="{{$store->pincode}}" placeholder="Pin Code">
        <span class="text-xs text-red-500 mt-2 errmsg_pin"></span>
    </div>



    <div class="form-group col-4 err_latitude">
        <label>Latitude</label>
        <input type="text" class="form-control latitude" name="latitude" value="{{$store->latitude}}" placeholder="latitude" >
        <span class="text-xs text-red-500 mt-2 errmsg_latitude"></span>
    </div>

    <div class="form-group col-4 err_longitude">
        <label>Longitude</label>
        <input type="text" class="form-control longitude" name="longitude" value="{{$store->longitude}}" placeholder="longitude" >
        <span class="text-xs text-red-500 mt-2 errmsg_longitude"></span>
    </div>

    <h4 class="card-title  col-12 mt-4">Extend Subscription</h4>
    <div class="form-group col-6 err_extend_day">
        <label>Extend day <span style="color:red;font-weight:500 ">(Expiry Date :  {{ \Carbon\Carbon::parse($store->valide_package_date)->format('d-m-Y') }}, Package Name : {{$store->package?->name}})</span></label>
        <input type="number" class="form-control" name="extend_day" placeholder="1,2,3,4...,-1,-2,-3,-4...">
        <span class="text-xs text-red-500 mt-2 errmsg_extend_day"></span>
    </div>
    <div class="form-group col-md-6 col-12 err_package_id">
        <label>Change Subscription Package</label>
        <select class="form-control h-11" name="package_id">
            <option value="" class="font-medium">select Package</option>
            @foreach ($subcr_package as $subcr_packages)
                <option value="{{ $subcr_packages->id }}" {{ $store->package_id == $subcr_packages->id ? "selected" : "" }} >{{ $subcr_packages->name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_package_id"></span>
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
    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#coverImg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    $("#store_image").change(function(){
        readURL2(this);
    })

</script>

@endslot
@endcomponent

