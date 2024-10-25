@component('admin.component')
    @slot('title')
        Customer Banner
    @endslot
    @slot('subTitle')
        Customer Banner add
    @endslot
    @slot('content')

        <form action="{{route('admin.customerbanner.store')}}" class="row forms-sample w-full" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group col-md-6 col-12">
                <label for="zone"><b>Select Zone</b></label>
                <select class="form-control select selectZone" name="zone" id="zone" >
                    <option value="">Select Zone</option>
                    @foreach($zones as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 col-12">
                <label for="packageSelect"><b>Select Modules</b></label>
                <select class="form-control select selectModule" name="modules_id" id="module" >
                    <option value="">Select Modules</option>
                    @foreach($modules as $module)
                        <option value="{{$module->id}}">{{$module->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 col-12">
                <label for="store"><b>Stores</b></label>
                <select class="form-control store" name="store_id" id="store" >
                    <option value="">Select Zone or Module First</option>
                </select>
                <span class="text-xs text-red-500 mt-2"></span>
            </div>

            <div class="form-group col-md-6 col-12">
                <label for="positionSelect"><b>Select Position</b></label>
                <select class="form-control select" name="position" id="positionSelect" required>
                    <option selected value="top">Top</option>
                    <option value="bottom">Bottom</option>
                </select>
            </div>


            <div class="form-group col-md-6 col-12 err_image">
                <label><b>Banner Name</b></label>
                <input type="text" name="name" placeholder="Banner Name" class="form-control" id="name">
            </div>
            <div class="form-group col-md-6 col-12 err_image">
                <label><b>Image/Video Link</b></label>
                <input type="text" name="banner_image_link" placeholder="Image Url" class="form-control">
            </div>
            <div class="form-group col-md-6 col-12 err_image">
                <label><b>Image</b></label>
                <input type="file" name="banner_image" class="form-control" id="changeImg">
                <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
                <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
                    <img id="ItemImg2" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%"/>
                </div>
            </div>
            <div class="form-group col-md-6 col-12 mt-3">
                <button type="submit" class="btn bg-primary text-white">Submit</button>
                <a href="{{ route('admin.customerbanner.index') }}">
                    <div class="btn btn-light">Cancel</div>
                </a>
            </div>

        </form>
    @endslot
    @slot('script')

        <script>

            // SHOW IMAGE

            function readURL(input) {
                var image = input.files[0].size;
                // if(image > 200000) {
                //     $('.errmsg_image').html('File size maximum 200kB.');
                //     $('#changeImg').val('');
                //     $('#ItemImg2').prop('src', null);
                // }else{
                $('.errmsg_image').html('');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#ItemImg2').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
                // }

            }

            $("#changeImg").change(function () {
                readURL(this);
            })

            // Function to handle the AJAX request
            function fetchStores() {
                // Capture the values of module and zone
                var module_id = $('#module').val() || null; // Use null if module_id is empty
                var zone_id = $('#zone').val() || null;     // Use null if zone_id is empty

                // AJAX request to fetch stores based on module and zone values
                $.ajax({
                    url: '{{ route('admin.customer-banner.get-stores') }}',
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'module_id': module_id,
                        'zone_id': zone_id
                    },
                    success: function (data) {
                        console.log(data); // Log the response

                        $('#store').empty(); // Clear the current options
                        var storeData = '<option value="">Select Store</option>';

                        // Populate the dropdown with the returned data
                        $.each(data, function (id, storeName) {
                            storeData += '<option value="' + id + '">' + storeName + '</option>';
                        });

                        $('#store').append(storeData); // Append the new options
                    },
                    error: function (xhr, status, error) {
                        console.error('Error in AJAX request:', error);
                    }
                });
            }

            // Trigger the fetchStores function when either zone or module changes
            $(document).on('change', '#module, #zone', function () {
                fetchStores(); // Call fetchStores when either zone or module changes
            });

        </script>
    @endslot
@endcomponent
