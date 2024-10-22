@component('admin.component')
@slot('title') Add Manual Subscription @endslot
@slot('subTitle') Manual Subscription details @endslot
@slot('content')


@can('Create Store')
<div class="text-right col-12">
    <a href="{{ route('admin.store.addManualPayment') }}"><button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Add store</button></a> 
</div>
@endcan

<form class="row forms-sample w-full" action="{{ route('admin.store.addManualPayment') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <?php 
        $orderid = 'order_'.rand(1111111111,9999999999);
    ?>
    <div class="row forms-sample w-full">
        <div class="form-group col-4">
            <select class="form-control js-example-basic-single" id="selectstore" name="store_data" required>
                <option value="">Select Store</option>
                @foreach($stores as $store)
                <option data-id="{{$store->id}}" value="{{$store}}">{{$store->shop_name}}</option>
                @endforeach
            </select>
        </div>
    </div>


    {{-- TRANSECTION DETAILS INFORMATION --}}
    <h4 class="card-title  col-12 mt-4">TRANSECTION DETAILS</h4>

    <div class="form-group col-4 err_payment_id">
        <label>Payment ID</label>
        <input type="text" class="form-control" name="payment_id" placeholder="Payment Id" required>
        <span class="text-xs text-red-500 mt-2 err_payment_id"></span>
    </div>

    <div class="form-group col-4 err_order_id">
        <label>Order ID</label>
        <input type="text" class="form-control" name="order_id" placeholder="Order Id" value="{{$orderid}}" readonly>
        <span class="text-xs text-red-500 mt-2 err_order_id"></span>
    </div>

    <div class="form-group col-4 err_order_amount">
        <label>Order Amount</label>
        <input type="text" class="form-control" name="order_amount" placeholder="Order Amount" required>
        <span class="text-xs text-red-500 mt-2 err_order_amount"></span>
    </div>

    <div class="form-group col-4 err_payment_amount">
        <label>Payment Amount</label>
        <input type="text" class="form-control" name="payment_amount" placeholder="Payment Amount" required>
        <span class="text-xs text-red-500 mt-2 err_payment_amount"></span>
    </div>

    <div class="form-group col-4 err_payment_type">
        <label>Payment Type</label>
        <input type="text" class="form-control" name="payment_type" placeholder="Payment Type" required>
        <span class="text-xs text-red-500 mt-2 err_payment_type"></span>
    </div>

    {{-- ORDER DETAILS --}}
    <h4 class="card-title  col-12 mt-4">Package Detail</h4>
    
    <div class="form-group col-6 err_subscription_package">
        <label>Subscription Package</label>
        <select class="form-control js-example-basic-single" name="package_id" id="package_id" required>
            <option value="">Select package</option>
            @foreach($subcr_package as $subcr_pack)
            <?php $price =  round((int)$subcr_pack->subscription_price + (int)$subcr_pack->subscription_price*18/100) ?>

            <option data-value="{{$subcr_pack->subscription_price}}" value="{{$subcr_pack->id}}">{{$subcr_pack->name}} - {{$price}}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_subscription_package"></span>
    </div>

    <div class="form-group col-6 err_coupanCode">
        <label>Coupan Code</label>
        <input type="text" name="coupanCode" class="form-control" id="applyCoupan" placeholder="Coupan Code">
        <span class="text-xs text-red-500 mt-2 errmsg_coupanCode"></span>
    </div>

    <div class="form-group col-6 errmsg_coupanAmount">
        <label>Coupan Amount</label>
        <input type="text" name="coupanAmount" class="form-control" id="coupanAmount" placeholder="Coupan Amount">
        <span class="text-xs text-red-500 mt-2 errmsg_coupanAmount"></span>
    </div>

    <h4 class="card-title  col-12 mt-4">Billing Address</h4>

    <div class="form-group col-6 err_billing_name">
        <label>Billing Name</label>
        <input type="text" name="billing_name" id="billing_name" class="form-control" placeholder="Biling Name">
        <span class="text-xs text-red-500 mt-2 errmsg_billing_name"></span>
    </div>

    <div class="form-group col-6 err_billing_address">
        <label>Billing address</label>
        <input type="text" name="billing_address" id="billing_address" class="form-control" placeholder="Billing Address">
        <span class="text-xs text-red-500 mt-2 errmsg_billing_address"></span>
    </div>

    <div class="form-group col-6 err_billing_city">
        <label>City</label>
        <input type="text" name="billing_city" id="billing_city" class="form-control" placeholder="City">
        <span class="text-xs text-red-500 mt-2 err_billing_city"></span>
    </div>

    <div class="form-group col-6 err_billing_code">
        <label>Pin Code</label>
        <input type="text" name="billing_pincode" id="billing_pincode" class="form-control" placeholder="Pin Code">
        <span class="text-xs text-red-500 mt-2 err_billing_code"></span>
    </div>

    <div class="form-group col-6 err_billing_gst">
        <label>Gst Number</label>
        <input type="text" name="billing_gst" id="billing_gst" class="form-control" placeholder="Gst Number">
        <span class="text-xs text-red-500 mt-2 err_billing_gst"></span>
    </div>

    <h4 class="card-title  col-12 mt-4">Shipping Address</h4>

    <div class="form-group col-12">
        <input id="formcheckoutCheckbox2" name="sameAddressFound" id="sameAddressFound" type="checkbox">
        <label for="formcheckoutCheckbox2" >The same as BIlling address</label>
    </div>

    <div class="form-group col-6 err_shipping_name">
        <label>Shipping Name*</label>
        <input type="text" name="shipping_name" id="shipping_name" class="form-control" placeholder="Shipping Name" required>
        <span class="text-xs text-red-500 mt-2 errmsg_shipping_name"></span>
    </div>

    <div class="form-group col-6 err_Shipping_address">
        <label>Shipping address</label>
        <input type="text" name="shipping_address" id="shipping_address" class="form-control" placeholder="Shipping Address" required>
        <span class="text-xs text-red-500 mt-2 errmsg_Shipping_address"></span>
    </div>

    <div class="form-group col-6 err_shipping_city">
        <label>City</label>
        <input type="text" name="shipping_city" id="shipping_city" class="form-control" placeholder="City" required>
        <span class="text-xs text-red-500 mt-2 err_shipping_city"></span>
    </div>

    <div class="form-group col-6 err_shipping_state">
        <label>State</label>
        <input type="text" name="shipping_state" id="shipping_state" class="form-control" placeholder="State" required>
        <span class="text-xs text-red-500 mt-2 err_shipping_state"></span>
    </div>

    <div class="form-group col-6 err_shipping_code">
        <label>Pin Code</label>
        <input type="text" name="shipping_pincode" id="shipping_pincode" class="form-control" placeholder="Pin Code" requireds>
        <span class="text-xs text-red-500 mt-2 err_shipping_code"></span>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <!-- <a href="{{ route('admin.store.index') }}"><div class="btn btn-light">Cancel</div></a> -->
    </div>
   

</form>

<script>

    $(document).ready(function(){
        $(document).on('change', '#selectstore', function(){
            var storedata = $(this).val();
            storedata = JSON.parse(storedata);

            $('#billing_name').val(storedata.user.name);
            $('#billing_address').val(storedata.address);
            $('#billing_city').val(storedata.city);
            $('#billing_pincode').val(storedata.pincode);
            console.log(storedata)
        })
    })
    

    $('input[name="sameAddressFound"]').on('change', function() {
		var checkBoxes = $('input[name="sameAddressFound"]');
		$('#shipping_name').val(null);
		$('#shipping_city').val(null);
		$('#shipping_code').val(null);
		$('#shipping_address').val(null);
		$('#shipping_state').val(null);
		if(checkBoxes.prop("checked")==true){
			var name = $('#billing_name').val();
			var city = $('#billing_city').val();
			var code = $('#billing_pincode').val();
			var address = $('#billing_address').val();
            
            $('#shipping_name').val(name);
            $('#shipping_city').val(city);
            $('#shipping_pincode').val(code);
            $('#shipping_address').val(address);
		}
	});

    $('#applyCoupan').keyup(function(){
		var coupanCode = $(this).val();
		var package_amount = $('#package_id').find(':selected').data('value');
		var store_id = $('#selectstore').find(':selected').data('id');
		
        if(package_amount){
            $('.errmsg_subscription_package').text(' ');
            $('.errmsg_coupanCode').text(' ');
            $('#coupanAmount').val(' ');
            $.ajax({
                    url: "{{ route('admin.store.getCoupanByCode') }}",
                    method: 'post',
                    data: { "_token" : "{{csrf_token()}}", 'coupanCode': coupanCode, 'store_id': store_id},
                    success: function(data){
                        console.log(data)
                       
                        if(data.success == true)
                        {
                            if(parseInt(package_amount) > data.coupan.minimum_purchase){

                                totalbydiscountamount = data.coupan.discount;
                                if (data.coupan.discountType == '%') {
                                    totalbydiscountamount = parseInt(package_amount) * data.coupan.discount/100;
                                }
                                $('#coupanAmount').val(totalbydiscountamount.toFixed(2));
                            }else{
                                $('.errmsg_coupanCode').text("Your total amount is less of minimum purchase amount "  +data.coupan.minimum_purchase);
                            }
                        }else{
                            $('.errmsg_coupanCode').text(data.message);
                        }
                    }
                });
        }else{
            $('.errmsg_subscription_package').text('Select package.');
        }
	})

</script>
@endslot
@slot('script')

@endslot
@endcomponent

