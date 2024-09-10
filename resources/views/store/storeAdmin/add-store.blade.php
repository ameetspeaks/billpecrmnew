<?php $page = 'store-list'; ?>
@extends('store.storeAdmin.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Add Store</h4>
                        <h6>Manage your Store</h6>
                    </div>
                </div>
            </div>

            @include('store.storeAdmin.layout.partials.session')

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">  
                    <div class="table-responsive">
                        <form class="row forms-sample w-full" action="{{ route('store.Addstore') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        
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
                                    <option value="" class="font-medium">select category</option>
                                    @foreach ($modules as $module)
                                        <option value="{{ $module->id }}" >{{ $module->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-xs text-red-500 mt-2 errmsg_module_id"></span>
                            </div>

                            <div class="form-group col-6 err_store_address">
                                <label>Owner Name</label>
                                <input type="text" name="owner_name" class="form-control"  placeholder="Owner Name">
                                <span class="text-xs text-red-500 mt-2 errmsg_owner"></span>
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

                        

                            <div class="form-group col-4 err_cover">
                                <label>Upload cover photo</label>
                                <input type="file" name="store_image" class="form-control  cursor-pointer" id="store_image">
                                <span class="text-xs text-red-500 mt-2 errmsg_cover"></span>
                                <div class="col-4  border-2 border-dark px-0 p-2 rounded-lg mt-3">
                                    <img id="coverImg" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
                                </div>
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

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
                                <a href="{{ route('store.store-list') }}"><div class="btn btn-light">Cancel</div></a>
                            </div>
                        

                        </form>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>

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

@endsection
