@component('admin.component')
@slot('title') Edit Addon Item @endslot

@slot('subTitle') Edit Addon detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.addon.update') }}"  method="POST"  enctype='multipart/form-data'>
    @csrf
    <input type="hidden" name="addon_id" value="{{$addon->id}}">
    <div class="form-group col-4 err_name">
        <label>Name</label>
        <input type="text" name="name" class="form-control" placeholder="Name" value="{{$addon->name}}">
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-4 err_discription">
        <label>Description</label>
        <input type="text" name="discription" class="form-control" placeholder="Description" value="{{$addon->discription}}">
        <span class="text-xs text-red-500 mt-2 errmsg_discription"></span>
    </div>

    <div class="form-group col-4 err_package_price">
        <label>Price</label>
        <input type="number" name="price" class="form-control" placeholder="00000" value="{{$addon->price}}">
        <span class="text-xs text-red-500 mt-2 errmsg_package_price"></span>
    </div>

    <div class="form-group col-4">
        <label>Image</label>
        <input type="file" name="image"  class="form-control" id="changeImg">
        <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
        <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="ItemImg2" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>

    <div class="mt-4 col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.addon.index') }}"><div class="btn btn-light">Cancel</div></a>
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

