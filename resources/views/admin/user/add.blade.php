@component('admin.component')
@slot('title') Add New User @endslot
@slot('subTitle') Add User @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- User INFORMATION --}}
    <h4 class="card-title  col-12 mt-4">User Information</h4>

    <div class="form-group col-4 err_f_name">
        <label>Name</label>
        <input type="text" class="form-control" name="name" placeholder="Name">
        <span class="text-xs text-red-500 mt-2 errmsg_f_name"></span>
    </div>

    <div class="form-group col-4 err_phone">
        <label>Role*</label>
        <select class="form-control h-11" name="role_type">
            <option value="" class="font-medium">select module</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" >{{ $role->name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_role_type"></span>
    </div>

    <div class="form-group col-4 err_phone">
        <label>Whatsapp Number*</label>
        <input type="number" class="form-control" name="whatsapp_no" placeholder="Whatsapp number" required>
        <span class="text-xs text-red-500 mt-2 errmsg_phone"></span>
    </div>

    <div class="form-group col-4 err_email">
        <label>Email</label>
        <input type="email" class="form-control" name="email" placeholder="Email">
        <span class="text-xs text-red-500 mt-2 errmsg_email"></span>
    </div>
   
    <div class="form-group col-4 err_password">
        <label>Password</label>
        <input type="password" class="form-control" name="password" placeholder="5+ characters required">
        <span class="text-xs text-red-500 mt-2 errmsg_password"></span>
    </div>

    <div class="form-group col-4 err_image">
        <label>Owner Image</label>
        <input type="file" name="image" class="form-control cursor-pointer" id="changeImg1">
        <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
        <div class="col-4  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="logoImg" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>

    <div class="form-group col-4 err_aadhar">
        <label>Aadhar Number</label>
        <input type="text" class="form-control" name="aadhar_number" placeholder="Aaddar Number">
        <span class="text-xs text-red-500 mt-2 err_aadhar"></span>
    </div>
   
    <div class="form-group col-4 err_driving_licence">
        <label>Driving Licence</label>
        <input type="password" class="form-control" name="driving_licence" placeholder="Driving Licence">
        <span class="text-xs text-red-500 mt-2 err_driving_licence"></span>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.user.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
   

</form>
@endslot
@slot('script')
<script>
    // SHOW IMAGE
    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#logoImg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#changeImg1").change(function(){
        readURL1(this);
    })


</script>

@endslot
@endcomponent

