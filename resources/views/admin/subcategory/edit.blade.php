@component('admin.component')
@slot('title')Edit Sub category @endslot

@slot('subTitle')Edit Sub category detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.subcategory.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="subcatid" value="{{$subCat->id}}">
    <div class="form-group col-6 err_module">
        <label>Category</label>
        <select class="form-control h-11" name="categoryId">
            <option value="" class="font-medium">select category</option>
            @foreach ($categorys as $category)
            <option value="{{ $category->id }}" {{$subCat->category_id == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_module"></span>
    </div>

    <div class="form-group col-6 err_name">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{$subCat->name}}" placeholder="New Sub Category">
        <div class="new_textBox">

        </div>
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
        <a href="{{ route('admin.subcategory.index') }}"><div class="btn btn-light">Cancel</div></a>
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

