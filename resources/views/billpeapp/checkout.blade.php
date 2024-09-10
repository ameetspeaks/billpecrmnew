<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>BillPe Billing APP</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/admin/upload/'.\App\Models\Setting::where('type','company_fav_icon')->first()->value) }}" />
	<!-- Vendor CSS -->
	<link href="{{url('public/checkout/css/vendor/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{url('public/checkout/css/vendor/vendor.min.css')}}" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="{{url('public/checkout/css/style.css')}}" rel="stylesheet">
	<!-- Custom font -->
	<link href="fonts/icomoon/icons.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Open%20Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<style>
		.error{
			color: red;
    		font-weight: bold;
		}
</style>
<body class="has-smround-btns has-loader-bg equal-height has-sm-container">

<div class="holder">
	<div class="container">
		<h1 class="text-center">Checkout Accordion</h1>
		@if (\Session::has('message'))
			<div class="alert alert-success">
				<ul>
					<li>{!! \Session::get('message') !!}</li>
				</ul>
			</div>
		@endif
		@if (\Session::has('error'))
			<div class="alert alert-danger">
				<ul>
					<li>{!! \Session::get('error') !!}</li>
				</ul>
			</div>
		@endif
		<br>
		<form method="post" id="checkoutForm">
        @csrf
		<div class="row">
			<div class="col-md-8">
				<div class="panel-group panel-group--style1" id="checkoutAccordion">
					<div class="panel">
						<div class="panel-heading active">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#step1">01. Billing Address</a>
								<span class="toggle-arrow"><span></span><span></span></span>
							</h4>
						</div>
						<div id="step1" data-parent="#checkoutAccordion" class="panel-collapse collapse show">
							<div class="panel-body">
								<div class="panel-body-inside">
									
									<div class="mt-2">
										<label>Name:</label>
										<div class="form-group">
											<input type="text" class="form-control form-control--sm" name="billing_name" id="billing-name" placeholder="Name" value="{{$store->user->name}}">
										</div>
									</div>

									<div class="mt-2">
										<label>Address 1:</label>
										<div class="form-group">
												<input type="text" class="form-control form-control--sm" name="billing_address" id="billing-address" placeholder="Address" value="{{$store->address}}">
										</div>
									</div>
									<div class="row">
										<div class="col-sm-9">
											<label>Latitude:</label>
											<div class="form-group">
												<input type="text" class="form-control form-control--sm" name="billing_latitude" id="billing-latitude" placeholder="Latitude" value="{{$store->latitude}}">
											</div>
										</div>
										<div class="col-sm-9">
											<label>Longitude:</label>
											<div class="form-group">
												<input type="text" class="form-control form-control--sm" name="billing_longitude" id="billing-longitude" placeholder="Longitude" value="{{$store->longitude}}">
											</div>
										</div>
									</div>
									<!-- <div class="mt-2"></div>
									<label>Country:</label>
									<div class="form-group">
										<input type="text" class="form-control form-control--sm" name="billing_country" id="billing-country" placeholder="Country">
									</div> -->
									<div class="row">
										<div class="col-sm-9">
											<label>City:</label>
											<div class="form-group">
												<input type="text" class="form-control form-control--sm" name="billing_state" id="billing-city" placeholder="City" value="{{$store->city}}">
											</div>
										</div>
										<div class="col-sm-9">
											<label>zip/postal code:</label>
											<div class="form-group">
												<input type="text" class="form-control form-control--sm" name="billing_code" id="billing-code" placeholder="Code" value="{{$store->pincode}}">
											</div>
										</div>
									</div>

									<div class="mt-2">
										<label>Gst Number:</label>
										<div class="form-group">
												<input type="text" class="form-control form-control--sm" name="billing_gst" id="billing-gst" placeholder="Gst number" value="{{$store->gst}}">
										</div>
									</div>
									
									<!-- <div class="clearfix">
										<input id="formcheckoutCheckbox1" name="checkbox1" type="checkbox">
										<label for="formcheckoutCheckbox1">Save address to my account</label>
									</div> -->
								</div>
							</div>
						</div>
					</div>
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#step2">02. Shipping Address</a>
								<span class="toggle-arrow"><span></span><span></span></span>
							</h4>
						</div>
						<div id="step2" data-parent="#checkoutAccordion" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="panel-body-inside">
									<div class="clearfix">
										<input id="formcheckoutCheckbox2" name="sameAddressFound" id="sameAddressFound" type="checkbox">
										<label for="formcheckoutCheckbox2" >The same as BIlling address</label>
									</div>
									<div class="mt-2">
										<!-- <div class="col-sm-9"> -->
											<label>Name:</label>
											<div class="form-group">
												<input type="text" class="form-control form-control--sm" name="shipping_name" id="shipping-name" placeholder="Name" value="">
											</div>
										<!-- </div> -->
									</div>
									<div class="mt-2">
										<label>Complete Address:</label>
										<div class="form-group">
												<input type="text" class="form-control form-control--sm" name="shipping_address" id="shipping-address" placeholder="Address" value="">
										</div>
									</div>
									
									<div class="row">
										<div class="col-sm-9">
											<label>City:</label>
											<div class="form-group">
												<input type="text" class="form-control form-control--sm" name="shipping_city" id="shipping-city" placeholder="City" value="">
											</div>
										</div>
										<div class="col-sm-9">
											<label>zip/postal code:</label>
											<div class="form-group">
												<input type="text" class="form-control form-control--sm" name="shipping_code" id="shipping-code" placeholder="Code" value="">
											</div>
										</div>
									</div>
									<div class="mt-2"></div>
									<label>State:</label>
									<div class="form-group">
										<input type="text" class="form-control form-control--sm" name="shipping_state" id="shipping-state" placeholder="State">
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#step3">03. Delivery Methods</a>
								<span class="toggle-arrow"><span></span><span></span></span>
							</h4>
						</div>
						<div id="step3" data-parent="#checkoutAccordion" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="panel-body-inside">
									<div class="clearfix">
										<input id="formcheckoutRadio1" value="" name="radio1" type="radio" class="radio" checked="checked">
										<label for="formcheckoutRadio1">Standard Delivery $2.99 (3-5 days)</label>
									</div>
									<div class="clearfix">
										<input id="formcheckoutRadio2" value="" name="radio1" type="radio" class="radio">
										<label for="formcheckoutRadio2">Express Delivery $10.99 (1-2 days)</label>
									</div>
									<div class="clearfix">
										<input id="formcheckoutRadio3" value="" name="radio1" type="radio" class="radio">
										<label for="formcheckoutRadio3">Same-Day $20.00 (Evening Delivery)</label>
									</div>
									<div class="text-right">
										<button type="button" class="btn btn-sm step-next-accordion">Continue</button>
									</div>
								</div>
							</div>
						</div>
					</div> -->
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" href="#step4">04. Payment Method</a>
								<span class="toggle-arrow"><span></span><span></span></span>
							</h4>
						</div>
						<div id="step4" data-parent="#checkoutAccordion" class="panel-collapse collapse">
							<!-- <div class="panel-body">
								<div class="panel-body-inside">
									<div class="clearfix">
										<input id="formcheckoutRadio4" value="" name="radio2" type="radio" class="radio" checked="checked">
										<label for="formcheckoutRadio4">Credit Card</label>
									</div>
									<div class="clearfix">
										<input id="formcheckoutRadio5" value="" name="radio2" type="radio" class="radio">
										<label for="formcheckoutRadio5">Paypal</label>
									</div>
									<div class="mt-2"></div>
									<label>Cart Number</label>
									<div class="form-group">
										<input type="text" class="form-control form-control--sm">
									</div>
									<div class="row">
										<div class="col-sm-9">
											<label>Month:</label>
											<div class="form-group select-wrapper">
												<select class="form-control form-control--sm">
													<option selected value='1'>January</option>
													<option value='2'>February</option>
													<option value='3'>March</option>
													<option value='4'>April</option>
													<option value='5'>May</option>
													<option value='6'>June</option>
													<option value='7'>July</option>
													<option value='8'>August</option>
													<option value='9'>September</option>
													<option value='10'>October</option>
													<option value='11'>November</option>
													<option value='12'>December</option>
												</select>
											</div>
										</div>
										<div class="col-sm-9">
											<label>Year:</label>
											<div class="form-group select-wrapper">
												<select class="form-control form-control--sm">
													<option value="2019">2019</option>
													<option value="2020">2020</option>
													<option value="2021">2021</option>
													<option value="2022">2022</option>
													<option value="2023">2023</option>
													<option value="2024">2024</option>
												</select>
											</div>
										</div>
									</div>
									<div class="mt-2">
										<label>CVV Code</label>
										<div class="form-group">
											<input type="text" class="form-control form-control--sm">
										</div>
									</div>
									<div class="clearfix mt-2">
										<button type="submit" class="btn btn--lg w-100 placeOrder" >Place Order</button>
									</div>
								</div>
							</div> -->
							<div class="clearfix mt-2">
								<button type="submit" class="btn btn--lg w-100 placeOrder" >Place Order</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-10 pl-lg-8 mt-2 mt-md-0">
				<h2 class="custom-color">Order Summary</h2>
				<div class="cart-table cart-table--sm pt-3 pt-md-0">
                <div class="cart-table-prd cart-table-prd--head py-1 d-none d-md-flex">
                    <div class="cart-table-prd-image text-center">
                        Image
                    </div>
                    <div class="cart-table-prd-content-wrap">
                        <div class="cart-table-prd-qty">Name</div>
                        <div class="cart-table-prd-info">Discription</div>
                        <div class="cart-table-prd-price">Price</div>
                    </div>
                </div>
				<input type="hidden" name="package_id" value="{{$package->id}}">
                <div class="cart-table-prd">
                    <div class="cart-table-prd-image">
                        <a href="#" class="prd-img"><img class="lazyload fade-up" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="{{$package->image}}" alt=""></a>
                    </div>
                    <div class="cart-table-prd-content-wrap">
						<input type="hidden" name="product[id]" id="checkoutproductID" value="{{$package->id}}">
                        <div class="cart-table-prd-qty">
                            <div class="qty qty-changer">
								<input type="hidden" name="product[name]" id="checkoutproductID" value="{{$package->name}}"><h2 class="cart-table-prd-name">{{$package->name}}</h2>
                            </div>
                        </div>
						<div class="cart-table-prd-info">
							<input type="hidden" name="product[discription]" id="checkoutdiscription" value="{{$package->discription}}"><span>{{$package->discription}}</span>
                        </div>
						<input type="hidden" name="product[price]" id="subscriptionRate" value="{{$package->subscription_price}}">
                        <div class="cart-table-prd-price-total">
							₹{{$package->subscription_price}}
                        </div>
                    </div>
                </div>
            </div>
				<div class="mt-2"></div>
				<div class="card">
					<div class="card-body">
						<h3>Apply Promocode</h3>
						<p>Got a promo code? Then you're a few randomly combined numbers & letters away from fab savings!</p>
                        <div class="form-inline mt-2">
							<input type="hidden" name="coupanAmount"  id="coupanAmount"> 
                            <input type="text" class="form-control form-control--sm" placeholder="Promotion/Discount Code" name="copanCode" id="coupanCode">
                            <button type="button" class="btn applyCoupan">Apply</button>
                        </div>
						<span id="errorCoupan" class="error"></span>
					</div>
				</div>
				<div class="mt-2"></div>
				<div class="cart-total-sm coupanAmountShow">
					
				</div>
				<div class="mt-2"></div>
				<div class="cart-total-sm">
					<span>GST (18%)</span> 
					<span class="cart-table-prd-price-total">₹<span id="gstamount">{{$package->subscription_price * 18/100 }}</span></span>
				</div>
				<div class="mt-2"></div>
				<div class="cart-total-sm">
					<span>Subtotal</span>
					<?php $totaldecialreove = number_format($package->subscription_price + $package->subscription_price * 18/100 , 2, '.', ','); ?>
					<input type="hidden" name="TotalAmount"  id="TotalAmount" value="{{$totaldecialreove}}"> 
					<span class="card-total-price">₹<span id="subtotal" >{{$totaldecialreove}}</span></span>
				</div>
				<div class="mt-2"></div>
				<div class="card">
					<div class="card-body">
						<h3>Order Comment</h3>
						<textarea class="form-control form-control--sm textarea--height-100" placeholder="Place your comment here" name="order_comment"></textarea>
						<div class="card-text-info mt-2">
							<p>*Savings include promotions, coupons, rueBUCKS, and shipping (if applicable).</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	</div>
</div>

<script src="{{url('public/checkout/js/vendor-special/lazysizes.min.js')}}"></script>
<script src="{{url('public/checkout/js/vendor-special/ls.bgset.min.js')}}"></script>
<script src="{{url('public/checkout/js/vendor-special/ls.aspectratio.min.js')}}"></script>
<script src="{{url('public/checkout/js/vendor-special/jquery.min.js')}}"></script>
<script src="{{url('public/checkout/js/vendor-special/jquery.ez-plus.js')}}"></script>
<script src="{{url('public/checkout/js/vendor-special/instafeed.min.jsy')}}"></script>
<script src="{{url('public/checkout/js/vendor/vendor.min.js')}}"></script>
<script src="{{url('public/checkout/js/app-html.js')}}"></script>

</body>

<script>
	$('input[name="sameAddressFound"]').on('change', function() {
		var checkBoxes = $('input[name="sameAddressFound"]');
		$('#shipping-name').val(' ');
		$('#shipping-city').val(' ');
		$('#shipping-code').val(' ');
		$('#shipping-address').val(' ');
		$('#shipping-state').val(' ');
		if(checkBoxes.prop("checked")==true){
			var name = $('#billing-name').val();
			var city = $('#billing-city').val();
			var code = $('#billing-code').val();
			var address = $('#billing-address').val();
	
			$('#shipping-name').val(name);
			$('#shipping-city').val(city);
			$('#shipping-code').val(code);
			$('#shipping-address').val(address);
		}
	});

	$(document).on('click', '.applyCoupan', function(){
		var coupanCode = $('#coupanCode').val();
		var subscriptionRate = $('#subscriptionRate').val();
		
		$('#errorCoupan').text(' ');
		if(coupanCode){
			$.ajax({
                url: "{{ route('getCoupanByCode') }}",
                method: 'post',
                data: { "_token" : "{{csrf_token()}}", 'coupanCode': coupanCode},
                success: function(data){
                    console.log(data)
					$('.coupanAmountShow').empty();

					if(data.success == true)
					{
						if(parseInt(subscriptionRate) > data.coupan.minimum_purchase){
							totalbydiscountamount = data.coupan.discount;
							if (data.coupan.discountType == '%') {
								totalbydiscountamount = parseInt(subscriptionRate) * data.coupan.discount/100;
							}
							var totalrate  = parseInt(subscriptionRate) - totalbydiscountamount;
							var totaldecimalamount = totalrate + totalrate*18/100;
							totalgst = totalrate * 18/100;
							$('#gstamount').text( totalgst.toFixed(2) );
							$('#subtotal').text( totaldecimalamount.toFixed(2) );
							$('#TotalAmount').val( totaldecimalamount.toFixed(2) );
							$('#coupanAmount').val(totalbydiscountamount.toFixed(2));
							$('.applyCoupan').attr('disabled', true);

							var coupan = '<span>Coupan Amount</span>'+ 
										  '<span class="cart-table-prd-price-total">₹<span id="gstamount">'+totalbydiscountamount+'</span></span>';
							$('.coupanAmountShow').append(coupan);
						}else{
							$('#errorCoupan').text("Your total amount is less of minimum purchase amount "  +data.coupan.minimum_purchase);
						}
					}else{
						$('#errorCoupan').text(data.message);
					}
                }
            });
		}else{
			$('#errorCoupan').text('Enter your coupan code.');
		}
	})

	$('.placeOrder').click(function(){
		$('form#checkoutForm').submit();
	})
</script>
</html>