<?php $page = 'pos'; ?>
@extends('store.storeAdmin.layout.mainlayout')
@section('content')
<style>
input[type=radio] {
    border: 0px;
    width: 40px;
    height: 1em;
}

</style>
    <div class="page-wrapper pos-pg-wrapper ms-0">
        <div class="content pos-design p-0">
            

            <div class="row align-items-start pos-wrapper">
                <div class="col-md-12 col-lg-8">
                    <!-- <div class="btn-row d-sm-flex align-items-center">
                        <div style="font-size:20px">
                            Retail<input type="radio" name="Q2" class="MyToggle" value="1" checked> Wholesale<input type="radio" name="Q2" class="MyToggle"  value="0"/>
                        </div>
                    </div> -->
                    <div class="pos-categories tabs_wrapper">
                    <div class="row">
                        <div class="col-md-4">
                            <input class="form-control" type="search" id="searchProductByname" name="searchProductByname" onkeyup="searchProductByname(this)" placeholder="Product search by name">
                        </div>

                        <div class="col-md-4">
                            <input class="form-control" type="text" id="searchProductBybarcode" name="searchProductBybarcode" onchange="searchProductBybarcode(this)" placeholder="Product search by barcode">
                        </div>
                        <span class="errorShow" style="color:red;"></span>
                    </div> 
                        <h5>Categories</h5>
                        <p>Select From Below Categories</p>
                           
                        <ul class="tabs owl-carousel pos-category">
                            <li class="categoryProduct" data-id="all">
                                <!-- <a href="javascript:void(0);">
                                    <img src="{{ URL::asset('/public/build/img/categories/category-01.png') }}" alt="Categories">
                                </a> -->
                                <h6>All Categories</h6>
                                <span>{{count($products)}} Items</span>
                            </li>
                            @foreach($categories as $categorie)
                            <li class="categoryProduct" data-id="{{$categorie->id}}">
                                <h6>{{$categorie->name}}</h6>
                                <span>{{$categorie->products_by_store_count}} Items</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="pos-products">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-3 textChange">Products</h5>
                            </div>
                            <div class="tabs_container searchProduct">
                                <div class="tab_content active" data-tab="all">
                                    <div class="row addbyseach">
                                        @foreach($products as $product)
                                        <?php $firstLetter = mb_substr($product->product_name, 0, 1);
                                        if($product->retail_price)
                                        {
                                            $product->mrp = $product->retail_price;
                                        }
                                        ?>
                                        <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">
                                            <div class="product-info default-cover card">
                                                @if($product->product_image)
                                                    <a href="javascript:void(0);" class="img-sm">
                                                        <img src="{{$product->product_image}}"
                                                            alt="Products">
                                                        <span><i data-feather="check" class="feather-16"></i></span>
                                                    </a>
                                                @else
                                                    <button type="button" class="btn btn-light">{{$firstLetter}}</button>
                                                @endif
                                                @if($product->productCategory)
                                                <h6 class="cat-name"><a href="javascript:void(0);">{{$product->productCategory->name}}</a></h6>
                                                @endif
                                                <h6 class="product-name"><a href="javascript:void(0);">{{$product->product_name}}</a>
                                                </h6>
                                                <div class="d-flex align-items-center justify-content-between price">
                                                    <span>{{$product->stock}} Pcs</span>
                                                    <p>₹{{$product->mrp}}</p>
                                                </div>
                                                <button class="btn btn-success btn-sm addtoBill" data-id="{{$product->id}}" data-image="{{$product->product_image}}" data-name="{{$product->product_name}}" data-mrp="{{$product->mrp}}" data-qty="{{$product->quantity}}"  data-stock="{{$product->stock}}">Add to purchase</button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                              
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 ps-0">
                    <div>
                        <div style="font-size:20px">
                            Retail<input type="radio" name="storeUsercheck" class="MyToggle" value="1" checked> Wholesale<input type="radio" name="storeUsercheck" class="MyToggle"  value="0"/>
                        </div>
                    </div>
                    <aside class="product-order-list">
                        <div class="head d-flex align-items-center justify-content-between w-100">
                            <div class="">
                                <h5>Order List</h5>
                                <span>Transaction ID : #65565</span>
                            </div>
                            <div class="">
                                <a class="confirm-text" href="javascript:void(0);"><i data-feather="trash-2"
                                        class="feather-16 text-danger"></i></a>
                                <a href="javascript:void(0);" class="text-default"><i data-feather="more-vertical"
                                        class="feather-16"></i></a>
                            </div>
                        </div>
                        <div class="customer-info block-section">
                            <h6>Customer Information</h6>
                            <div class="input-block d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <select class="js-example-basic-single form-control showCustomer">
                                        <option value="">Select Customer</option>
                                        @foreach($customers as $customer)
                                        <option value="{{$customer->name}}"  data-number="{{$customer->whatsapp_no}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <a href="#" class="btn btn-primary btn-icon" data-bs-toggle="modal"
                                    data-bs-target="#create"><i data-feather="user-plus" class="feather-16"></i></a>
                            </div>
                        </div>

                        <div class="product-added block-section">
                            <div class="head-text d-flex align-items-center justify-content-between">
                                <h6 class="d-flex align-items-center mb-0">Product Added<span class="count">0</span></h6>
                                <a href="javascript:void(0);" class="d-flex align-items-center text-danger clearAll"><span
                                        class="me-1"><i data-feather="x" class="feather-16"></i></span>Clear all</a>
                            </div>
                            <div class="product-wrap" id="product_addon">
                               
                            </div>
                        </div>
                        <div class="block-section">
                            <div class="selling-info">
                                <div class="row">
                                    <div class="col-12 col-sm-8">
                                        <div class="input-block">
                                            <input class="form-control" type="number" id="discountAmount" value="0" placeholder="Discount">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="input-block">
                                        <div class="btn-group col-6 " role="group">
                                            <label class="btn btn-outline-success" for="option-1"><input class="discount_type" type="radio" value="₹" name="discount_type" checked>₹</label>
                                            <label class="btn btn-outline-success" for="option-3"><input class="discount_type" type="radio" value="%" name="discount_type" >%</label>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-total">
                                <table class="table table-responsive table-borderless">
                                    <tr>
                                        <td>Sub Total</td>
                                        <td class="text-end">₹<span class="subtotal">0</span></td>
                                    </tr>
                                    <tr>
                                        <td class="danger">Discount <span class="discountText">(0)</span></td>
                                        <td class="danger text-end">₹<span class="discount">0</span></td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td class="text-end">₹<span class="total">0</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="block-section payment-method">
                            <h6>Payment Method</h6>
                            <input type="hidden" value="" id="payment_method" name="payment_method">
                            <div class="row d-flex align-items-center justify-content-center">
                                <div class="col-md-6 col-lg-4 item">
                                    <div class="default-cover">
                                        <a href="javascript:void(0);" class="methods">
                                            <img src="{{ URL::asset('/public/build/img/icons/cash-pay.svg')}}"
                                                alt="Payment Method">
                                            <span id="methodsValue">Cash</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 item">
                                    <div class="default-cover">
                                        <a href="javascript:void(0);" class="methods">
                                            <img src="{{ URL::asset('/public/build/img/icons/credit-card.svg')}}"
                                                alt="Payment Method">
                                            <span id="methodsValue">Debit Card</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 item">
                                    <div class="default-cover">
                                        <a href="javascript:void(0);" class="methods">
                                            <img src="{{ URL::asset('/public/build/img/icons/qr-scan.svg')}}" alt="Payment Method">
                                            <span id="methodsValue">Scan</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid btn-block">
                            <a class="btn btn-secondary" href="javascript:void(0);">
                                Grand Total : ₹<span class="grandtotal">0</span>
                            </a>
                        </div>
                        <span id="billerror" style="color:red;"></span>
                        <div class="btn-row d-sm-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);" class="btn btn-info btn-icon flex-fill"
                                data-bs-toggle="modal" data-bs-target="#hold-order"><span
                                    class="me-1 d-flex align-items-center"><i data-feather="pause"
                                        class="feather-16"></i></span>Hold</a>
                            <a href="javascript:void(0);" class="btn btn-danger btn-icon flex-fill"><span
                                    class="me-1 d-flex align-items-center"><i data-feather="trash-2"
                                        class="feather-16"></i></span>Void</a>
                            <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill payment"><span
                                    class="me-1 d-flex align-items-center "><i data-feather="credit-card"
                                        class="feather-16"></i></span>Payment</a>
                        </div>

                    </aside>
                </div>
            </div>
        </div>
    </div>


     <!-- Add Inventory -->
     <div class="modal fade" id="add-inventory-product">
        <div class="modal-dialog modal-dialog-centered custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Quick Add Product</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <b id="product_name"></b>
                            <input type="hidden" name="product_id" id="product_id">
                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" required>
                                <span id="error-msgstock" style="color:red;"></span>
                            </div>
                            <div class="modal-footer-btn">
                                <a href="javascript:void(0);" class="btn btn-cancel me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <a href="javascript:void(0);" class="btn btn-submit quickAdd">Submit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Inventory -->

    <!-- Add Customer -->
    <div class="modal fade" id="create">
        <div class="modal-dialog modal-dialog-centered custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Add Customer</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <div class="mb-3">
                                <label class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="customer_name" required>
                                <span id="error-msgCustomername" style="color:red;"></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Customer Number</label>
                                <input type="number" class="form-control" id="customer_number" required>
                                <span id="error-msgCustomerNumber" style="color:red;"></span>
                            </div>
                            <div class="modal-footer-btn">
                                <a href="javascript:void(0);" class="btn btn-cancel me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <a href="javascript:void(0);" class="btn btn-submit customerAdd">Submit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Customer -->

    <!-- Payment Completed -->
    <div class="modal fade modal-default" id="payment-completed" aria-labelledby="payment-completed">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <form action="pos">
                        <div class="icon-head">
                            <a href="{{ url('pos-design') }}">
                                <i data-feather="check-circle" class="feather-40"></i>
                            </a>
                        </div>
                        <input type="hidden"  name="invoiceurl" id="invoiceUrl"> 
                        <h4>Payment Completed</h4>
                        <p class="mb-0">Do you want to Print Receipt for the Completed Order</p>
                        <div class="modal-footer d-sm-flex justify-content-between">
                            <button type="button" class="btn btn-primary flex-fill reciept">Print Receipt<i
                                    class="feather-arrow-right-circle icon-me-5"></i></button>
                            <button type="submit" class="btn btn-secondary flex-fill" data-bs-dismiss="modal">Next Order<i
                                    class="feather-arrow-right-circle icon-me-5"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Payment Completed -->

    <!-- product discount -->
    <div class="modal fade" id="product-discount">
        <div class="modal-dialog modal-dialog-centered custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Add Discount</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <b id="product_name"></b>
                            <input type="hidden" name="product_id" id="product_iddiscountmodel">
                            <div class="mb-3">
                                <b>Product Price : ₹ <span id="productTotalAmount"></span></b><br>
                                <b>Discount Price : ₹ <span id="productDiscountAmount">0</span></b>

                                <div class="row">
                                    <div class="col-12 col-sm-8">
                                        <div class="input-block">
                                            <input class="form-control" type="number" id="productdiscountAmount" value="0" placeholder="Discount">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="input-block">
                                        <div class="btn-group col-6 " role="group">
                                            <label class="btn btn-outline-success" for="option-1"><input class="product_discount_type" type="radio" value="₹" name="product_discount_type" checked>₹</label>
                                            <label class="btn btn-outline-success" for="option-3"><input class="product_discount_type" type="radio" value="%" name="product_discount_type" >%</label>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer-btn">
                                <a href="javascript:void(0);" class="btn btn-cancel me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <a href="javascript:void(0);" class="btn btn-submit addproductDiscount">Submit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- product discount -->
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            
        });

        $(document).on('click', '.MyToggle', function(){
            clear();
            var togglevalue = $(this).val();
            var catid = 'all';
            console.log(catid, togglevalue)
            $('#global-loader').show();
            if(catid)
            {
                $.ajax({
                    url: "{{ route('store.pos.getProductByCategory') }}",
                    method: 'post',
                    data: { "_token" : "{{csrf_token()}}", 'catid': catid },
                    success: function(data){
                        console.log(data)
                        $('#global-loader').hide();
                        $('.addbyseach').empty();
                        if(data.success == true)
                        {
                            $.each(data.Product, function(index, value){ 

                                if(togglevalue == 0){
                                    if(value.wholesale_price){
                                        value.mrp = value.wholesale_price;
                                    }
                                }else if(togglevalue == 1){
                                    if(value.retail_price){
                                        value.mrp = value.retail_price;
                                    }
                                }
                                console.log(value) 
                                var firstLetter = value.product_name.slice(0,1);
                                var image = '<button type="button" class="btn btn-light">'+firstLetter+'</button>';
                                if(value.product_image)
                                {
                                    image = '<a href="javascript:void(0);" class="img-sm"><img src="'+value.product_image+'"alt="Products"><span><i data-feather="check" class="feather-16"></i></span></a>';
                                }
                                product = 
                                        '<div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">'+
                                            '<div class="product-info default-cover card">'+
                                                image+
                                                '<h6 class="cat-name"><a href="javascript:void(0);">'+value.product_category.name+'</a></h6>'+
                                                '<h6 class="product-name"><a href="javascript:void(0);">'+value.product_name+'</a>'+
                                                '</h6>'+
                                                '<div class="d-flex align-items-center justify-content-between price">'+
                                                    '<span>'+value.stock+' Pcs</span>'+
                                                    '<p>₹'+value.mrp+'</p>'+
                                                '</div>'+
                                                '<button class="btn btn-success btn-sm addtoBill" data-id="'+value.id+'" data-image="'+value.product_image+'" data-name="'+value.product_name+'" data-mrp="'+value.mrp+'" data-qty="'+value.quantity+'" data-stock="'+value.stock+'">Add to purchase</button>'+
                                            '</div>'+
                                        '</div>'
                                $('.addbyseach').append(product);
                            })
                        }
                    }
                });
            }
        })

        function searchProductByname(element) {
            dInput = element.value;
            togglevalue = $('input[name="storeUsercheck"]:checked').val();
            console.log(togglevalue)
            $('#global-loader').show();
            if(dInput)
            {
                $.ajax({
                    url: "{{ route('store.pos.getProductByName') }}",
                    method: 'post',
                    data: { "_token" : "{{csrf_token()}}", 'dInput': dInput },
                    success: function(data){
                        console.log(data)
                        $('#global-loader').hide();

                        if(data.success == false)
                        {
                            $('.errorShow').text(data.message);
                        }
                        $('.addbyseach').empty();
                        if(data.success == 1 || data.success == 2)
                        {
                            $('.errorShow').text(' ');
                            $.each(data.Product, function(index, value){  
                                if(togglevalue == 0){
                                    if(value.wholesale_price){
                                        value.mrp = value.wholesale_price;
                                    }
                                }else if(togglevalue == 1){
                                    if(value.retail_price){
                                        value.mrp = value.retail_price;
                                    }
                                }
                                console.log(value)
                                var btn = '<button class="btn btn-success btn-sm addtoBill" data-id="'+value.id+'" data-image="'+value.product_image+'" data-name="'+value.product_name+'" data-mrp="'+value.mrp+'" data-qty="'+value.quantity+'" data-stock="'+value.stock+'">Add to purchase</button>';
                                if(data.success == 2){
                                    btn = '<button class="btn btn-danger btn-sm addInventory" data-productid="'+value.id+'" data-productName="'+value.product_name+'">Add to inventory</button>';
                                }

                                var firstLetter = value.product_name.slice(0,1);
                                var image = '<button type="button" class="btn btn-light">'+firstLetter+'</button>';
                                if(value.product_image)
                                {
                                    image = '<a href="javascript:void(0);" class="img-sm"><img src="'+value.product_image+'"alt="Products"><span><i data-feather="check" class="feather-16"></i></span></a>';
                                }
                                product = 
                                        '<div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">'+
                                            '<div class="product-info default-cover card">'+
                                                image+
                                                '<h6 class="cat-name"><a href="javascript:void(0);">'+value.product_category.name+'</a></h6>'+
                                                '<h6 class="product-name"><a href="javascript:void(0);">'+value.product_name+'</a>'+
                                                '</h6>'+
                                                '<div class="d-flex align-items-center justify-content-between price">'+
                                                    '<span>'+value.stock+' Pcs</span>'+
                                                    '<p>₹'+value.mrp+'</p>'+
                                                '</div">'+
                                            '</div>'+
                                            btn+
                                        '</div>'
                                $('.addbyseach').append(product);
                                
                            })
                            $('.textChange').text(data.message);
                        }
                    }
                });
            }
        };

        $(document).on('click','.categoryProduct', function(){
            var catid = $(this).attr('data-id');
            togglevalue = $('input[name="storeUsercheck"]:checked').val();

            $('#global-loader').show();
            if(catid)
            {
                $.ajax({
                    url: "{{ route('store.pos.getProductByCategory') }}",
                    method: 'post',
                    data: { "_token" : "{{csrf_token()}}", 'catid': catid },
                    success: function(data){
                        console.log(data)
                        $('#global-loader').hide();
                        $('.addbyseach').empty();
                        if(data.success == true)
                        {
                            $.each(data.Product, function(index, value){ 
                                if(togglevalue == 0){
                                    if(value.wholesale_price){
                                        value.mrp = value.wholesale_price;
                                    }
                                }else if(togglevalue == 1){
                                    if(value.retail_price){
                                        value.mrp = value.retail_price;
                                    }
                                }
                                console.log(value) 
                                var firstLetter = value.product_name.slice(0,1);
                                var image = '<button type="button" class="btn btn-light">'+firstLetter+'</button>';
                                if(value.product_image)
                                {
                                    image = '<a href="javascript:void(0);" class="img-sm"><img src="'+value.product_image+'"alt="Products"><span><i data-feather="check" class="feather-16"></i></span></a>';
                                }
                                product = 
                                        '<div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">'+
                                            '<div class="product-info default-cover card">'+
                                                image+
                                                '<h6 class="cat-name"><a href="javascript:void(0);">'+value.product_category.name+'</a></h6>'+
                                                '<h6 class="product-name"><a href="javascript:void(0);">'+value.product_name+'</a>'+
                                                '</h6>'+
                                                '<div class="d-flex align-items-center justify-content-between price">'+
                                                    '<span>'+value.stock+' Pcs</span>'+
                                                    '<p>₹'+value.mrp+'</p>'+
                                                '</div>'+
                                                '<button class="btn btn-success btn-sm addtoBill" data-id="'+value.id+'" data-image="'+value.product_image+'" data-name="'+value.product_name+'" data-mrp="'+value.mrp+'" data-qty="'+value.quantity+'" data-stock="'+value.stock+'">Add to purchase</button>'+
                                            '</div>'+
                                        '</div>'
                                $('.addbyseach').append(product);
                            })
                        }
                    }
                });
            }
        })

        $(document).on('click','.addInventory', function(){
            var productId = $(this).attr('data-productid');
            var productName = $(this).attr('data-productName');
            $('#product_name').text('Product Name: '+productName);
            $('#product_id').val(productId);

            $('#add-inventory-product').modal('show');
        })

        $(document).on('click', '.quickAdd', function(){
            var product_id = $('#product_id').val();
            var stock = $('#stock').val();
            if(stock){
                $('#error-msgstock').text(' ');
                $.ajax({
                    url: "{{ route('store.pos.quickAddProduct') }}",
                    method: 'post',
                    data: { "_token" : "{{csrf_token()}}", 'product_id': product_id , 'stock': stock},
                    success: function(data){
                        console.log(data)
                        if(data.success == false){
                            $('#error-msgstock').text(data.message);
                        }
                        dInput = $('#searchProductByname').val();
                        if(dInput)
                        {
                            $('#add-inventory-product').modal('hide');
                            $('#global-loader').show();
                            $.ajax({
                                url: "{{ route('store.pos.getProductByName') }}",
                                method: 'post',
                                data: { "_token" : "{{csrf_token()}}", 'dInput': dInput },
                                success: function(data){
                                    console.log(data)
                                    $('#global-loader').hide();

                                    if(data.success == false)
                                    {
                                        $('.errorShow').text(data.message);
                                    }
                                    $('.addbyseach').empty();
                                    if(data.success == 1 || data.success == 2)
                                    {
                                        $('.errorShow').text(' ');
                                        $.each(data.Product, function(index, value){  
                                            if(value.retail_price)
                                            {
                                                value.mrp = value.retail_price;
                                            }
                                            console.log(value)
                                            var btn = '<button class="btn btn-success btn-sm addtoBill" data-id="'+value.id+'" data-image="'+value.product_image+'" data-name="'+value.product_name+'" data-mrp="'+value.mrp+'" data-qty="'+value.quantity+'" data-stock="'+value.stock+'">Add to purchase</button>';
                                            if(data.success == 2){
                                                btn = '<button class="btn btn-danger btn-sm addInventory" data-productid="'+value.id+'" data-productName="'+value.product_name+'">Add to inventory</button>';
                                            }

                                            var firstLetter = value.product_name.slice(0,1);
                                            var image = '<button type="button" class="btn btn-light">'+firstLetter+'</button>';
                                            if(value.product_image)
                                            {
                                                image = '<a href="javascript:void(0);" class="img-sm"><img src="'+value.product_image+'"alt="Products"><span><i data-feather="check" class="feather-16"></i></span></a>';
                                            }
                                            product = 
                                                    '<div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">'+
                                                        '<div class="product-info default-cover card">'+
                                                            image+
                                                            '<h6 class="cat-name"><a href="javascript:void(0);">'+value.product_category.name+'</a></h6>'+
                                                            '<h6 class="product-name"><a href="javascript:void(0);">'+value.product_name+'</a>'+
                                                            '</h6>'+
                                                            '<div class="d-flex align-items-center justify-content-between price">'+
                                                                '<span>'+value.stock+' Pcs</span>'+
                                                                '<p>₹'+value.mrp+'</p>'+
                                                            '</div">'+
                                                        '</div>'+
                                                        btn+
                                                    '</div>'
                                            $('.addbyseach').append(product);
                                            
                                        })
                                        $('.textChange').text(data.message);
                                    }
                                }
                            });
                        }
                    }
                });
            }else{
                $('#error-msgstock').text('Stock is required');
            }
        })

        $(document).on('click', '.customerAdd', function(){
            var name = $('#customer_name').val();
            var whatsapp_no = $('#customer_number').val();
            
            $.ajax({
                url: "{{ route('store.pos.addCustomer') }}",
                method: 'post',
                data: { "_token" : "{{csrf_token()}}", 'name': name , 'whatsapp_no': whatsapp_no},
                success: function(data){
                    console.log(data)
                    $('#error-msgCustomerNumber').text(' ');
                    if(data.success == false){
                        $.each(data.message, function(index, value){ 
                            console.log(value)
                            $('#error-msgCustomerNumber').text(value);
                        })
                    }
                    if(data.success == true)
                    {
                        $('.showCustomer').empty();
                        var cus = '<option value="">Select</option>';
                        $('.showCustomer').append(cus);
                        $.each(data.customer, function(index, value){ 
                            var cus = '<option value="'+value.name+'" data-number="'+value.whatsapp_no+'">'+value.name+'</option>'
                            $('.showCustomer').append(cus);
                        })
                        $('#create').modal('hide');
                    }
                                
                }
            });
        })

        var addproductIDS=[];
        var product_details=[];

        function searchProductBybarcode(element) {
            dInput = element.value;
            togglevalue = $('input[name="storeUsercheck"]:checked').val();
            $('#global-loader').show();
            if(dInput)
            {
                $.ajax({
                    url: "{{ route('store.pos.getProductByBarcode') }}",
                    method: 'post',
                    data: { "_token" : "{{csrf_token()}}", 'dInput': dInput },
                    success: function(data){
                        console.log(data)
                        $('#global-loader').hide();
                        if(data.success == false)
                        {
                            alert(data.message);
                            $('#searchProductBybarcode').val(' ');
                        }
                        if(data.success == 1)
                        {
                            var product_id = data.Product.id;
                            var name = data.Product.product_name;
                            var image = data.Product.product_image;
                            if(togglevalue == 0){
                                if(data.Product.wholesale_price){
                                    data.Product.mrp = data.Product.wholesale_price;
                                }
                            }else if(togglevalue == 1){
                                if(data.Product.retail_price){
                                    data.Product.mrp = data.Product.retail_price;
                                }
                            }
                            var mrp = data.Product.mrp;
                            var qty = 1;
                            var stock = data.Product.stock;
                            console.log(addproductIDS)
                            if($.inArray(product_id, addproductIDS) != -1)
                            { 
                                var total = $('#total'+product_id+'').text();
                                var qtytotal = $('#qty'+product_id+'').val();

                                if(qtytotal == stock)
                                {
                                    alert('Only '+name+' ('+stock+') stock available')
                                }else{
                                    var subtotal = $('.subtotal').text();
                                    var alltotal = $('.total').text();
                                    var grandtotal = $('.grandtotal').text();
                                    $('#total'+product_id+'').text(parseInt(total) + parseInt(mrp));
                                    $('#qty'+product_id+'').val(parseInt(qtytotal) + parseInt(qty));
                                    $('.total').text(parseInt(alltotal) + parseInt(mrp));
                                    $('.subtotal').text(parseInt(subtotal) + parseInt(mrp));
                                    $('.total').text(parseInt(alltotal) + parseInt(mrp));
                                    $('.grandtotal').text(parseInt(grandtotal) + parseInt(mrp));

                                    $.each(product_details, function(index, product_detail){ 
                                        if(product_detail.id == product_id)
                                        {
                                            product_detail.total_amount = parseInt(total) - parseInt(mrp);
                                        }
                                    });
                                }
                                
                            }else{
                                var firstLetter = name.slice(0,1);
                                var imageget = '<button type="button" class="btn btn-light">'+firstLetter+'</button>';
                                if(image)
                                {
                                    imageget = '<img src="'+image+'" alt="Products">';
                                }
                                var productAdd =
                                '<div class="product-list d-flex align-items-center justify-content-between" id="proID'+product_id+'">'+
                                    '<div class="d-flex align-items-center product-info">'+
                                        '<input type="hidden" id="productID'+product_id+'" value="'+product_id+'">'+
                                        '<input type="hidden" id="discountAmount'+product_id+'" value="0">'+
                                        '<input type="hidden" id="discountType'+product_id+'" value="₹">'+
                                        '<input type="hidden" id="discountTypeAmount'+product_id+'" value="0">'+
                                        '<input type="hidden" id="stock'+product_id+'" value="'+stock+'">'+
                                        '<a href="javascript:void(0);" class="img-bg">'+
                                            imageget+
                                        '</a>'+
                                        '<div class="info">'+
                                            '<h6><a href="javascript:void(0);" id="product_name'+product_id+'">'+name+'</a></h6>'+
                                            '<p id="mrp'+product_id+'">'+mrp+'</p>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="qty-item text-center">'+
                                        '<a href="javascript:void(0);" class="dec d-flex justify-content-center align-items-center changeQty" data-item="-" data-id="'+product_id+'"  title="minus"><i class="fa fa-minus" aria-hidden="true"></i></a>'+
                                        '<input type="text" class="form-control text-center" name="qty" id="qty'+product_id+'" value="'+qty+'">'+
                                        '<a href="javascript:void(0);" class="inc d-flex justify-content-center align-items-center changeQty" data-item="+" data-id="'+product_id+'" title="plus"><i class="fa fa-plus" aria-hidden="true"></i></a>'+
                                    '</div>'+
                                    '<div class="info" id="total'+product_id+'"><p>'+mrp+'</p></div>'+
                                    '<div class="d-flex align-items-center action">'+
                                        // '<a class="btn-icon edit-icon me-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-product">'+
                                        //     '<i class="fa fa-edit" aria-hidden="true"></i>'+
                                        // '</a>'+
                                        '<a class="btn-icon delete-icon confirm-text" href="javascript:void(0);" id="deletePRoductAdd" data-id="'+product_id+'">'+
                                            '<i class="fa fa-trash" aria-hidden="true"></i>'+
                                        '</a>'+
                                        '<button class="btn btn-sm btn-danger productDiscount" data-id="'+product_id+'" style="margin-left: 10px;"><span id="discountText'+product_id+'">Discount</span></button>'+
                                    '</div>'+
                                '</div>'
                                $('#product_addon').append(productAdd); 
                                var count = $('.count').text();
                                $('.count').text(parseInt(count) + parseInt(1));
                                var subtotal = $('.subtotal').text();
                                $('.subtotal').text(parseInt(subtotal) + parseInt(mrp));
                                var alltotal = $('.total').text();
                                $('.total').text(parseInt(alltotal) + parseInt(mrp));
                                var grandtotal = $('.grandtotal').text();
                                $('.grandtotal').text(parseInt(grandtotal) + parseInt(mrp));
                                addproductIDS.push(product_id);

                                var proArr =  {'id'   : product_id, 'product_name' : name, 'qtn'  : qty, 'price'  : mrp, 'discount'  : null, 'total_amount'  : mrp,};
                                product_details.push(proArr); 
                            }
                            $('#searchProductBybarcode').val(' ');
                        }
                    }
                });
            }
        };

        $(document).on('click', '.addtoBill', function(){
            $('#discountAmount').val(0);
            // $("input:radio[name='discount_type']").prop('checked', false);
            $('.discountText').text('(0)');
            $('.discount').text(0);
            
            var product_id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var image = $(this).attr('data-image');
            var mrp = $(this).attr('data-mrp');
            var qty = 1;
            var stock = $(this).attr('data-stock');

            if($.inArray(product_id, addproductIDS) != -1)
            { 
                var total = $('#total'+product_id+'').text();
                var qtytotal = $('#qty'+product_id+'').val();

                if(qtytotal == stock)
                {
                    alert('Only '+name+' ('+stock+') stock available')
                }else{
                    var subtotal = $('.subtotal').text();
                    var alltotal = $('.total').text();
                    var grandtotal = $('.grandtotal').text();
                    $('#total'+product_id+'').text(parseInt(total) + parseInt(mrp));
                    $('#qty'+product_id+'').val(parseInt(qtytotal) + parseInt(qty));
                    $('.total').text(parseInt(alltotal) + parseInt(mrp));
                    $('.subtotal').text(parseInt(subtotal) + parseInt(mrp));
                    $('.total').text(parseInt(alltotal) + parseInt(mrp));
                    $('.grandtotal').text(parseInt(grandtotal) + parseInt(mrp));

                    $.each(product_details, function(index, product_detail){ 
                        if(product_detail.id == product_id)
                        {
                            product_detail.total_amount = parseInt(total) - parseInt(mrp);
                        }
                    });
                }
                
            }else{
                var firstLetter = name.slice(0,1);
                var imageget = '<button type="button" class="btn btn-light">'+firstLetter+'</button>';
                if(image)
                {
                    imageget = '<img src="'+image+'" alt="Products">';
                }
                var productAdd =
                '<div class="product-list d-flex align-items-center justify-content-between" id="proID'+product_id+'">'+
                    '<div class="d-flex align-items-center product-info">'+
                        '<input type="hidden" id="productID'+product_id+'" value="'+product_id+'">'+
                        '<input type="hidden" id="discountAmount'+product_id+'" value="0">'+
                        '<input type="hidden" id="discountType'+product_id+'" value="₹">'+
                        '<input type="hidden" id="discountTypeAmount'+product_id+'" value="0">'+
                        '<input type="hidden" id="stock'+product_id+'" value="'+stock+'">'+
                        '<a href="javascript:void(0);" class="img-bg">'+
                            imageget+
                        '</a>'+
                        '<div class="info">'+
                            '<h6><a href="javascript:void(0);" id="product_name'+product_id+'">'+name+'</a></h6>'+
                            '<p id="mrp'+product_id+'">'+mrp+'</p>'+
                        '</div>'+
                    '</div>'+
                    '<div class="qty-item text-center">'+
                        '<a href="javascript:void(0);" class="dec d-flex justify-content-center align-items-center changeQty" data-item="-" data-id="'+product_id+'"  title="minus"><i class="fa fa-minus" aria-hidden="true"></i></a>'+
                        '<input type="text" class="form-control text-center" name="qty" id="qty'+product_id+'" value="'+qty+'">'+
                        '<a href="javascript:void(0);" class="inc d-flex justify-content-center align-items-center changeQty" data-item="+" data-id="'+product_id+'" title="plus"><i class="fa fa-plus" aria-hidden="true"></i></a>'+
                    '</div>'+
                    '<div class="info" id="total'+product_id+'"><p>'+mrp+'</p></div>'+
                    '<div class="d-flex align-items-center action">'+
                        // '<a class="btn-icon edit-icon me-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-product">'+
                        //     '<i class="fa fa-edit" aria-hidden="true"></i>'+
                        // '</a>'+
                        '<a class="btn-icon delete-icon confirm-text" href="javascript:void(0);" id="deletePRoductAdd" data-id="'+product_id+'">'+
                            '<i class="fa fa-trash" aria-hidden="true"></i>'+
                        '</a>'+
                        '<button class="btn btn-sm btn-danger productDiscount" data-id="'+product_id+'" style="margin-left: 10px;"><span id="discountText'+product_id+'">Discount</span></button>'+
                    '</div>'+
                '</div>'
                $('#product_addon').append(productAdd); 
                var count = $('.count').text();
                $('.count').text(parseInt(count) + parseInt(1));
                var subtotal = $('.subtotal').text();
                $('.subtotal').text(parseInt(subtotal) + parseInt(mrp));
                var alltotal = $('.total').text();
                $('.total').text(parseInt(alltotal) + parseInt(mrp));
                var grandtotal = $('.grandtotal').text();
                $('.grandtotal').text(parseInt(grandtotal) + parseInt(mrp));
                addproductIDS.push(product_id);

                var proArr =  {'id'   : product_id, 'product_name' : name, 'qtn'  : qty, 'price'  : mrp, 'discount'  : null, 'total_amount'  : mrp,};
                product_details.push(proArr); 
            }
        })

        $(document).on('click', '.clearAll', function(){
            clear();
        })

        function clear(){
            $('#product_addon').empty();
            $('.subtotal').text(0);
            $('.total').text(0);
            $('.count').text(0);
            $('.grandtotal').text(0);
            addproductIDS = [];
            productArray = [];
            $('#discountAmount').val(0);
            $("input:radio[name='discount_type']").prop('checked', false);
            $('.discountText').text('(0)');
            $('.discount').text(0);
        }

        $(document).on('click', '#deletePRoductAdd', function(){
            var subtotal = $('.subtotal').text();
            $('.total').text(subtotal);
            $('.grandtotal').text(subtotal);
            $('#discountAmount').val(0);
            $("input:radio[name='discount_type']").prop('checked', false);
            $('.discountText').text('(0)');
            $('.discount').text(0);

            var id = $(this).attr('data-id');
            var toalproamount = $('#total'+id+'').text();
            $('#proID'+id+'').remove();
            var count = $('.count').text();
            $('.count').text(parseInt(count) - parseInt(1));

            $('.subtotal').text(parseInt(subtotal) - parseInt(toalproamount));
            var alltotal = $('.total').text();
            $('.total').text(parseInt(alltotal) - parseInt(toalproamount));
            var grandtotal = $('.grandtotal').text();
            $('.grandtotal').text(parseInt(grandtotal) - parseInt(toalproamount));
            addproductIDS = $.grep(addproductIDS, function(value) {
                return value != id;
            });
            product_details = $.grep(product_details, function(value) {
                return value.id != id;
            });
        })

        $(function(){
            $("input:radio[name='discount_type']").change(function()
            {
                var discount_type = $(this).val();
                var discountAmount = $('#discountAmount').val();
                var subtotal = $('.subtotal').text();

                $('.discountText').text('('+discountAmount+discount_type+')');
                
                if (discount_type == '%') {
                    discountAmount = parseInt(subtotal) * discountAmount/100;
                }
                $('.discount').text(discountAmount);
                $('.total').text(parseInt(subtotal) - parseInt(discountAmount));
                $('.grandtotal').text(parseInt(subtotal) - parseInt(discountAmount));
            });
        });

        $("#discountAmount").keyup(function(){
            var discount_type = $("input:radio[name=discount_type]:checked").val();
            var discountAmount = $('#discountAmount').val();
            var subtotal = $('.subtotal').text();

            $('.discountText').text('('+discountAmount+discount_type+')');
            
            if (discount_type == '%') {
                discountAmount = parseInt(subtotal) * discountAmount/100;
            }
            $('.discount').text(discountAmount);
            $('.total').text(parseInt(subtotal) - parseInt(discountAmount));
            $('.grandtotal').text(parseInt(subtotal) - parseInt(discountAmount));
        })

        $(document).on('click', '.changeQty', function(){
            var value = $(this).attr("data-item");
            var id = $(this).attr("data-id");
            var mrp = $('#mrp'+id+'').text();
            var total = $('#total'+id+'').text();
            var qty = $('#qty'+id+'').val();
            var stock = $('#stock'+id+'').val();
            var product_name = $('#product_name'+id+'').text();
            
            var discountTypeAmount = $('#discountTypeAmount'+id+'').val();
            var discountType = $('#discountType'+id+'').val();
            var discountAmount = $('#discountAmount'+id+'').val();
            
           

            if(value == '+')
            {
                if(qty == stock)
                {
                    alert('Only '+product_name+' ('+stock+') stock available')
                }else{
                    $('#qty'+id+'').val(parseInt(qty) + parseInt(1));
                    var totalp = parseInt(total) + parseInt(discountAmount) + parseInt(mrp);

                    totalvalue = parseInt(totalp) - parseInt(discountTypeAmount);
                    if(discountType == '%'){
                        discountAmount = parseInt(totalp) * parseInt(discountTypeAmount)/100;

                        $('#discountAmount'+id+'').val(discountAmount);
                        totalvalue = parseInt(totalp) - parseInt(discountAmount);
                    }
                    $('#total'+id+'').text(totalvalue);
                    $.each(product_details, function(index, product_detail){ 
                        if(product_detail.id == id)
                        {
                            product_detail.qtn = parseInt(qty) + parseInt(1);
                            product_detail.discount = discountAmount;
                            product_detail.total_amount = parseInt(totalp) - parseInt(discountAmount);
                        }
                    });
                }
            }

            if(value == '-' && qty >= 2)
            {
                $('#qty'+id+'').val(parseInt(qty) - parseInt(1));
                var totalp = parseInt(total) + parseInt(discountAmount) - parseInt(mrp);
                totalvalue = parseInt(totalp) - parseInt(discountTypeAmount);
                if(discountType == '%'){
                    discountAmount = parseInt(totalp) * parseInt(discountTypeAmount)/100;
                    $('#discountAmount'+id+'').val(discountAmount);
                    totalvalue = parseInt(totalp) - parseInt(discountAmount);
                }
                $('#total'+id+'').text(totalvalue);

                $.each(product_details, function(index, product_detail){ 
                    if(product_detail.id == id)
                    {
                        product_detail.qtn = parseInt(qty) - parseInt(1);
                        product_detail.discount = discountAmount;
                        product_detail.total_amount = parseInt(totalp) - parseInt(discountAmount);
                    }
                });
            }

            totalAmoutAfter = 0;
            $.each(addproductIDS, function(index, idd){ 
                total = $('#total'+idd+'').text();
                totalAmoutAfter = parseInt(totalAmoutAfter) + parseInt(total);
            });
            console.log(product_details)

            $('.subtotal').text(totalAmoutAfter);

            //discount
                var discount_type = $("input:radio[name=discount_type]:checked").val();
                var discountAmount = $('#discountAmount').val();
                var subtotal = $('.subtotal').text();
                console.log(discount_type, discountAmount, subtotal)
                $('.discountText').text('('+discount_type+discountAmount+')');
                
                if (discount_type == '%') {
                    discountAmount = parseInt(subtotal) * discountAmount/100;
                }
                $('.discount').text(discountAmount);
                console.log(discountAmount)

                $('.total').text(parseInt(subtotal) - parseInt(discountAmount));
                $('.grandtotal').text(parseInt(subtotal) - parseInt(discountAmount));
            //
        })

        $('.methods').click(function(){
            $('#payment_method').empty();
            var value = $('#methodsValue', this).text();
            $('#payment_method').val(value);
        })
        
        $('.payment').click(function(){
            $('#global-loader').show();
            var customerName = $('.showCustomer').val();
            var customerNumber = $('.showCustomer option:selected').data('number');
            var subtotal = $('.subtotal').text();
            var discount = $('.discount').text();
            var grandtotal = $('.grandtotal').text();
            var payment_method = $('#payment_method').val();

            $.ajax({
                url: "{{ route('store.pos.createBill') }}",
                method: 'post',
                data: { "_token" : "{{csrf_token()}}", 'customerName': customerName, 'customerNumber': customerNumber, 'subtotal': subtotal, 'discount': discount,  'grandtotal': grandtotal, 'payment_method': payment_method, 'product_details': product_details},
                success: function(data){
                    console.log(data)
                    $('#global-loader').hide();
                    $('#billerror').text(' ');
                    if(data.success == false)
                    {
                        $('#billerror').text(data.message);
                    }
                    if(data.success == true)
                    {
                        $('#invoiceUrl').val(data.invoiceUrl);
                        $('#payment-completed').modal('show');
                        clear();
                    }
                }
            });
        })

        $('.reciept').click(function(){
            var invoiceurl = $('#invoiceUrl').val();
            window.open(invoiceurl, "_blank") 
        })

        //product discount 
            $(document).on('click', '.productDiscount', function(){
                var productid = $(this).attr('data-id');
                var totalamount = $('#total'+productid+'').text();
                var discountAmount = $('#discountAmount'+productid+'').val();

                $('#productTotalAmount').text(parseInt(totalamount) + parseInt(discountAmount));
                $('#product_iddiscountmodel').val(productid);

                $('#productdiscountAmount').val(' ');
                $('#productDiscountAmount').text(' ');
                
                $('#product-discount').modal('show');
            })

            $("#productdiscountAmount").keyup(function(){
                var amount = $('#productdiscountAmount').val();
                var discountType = $("input:radio[name=product_discount_type]:checked").val();
                var productTotalAmount = $('#productTotalAmount').text();
                $('#productDiscountAmount').text(''+amount+'');

                if (discountType == '%') {
                    amount = parseInt(productTotalAmount) * amount/100;
                    $('#productDiscountAmount').text(''+amount+'');
                }
            })
    

            $(document).on('click', '.product_discount_type', function(){
                var amount = $('#productdiscountAmount').val();
                var discountType = $("input:radio[name=product_discount_type]:checked").val();
                var productTotalAmount = $('#productTotalAmount').text();
                $('#productDiscountAmount').text(''+amount+'');

                if (discountType == '%') {
                    amount = parseInt(productTotalAmount) * amount/100;
                    $('#productDiscountAmount').text(''+amount+'');
                }
            })

            $(document).on('click', '.addproductDiscount', function(){
                var total = $('#productTotalAmount').text();
                var amount = $('#productDiscountAmount').text();
                var amounttypeAmount = $('#productdiscountAmount').val();
               
                var discountType = $("input:radio[name=product_discount_type]:checked").val();
                var productid = $('#product_iddiscountmodel').val();

                var discountAmount = $('#discountAmount'+productid+'').val();

                
                $('#total'+productid+'').text(parseInt(total) - parseInt(amount));

                var subtotal = $('.subtotal').text();
                $('.subtotal').text(parseInt(subtotal) + parseInt(discountAmount) - parseInt(amount));
                $('.total').text(parseInt(subtotal) + parseInt(discountAmount) - parseInt(amount));
                $('.grandtotal').text(parseInt(subtotal) + parseInt(discountAmount) - parseInt(amount));

                $('#discountAmount'+productid+'').val(amount);
                $('#discountType'+productid+'').val(discountType);
                $('#discountTypeAmount'+productid+'').val(amounttypeAmount);
                $('#discountText'+productid+'').text(amount);
                if(discountType == '%'){
                    $('#discountText'+productid+'').text(amounttypeAmount + discountType);
                }
                //discount
                    var discount_type = $("input:radio[name=discount_type]:checked").val();
                    var discountAmount = $('#discountAmount').val();
                    var subtotal = $('.subtotal').text();
                    console.log(discount_type, discountAmount, subtotal)
                    $('.discountText').text('('+discountAmount+discount_type+')');
                    
                    if (discount_type == '%') {
                        discountAmount = parseInt(subtotal) * discountAmount/100;
                    }
                    $('.discount').text(discountAmount);
                    console.log(discountAmount)

                    $('.total').text(parseInt(subtotal) - parseInt(discountAmount));
                    $('.grandtotal').text(parseInt(subtotal) - parseInt(discountAmount));
                //  

                $.each(product_details, function(index, product_detail){ 
                    if(product_detail.id == productid)
                    {
                        product_detail.discount = amount;
                        product_detail.total_amount = parseInt(total) - parseInt(amount);
                    }
                });
                
                console.log(product_details)
                $('#product-discount').modal('hide');
            })
        //
    </script>
@endsection
