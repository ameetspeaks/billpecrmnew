<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        billpe - admin
     </title>

    <link rel="stylesheet" href="{{ asset('public/admin/vendors/typicons.font/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/vendors/css/vendor.bundle.base.css') }}">

    <link rel="stylesheet" href="{{ asset('public/admin/css/vertical-layout-light/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('public/admin/upload/'.\App\Models\Setting::where('type','company_fav_icon')->first()->value) }}" />
</head>

<body>
  
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        @if (\Session::has('error'))
                            <div class="alert alert-danger">
                                <ul>
                                    <li class="errorMsg">{!! \Session::get('error') !!}</li>
                                </ul>
                            </div>
                        @endif
                            <div class="brand-logo text-center">
                                <img src="{{ asset('public/admin/upload/'.\App\Models\Setting::where('type','company_logo')->first()->value) }}" alt="logo" class="object-contain" />
                            </div>
                            <h4 class="text-center">Store Register</h4>
                            
                                <form class="row forms-sample w-full" action="{{ route('store.AddNewStore') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                
                                    <div class="form-group col-12 err_name">
                                        <label>Store Name*</label>
                                        <input type="text" name="shop_name" class="form-control" placeholder="Store Name" required>
                                        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
                                    </div>

                                    <div class="form-group col-md-6 col-12 err_module_id">
                                        <label>Store Type*</label>
                                        <select class="form-control h-11" name="store_type" required>
                                            <option value="" class="font-medium">select store type</option>
                                            @foreach ($store_types as $store_type)
                                                <option value="{{ $store_type->id }}" >{{ $store_type->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-xs text-red-500 mt-2 errmsg_module_id"></span>
                                    </div>

                                    <div class="form-group col-md-6 col-12 err_module_id">
                                        <label>Store Category*</label>
                                        <select class="form-control h-11" name="store_category" required>
                                            <option value="" class="font-medium">select module</option>
                                            @foreach ($modules as $module)
                                                <option value="{{ $module->id }}" >{{ $module->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-xs text-red-500 mt-2 errmsg_module_id"></span>
                                    </div>

                                    <div class="form-group col-6 err_whatsapp_no">
                                        <label>Whatsapp Number</label>
                                        <input type="text" name="whatsapp_no" class="form-control" value="{{Session::get('whatsapp_no')}}" placeholder="00000000000" readonly>
                                        <span class="text-xs text-red-500 mt-2 errmsg_whatsapp_no"></span>
                                    </div>

                                    <div class="form-group col-12 err_store_address">
                                        <label>Store address</label>
                                        <input type="text" name="address" class="form-control" placeholder="Store Address">
                                        <span class="text-xs text-red-500 mt-2 errmsg_store_address"></span>
                                    </div>

                                    <div class="form-group col-6 err_gst">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control" placeholder="City">
                                        <span class="text-xs text-red-500 mt-2 errmsg_city"></span>
                                    </div>

                                    <div class="form-group col-6 err_gst">
                                        <label>Pin Code</label>
                                        <input type="text" name="pincode" class="form-control" placeholder="Pin Code">
                                        <span class="text-xs text-red-500 mt-2 errmsg_pin"></span>
                                    </div>

                                

                                    <div class="form-group col-12 err_cover">
                                        <label>Store Image</label>
                                        <input type="file" name="store_image" class="form-control  cursor-pointer" id="store_image">
                                        <span class="text-xs text-red-500 mt-2 errmsg_cover"></span>
                                        <div class="col-4  border-2 border-dark px-0 p-2 rounded-lg mt-3">
                                            <img id="coverImg" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
                                        </div>
                                    </div>


                                    <div class="form-group col-6 err_latitude">
                                        <label>Latitude</label>
                                        <input type="text" class="form-control latitude" name="latitude" placeholder="latitude" >
                                        <span class="text-xs text-red-500 mt-2 errmsg_latitude"></span>
                                    </div>

                                    <div class="form-group col-6 err_longitude">
                                        <label>Longitude</label>
                                        <input type="text" class="form-control longitude" name="longitude" placeholder="longitude" >
                                        <span class="text-xs text-red-500 mt-2 errmsg_longitude"></span>
                                    </div>

                                    <div class="form-group col-6 err_store_address">
                                        <label>Owner Name</label>
                                        <input type="text" name="owner_name" class="form-control"  placeholder="Owner Name">
                                        <span class="text-xs text-red-500 mt-2 errmsg_owner"></span>
                                    </div>

                                    <div class="form-group col-6 err_gst">
                                        <label>GST number</label>
                                        <input type="text" name="gst" class="form-control" placeholder="gst_number">
                                        <span class="text-xs text-red-500 mt-2 errmsg_gst"></span>
                                    </div>

                                    <div class="form-group col-6 err_open_time">
                                        <label>Open Time</label>
                                        <input type="time" name="open_time" class="form-control" placeholder="open time">
                                        <span class="text-xs text-red-500 mt-2 err_open_time"></span>
                                    </div>

                                    <div class="form-group col-6 err_close_time">
                                        <label>Close Time</label>
                                        <input type="time" name="close_time" class="form-control" placeholder="close time">
                                        <span class="text-xs text-red-500 mt-2 err_close_time"></span>
                                    </div>

                                    <div class="form-group col-12 err_select_days">
                                        <label>Select Days</label><br>
                                        <input type="checkbox" name="days[]" value="mon">Mon
                                        <input type="checkbox" name="days[]" value="tue">Tue
                                        <input type="checkbox" name="days[]" value="wed">Wed
                                        <input type="checkbox" name="days[]" value="thu">Thu
                                        <input type="checkbox" name="days[]" value="fri">Fri
                                        <input type="checkbox" name="days[]" value="sat">Sat
                                        <input type="checkbox" name="days[]" value="sun">Sun
                                        <span class="text-xs text-red-500 mt-2 err_select_days"></span>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700">Submit</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="{{ asset('public/admin/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{ asset('public/admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('public/admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('public/admin/js/template.js') }}"></script>
    <script src="{{ asset('public/admin/js/settings.js') }}"></script>
    <script src="{{ asset('public/admin/js/todolist.js') }}"></script>
    <!-- endinject -->

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
</body>

</html>

