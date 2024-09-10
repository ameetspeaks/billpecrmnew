@component('admin.component')
@slot('title') Tutorial @endslot
@slot('subTitle') Tutorial add @endslot
@slot('content')

<form action="{{route('admin.tutorial.store')}}" class="row forms-sample w-full" name="sendNotificationsForm" id="sendNotificationsForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group col-md-6 col-12">
        <label for="packageSelect">Select Modules:</label>
        <select class="form-control select"  name="modules_id[]" id="modules_id" multiple required>
            <option value="">Select Modules</option>
            @foreach($modules as $module)
            <option value="{{$module->id}}">{{$module->name}}</option>
            @endforeach
        </select>
        <input type="checkbox" id="checkboxSelectAll" >Select All Modules
    </div>

    <div class="form-group col-md-6 col-12">
        <label><b>Title</b></label>
        <input type="text" name="title"  class="form-control" id="title" placeholder="Title" required>
    </div>

    <div class="form-group col-md-6 col-12">
        <label><b>Description</b></label>
        <textarea type="text" name="discription" placeholder="Description"  class="form-control" id="discription" required></textarea>
    </div>
    
    <div class="form-group col-md-6 col-12">
        <label><b>Video Url</b></label>
        <input type="text" name="url" placeholder="Url"  class="form-control" id="url" required>
    </div>

    <div class="form-group col-md-6 col-12 mt-3">
        <button type="submit" class="btn bg-primary text-white">Submit</button>
        <a href="{{ route('admin.tutorial.index') }}"><div class="btn btn-light">Cancel</div></a>
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

    $("#modules_id").select2();
    $("#checkboxSelectAll").click(function(){
        if($("#checkboxSelectAll").is(':checked') ){
            $("#modules_id").find('option').prop("selected",true);
            $("#modules_id").trigger("change");
        }else{
            $("#modules_id").val(null).trigger('change');
        }
    });

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
