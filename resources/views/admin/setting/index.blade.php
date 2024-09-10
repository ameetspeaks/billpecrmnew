@component('admin.component')
@slot('title') Business Setup @endslot
@slot('subTitle') @endslot
@slot('content')

@php $user=\App\Models\User::where("role_type","1")->first(); @endphp

{{-- <div class="col-12 h-11">
    <div class="row items-center justify-between col-12 border-2 border-blue-700 h-full rounded-lg">
        <h1 class="capitalize text-blue-700 font-bold"><i class="fa fa-cog mr-2"></i>Maintenance Mode</h1>
        <label class="switch m-0">
            <input type="checkbox" onchange="statusChange('maintenance_mode')" {{\App\Models\BusinessSetting::where('type','maintenance_mode')->first()->value == '1' ? "checked" : "" }}>
            <span class="slider round"></span>
        </label>
    </div>
</div> --}}
{{-- <h1 class="form-group mt-2">*By turning on maintaince mode all your app and customer side website will be off. Only admin panel and seller panel will be functional</h1> --}}
 

<h4 class="card-title my-3 col-12 p-0"><i class="fa fa-user mr-2"></i> Admin Information</h4>
<form class="row forms-sample w-full" name="userUpadteForm" action="{{ route('admin.setting.updateUser') }}" method="POST" enctype='multipart/form-data'>
    @csrf   
    <div class="form-group col-md-4 col-12 err_fName">
        <label>Name</label>
        <input type="text" name="name" class="form-control" placeholder="First Name" value="{{$user->name}}">
        <input type="hidden" name="id" value="{{$user->id}}">
        <span class="text-xs text-red-500 mt-2 errmsg_fName"></span>
    </div>

    <div class="form-group col-md-4 col-12 err_email">
        <label>Email</label>
        <input type="email" name="email" class="form-control" placeholder="Email" value="{{$user->email}}">
        <span class="text-xs text-red-500 mt-2 errmsg_email"></span>
    </div>

    <div class="form-group col-md-4 col-12 err_number">
        <label>Phone</label>
        <input type="hidden" name="userRole" value="admin">  
        <input type="number" class="form-control" placeholder="Number" name="number" value="{{ $user->whatsapp_no }}">
        <span class="text-xs text-red-500 mt-2 errmsg_number"></span>
    </div>
    

    <div class="form-group col-md-4 col-12 err_image">
        <label>User Image </label>
        <input type="file" class="form-control cursor-pointer" placeholder="User Image" name="image" id="user_image">
        <span class="text-xs text-red-500 mt-2 errmsg_image"></span> 
    </div>

    <div class="col-md-4 col-12  border-2 border-blue-400 px-0 p-2 rounded-lg mt-3">
        <img id="dmImg" src="{{$user->image}}" alt="your image" class="rounded-lg" style="width: 100%" />
    </div>
 

    <h4 class="card-title my-3 col-12 p-0"><i class="fa fa-lock mr-2"></i> Login Information</h4> 

    <div class="form-group col-md-4 col-12 err_password">
        <label>Password </label>
        <input type="text" class="form-control" placeholder="Password" name="password" value="" >
        <span class="text-xs text-red-500 mt-2 errmsg_password"></span>
    </div>

    <div class="form-group col-md-4 col-12 err_password_confirmation">
        <label>Confirm Password </label>
        <input type="text" class="form-control" placeholder="Confirm Password" name="password_confirmation" value="">
        <span class="text-xs text-red-500 mt-2 errmsg_password_confirmation"></span>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitDataUser" >Submit</button>
        <button type="reset" class="btn btn-light">Cancel</button>
    </div>
</form>

  
  
 
<form class="forms-sample row mt-5 w-full" name="formData" action="{{ route('admin.setting.updatesetup') }}" method="POST" enctype='multipart/form-data'>
    @csrf

 


    <input type="hidden" name="status" value="setup">

    <h4 class="card-title p-0 col-12"><i class="fa fa-location-dot mr-2"></i>Version </h4>
    <div class="form-group col-md-4 col-12">
        <label>Current Version Name</label>
        <input type="text" class="form-control" name="version_name" placeholder="Version Name" value="{{\App\Models\AppVersion::first()->name ?? ""}}">
    </div>

  
    <h4 class="card-title p-0 col-12"><i class="fa fa-user mr-2"></i>Company Information</h4>

    <div class="form-group col-md-4 col-12">
        <label>Business Name</label>
        <input type="text" class="form-control" name="name" placeholder="Business Name" value="{{\App\Models\Setting::where('type','company_business_name')->first()->value ?? ""}}">
    </div>

    <div class="form-group col-md-4 col-12">
        <label>Email</label>
        <input type="email" class="form-control" name="email" placeholder="Email" value="{{\App\Models\Setting::where('type','company_email')->first()->value ?? ""}}">
    </div>

    <div class="form-group col-md-4 col-12">
        <label>Phone</label>
        <input type="number" class="form-control" name="phone" placeholder="Phone" value="{{\App\Models\Setting::where('type','company_phone')->first()->value ?? 00}}">
    </div> 

    

    

    <div class="form-group col-md-6 col-12">
        <label>Address</label>
        <textarea class="form-control" name="address">{{\App\Models\Setting::where('type','company_address')->first()->value ?? ""}}</textarea>
    </div>

    <div class="form-group col-md-6 col-12">
        <label>Footer Text</label>
        <input type="text" class="form-control" name="footer_text" placeholder="Footer Text" value="{{\App\Models\Setting::where('type','company_footer_text')->first()->value ?? ""}}">
    </div>

    

    <h4 class="card-title p-0 col-12"><i class="fa fa-location-dot mr-2"></i>Logo & Icon</h4>

    <div class="form-group col-md-6 col-12">
        <label>Logo</label>
        <input type="file" class="form-control" name="logo" id="changeImg1">
        <div class="col-6  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="logoImg" src="{{ asset('public/admin/upload/'.\App\Models\Setting::where('type','company_logo')->first()->value) }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>

    <div class="form-group col-md-6 col-12">
        <label>Fav Icon</label>
        <input type="file" class="form-control" name="fav_icon" id="changeImg2">
        <div class="col-6  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="favImg" src="{{ asset('public/admin/upload/'.\App\Models\Setting::where('type','company_fav_icon')->first()->value) }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>

  
    <div class="col-12 text-right">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
    </div>
</form>


@endslot
@slot('script')
<script>

  // Call Multiple Select
    $(function(){
        selectMultiSelector("d_zone","Select Multiple Zones");
    })

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

    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#favImg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#changeImg1").change(function(){
        readURL1(this);
    })

    $("#changeImg2").change(function(){
        readURL2(this);
    })

</script>

@endslot
@endcomponent

