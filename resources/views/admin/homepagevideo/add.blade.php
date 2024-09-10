@component('admin.component')
@slot('title') Homepage Video @endslot
@slot('subTitle') Homepage Video add @endslot
@slot('content')

<form action="{{route('admin.homepagevideo.store')}}" class="row forms-sample w-full" name="sendNotificationsForm" id="sendNotificationsForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group col-md-6 col-12">
        <label for="packageSelect">Select Modules:</label>
        <select class="form-control select"  name="modules_id[]" multiple required>
            <option value="">Select Modules</option>
            @foreach($modules as $module)
            <option value="{{$module->id}}">{{$module->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6 col-12">
        <label for="packageSelect">Select Package:</label>
        <select class="form-control h-11" id="package_type" name="package_type" required>
            <option value="both">Both</option>
            <option value="trial">Trial</option>
            <option value="paid">Paid</option>
        </select>
    </div>

    <div class="form-group col-md-6 col-12">
        <label for="packageSelect">Module Condition:</label>
        <select class="form-control h-11" id="module_condition" name="module_condition" required>
            <option value="">Select here</option>
            <option value="0">First Time</option>
            <option value="1">Marketing</option>
        </select>
    </div>

    <!-- <div class="form-group col-md-6 col-12 err_store">
        <label for="packageSelect">Select Store:</label>
        <select class="form-control select" name="selected_stores[]" id="store" multiple>
            @foreach ($stores as $store)
                <option data-package-id="{{ $store->package_id == 1 ? 'trial' : 'paid' }}" value="{{ $store->id }}">{{ $store->shop_name }}</option>
            @endforeach
        </select>
    </div> -->
    <div class="form-group col-md-6 col-12 err_image">
        <label><b>Image/Video Link</b></label>
        <input type="text" name="homepage_video_image_link"  class="form-control" id="changeImg">
    </div>

    <div class="form-group col-md-6 col-12 err_image">
        <label><b>Video/Image</b></label>
        <input type="file" name="homepage_video_image"  class="form-control" id="changeImg">
        <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
        <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="ItemImg2" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>
    <div class="form-group col-md-6 col-12 mt-3">
        <button type="submit" class="btn bg-primary text-white">Submit</button>
        <a href="{{ route('admin.homepagevideo.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
    
</form>
@endslot
@slot('script')

    <!-- 
    <script>
        
        // Get the package and store select elements
        const packageSelect = document.getElementById("packageSelect");
        const storeSelect = document.getElementById("storeId");
      
        // Create a function to show or hide options based on the selected package
        function filterStores(selectedPackage) {
            const options = storeSelect.options;

            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                const packageId = option.getAttribute("data-package-id");

                if (selectedPackage === "all" || packageId === selectedPackage) {
                    option.style.display = "block"; // Show the option
                } else {
                    option.style.display = "none"; // Hide the option
                }
            }
        }

        // Add an event listener to the package select to filter stores on page load
        filterStores(packageSelect.value);

        // Add an event listener to the package select to filter stores when it changes
        packageSelect.addEventListener("change", function () {
            const selectedPackage = packageSelect.value;
            filterStores(selectedPackage);
        });
    </script> -->

    <script>

        // SHOW IMAGE

    function readURL(input) {
        var image=input.files[0].size;
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

    $("#changeImg").change(function(){
        readURL(this);
    })




    $('.select').select2({ placeholder: "Select Module" }).trigger('change');
    $(document).on('change','#packageSelect', function(){
        var packageSelect = $('#packageSelect').val();
    
        $.ajax({
                url: '{{ route('admin.getStoreByPackage') }}',
                method: 'post',
                data: { "_token" : "{{csrf_token()}}", 'packageSelect': packageSelect },
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
@endslot
@endcomponent
