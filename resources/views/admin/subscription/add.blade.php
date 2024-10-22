@component('admin.component')
@slot('title') Add Subscription @endslot

@slot('subTitle') add Subscription detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.subscription.store') }}"  method="POST"  enctype='multipart/form-data'>
    @csrf
    <div class="form-group col-4 err_name">
        <label>Name</label>
        <input type="text" name="name" class="form-control" placeholder="Name">
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-4 err_discription">
        <label>Description</label>
        <input type="text" name="discription" class="form-control" placeholder="Description">
        <span class="text-xs text-red-500 mt-2 errmsg_discription"></span>
    </div>

    <div class="form-group col-4 err_package_price">
        <label>Package Price</label>
        <input type="text" name="package_price" class="form-control" placeholder="00000">
        <span class="text-xs text-red-500 mt-2 errmsg_package_price"></span>
    </div>

    <div class="form-group col-4 err_discount_price">
        <label>Discount Price</label>
        <input type="text" name="discount_price" class="form-control" placeholder="00000">
        <span class="text-xs text-red-500 mt-2 err_discount_price"></span>
    </div>

   
    <div class="form-group col-4 err_validity">
        <label>Validities in Days</label>
        <input type="number" name="validity" class="form-control" placeholder="00000">
        <span class="text-xs text-red-500 mt-2 errmsg_validity"></span>
    </div>

    <div class="form-group col-4">
        <label>Image</label>
        <input type="file" name="subscriptionImage"  class="form-control" id="changeImg">
        <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
        <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="ItemImg2" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>

    <h4 class="card-title mb-6 col-12 p-0">Extra Benefits :</h4>

    <div class="form-group col-4 err_benefits">
        <label>Benefits</label>
        <input type="text" name="benefits" class="form-control" placeholder="e.g., value1, value2, value3">
        <span class="text-xs text-red-500 mt-2 err_benefits"></span>
    </div>

    <div class="form-group col-4 err_term_condition">
        <label>Terms & Condition</label>
        <input type="text" name="term_condition" class="form-control" placeholder="Term and Condition">
        <span class="text-xs text-red-500 mt-2 err_term_condition"></span>
    </div>

    <div class="form-group col-4 err_offer">
        <label>Offer</label>
        <input type="text" name="offer" class="form-control" placeholder="Offer">
        <span class="text-xs text-red-500 mt-2 err_offer"></span>
    </div>

    <div class="form-group col-4 err_extra_brand_coupan">
        <label>Extra Brand Coupan No.</label>
        <input type="text" name="extra_brand_coupan" class="form-control" placeholder="Extra Brand Coupan No">
        <span class="text-xs text-red-500 mt-2 err_extra_brand_coupan"></span>
    </div>

    <div class="form-group col-4 err_coupan_title">
        <label>Coupan Title</label>
        <input type="text" name="coupan_title" class="form-control" placeholder="Coupan Title">
        <span class="text-xs text-red-500 mt-2 err_coupan_title"></span>
    </div>

    <div class="form-group col-4">
        <label>Extra Coupan Logo</label>
        <input type="file" name="coupan_logo"  class="form-control" id="changeCoupanLogo">
        <span class="text-xs text-red-500 mt-2 err_coupan_logo"></span>
        <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="ItemImgLogo" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div>
    </div>

    <div class="mt-4 col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.subscription.index') }}"><div class="btn btn-light">Cancel</div></a>
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

    $("#changeCoupanLogo").change(function(){
        readURLogo(this);
    })

    function readURLogo(input) {
        var image=input.files[0].size;
        if(image > 200000) {
            $('.errmsg_image').html('File size maximum 200kB.');
            $('#changeImg').val('');
            $('#ItemImgLogo').prop('src', null);
        }else{
            $('.errmsg_image').html('');
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#ItemImgLogo').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        
    }

</script>
@endslot
@endcomponent

