@component('admin.component')
@slot('title') Customer Banner @endslot
@slot('subTitle') Customer Banner add @endslot
@slot('content')

<form action="{{route('admin.customerbanner.store')}}" class="row forms-sample w-full" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group col-md-6 col-12">
        <label for="packageSelect">Select Modules:</label>
        <select class="form-control select selectModule"   name="modules_id" required>
            <option value="">Select Modules</option>
            @foreach($modules as $module)
            <option value="{{$module->id}}">{{$module->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-6">
        <label>Category</label>
        <select class="form-control category" name="category_id" id="category_id">
            <option value="">Select Category</option>
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_discount₹"></span>
    </div>

    <div class="form-group col-md-6 col-12 err_image">
        <label><b>Banner Name</b></label>
        <input type="text" name="name" placeholder="Banner Name"  class="form-control" id="name">
    </div>

    <div class="form-group col-md-6 col-12 err_image">
        <label><b>Image/Video Link</b></label>
        <input type="text" name="banner_image_link" placeholder="Image Url"  class="form-control">
    </div>
    <div class="form-group col-md-6 col-12 err_image">
        <label><b>Image</b></label>
        <input type="file" name="banner_image"  class="form-control" id="changeImg">
        <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
        <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="ItemImg2" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>
    <div class="form-group col-md-6 col-12 mt-3">
        <button type="submit" class="btn bg-primary text-white">Submit</button>
        <a href="{{ route('admin.customerbanner.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>

</form>
@endslot
@slot('script')

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
    $(document).on('change','.selectModule', function(){
        var module_id = $('.selectModule').val();
        $.ajax({
                url: '{{ route('admin.customerCoupan.getCategoryandStore') }}',
                method: 'post',
                data: { "_token" : "{{csrf_token()}}", 'module_id': module_id },
                success: function(data){
                    console.log(data)
                    $('.category').empty();
                    category = '<option value="">Select Category</option>'
                    $.each(data.categorys, function(index, value){
                        category += '<option value="'+value.id+'">'+value.name+'</option>'
                    })
                    $('.category').append(category);
                }
        });
    })
    </script>
@endslot
@endcomponent
