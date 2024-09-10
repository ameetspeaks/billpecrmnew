@component('admin.component')
@slot('title') Add Marketing Template @endslot

@slot('subTitle') add marketing template detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.template.marketing.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group col-6 err_name">
        <label><b>Template Category</b></label>
        <select class="form-control h-11" name="category_id" required>
            <option value="">Select Category</option>
            @foreach($categories as $categorie)
            <option value="{{$categorie->id}}">{{$categorie->name}}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-6 err_name">
        <label><b>Template Type</b></label>
        <select class="form-control h-11" name="type_id" required>
            <option value="">Select Type</option>
            @foreach($types as $type)
            <option value="{{$type->id}}">{{$type->name}}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-6 err_name">
        <label><b>Template Name</b></label>
        <input type="text" name="name" class="form-control" placeholder="Template Name" required>
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>
    
    <div class="form-group col-6">
        <label><b>Template Image</b></label>
        <input type="file" name="productImage[]"  class="form-control" id="changeImg" multiple required>
        <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
        <!-- <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="ItemImg2" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div> -->
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.template.marketing') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
@endslot
@slot('script')
<script>

    // SHOW IMAGE
    // function readURL(input) {
    //     var image=input.files[0].size;
    //     if(image > 200000) {
    //         $('.errmsg_image').html('File size maximum 200kB.');
    //         $('#changeImg').val('');
    //         $('#ItemImg2').prop('src', null);
    //     }else{
    //         $('.errmsg_image').html('');
    //         if (input.files && input.files[0]) {
    //             var reader = new FileReader();

    //             reader.onload = function (e) {
    //                 $('#ItemImg2').attr('src', e.target.result);
    //             }

    //             reader.readAsDataURL(input.files[0]);
    //         }
    //     }
        
    // }

    // $("#changeImg").change(function(){
    //     readURL(this);
    // })
</script>
@endslot
@endcomponent

