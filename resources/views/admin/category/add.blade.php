@component('admin.component')
@slot('title') Add category @endslot

@slot('subTitle') add category detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group col-6 err_name">
        <label>Name</label>
        <input type="text" name="name" class="form-control" placeholder="New Category">
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-6 err_module">
        <label>Module</label>
        <select class="form-control h-11" name="module_id">
            <option value="" class="font-medium">select module</option>
            @foreach ($modules as $module)
            <option value="{{ $module->id }}" >{{ $module->name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_module"></span>
    </div>

    <div class="form-group col-6">
        <label><b>Image</b></label>
        <input type="file" name="image"  class="form-control" id="changeImg">
        <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
        <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="ItemImg2" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>

    <div class="mt-4 col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" >Submit</button>
        <a href="{{ route('admin.category.index') }}"><div class="btn btn-light">Cancel</div></a>
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

</script>
@endslot
@endcomponent