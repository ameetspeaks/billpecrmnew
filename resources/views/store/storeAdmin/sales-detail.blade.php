<?php $page = 'sales-detail'; ?>
@extends('store.storeAdmin.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
        <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Sales List Detail</h4>
                <h6>Manage Sales List</h6>
            </div>
        </div>
    </div>

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                <div class="content p-0">
                        <div class="page-header p-4 mb-0">
                            <div class="add-item d-flex">
                                <div class="page-title modal-datail">
                                    <h4>Sales Detail : Bill-NO : {{$sale->bill_number}}</h4>
                                </div>
                            </div>
                           
                        </div>
                        <div class="page-wrapper details-blk">
                            <div class="card">
                                <div class="card-body">
                                    <form action="sales-list">
                                        <div class="invoice-box table-height"
                                            style="max-width: 1600px;width:100%;overflow: auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                                            <div class="sales-details-items d-flex" style="padding: 26px;">
                                                <div class="details-item">
                                                    <h6>Customer Info</h6>
                                                    <p>{{$sale->customer_name}}<br>
                                                    {{$sale->customer_number}}<br>
                                                        
                                                    </p>
                                                </div>
                                                <div class="details-item">
                                                    <h6>Company Info</h6>
                                                    <p>{{$sale->store->shop_name}}<br>
                                                        {{$sale->store->address}}<br>
                                                        {{$sale->store->city}}<br>
                                                    </p>
                                                </div>
                                                <div class="details-item">
                                                    <h6>Invoice Info</h6>
                                                    <p>Payment Status<br>
                                                        Status
                                                    </p>
                                                </div>
                                                <div class="details-item">
                                                    @if($sale->due_amount)
                                                    <h5 style="color:red">Due<br> Pending</h5>
                                                    @else
                                                    <h5>Paid<br> Completed</h5>
                                                    @endif

                                                </div>
                                            </div>
                                            <h5 class="order-text" style="margin-left: 20px;">Order Summary</h5>
                                            <div class="table-responsive no-pagination">
                                                <table class="table  datanew">
                                                    <thead>
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Qty</th>
                                                            <th>Purchase Price</th>
                                                            <th>Discount</th>
                                                            <th>Total Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $products = json_decode($sale->product_detail); ?>
                                                        @foreach($products as $product)
                                                        <tr>
                                                            <td>{{$product->product_name}}</td>
                                                            <td>{{$product->qtn}}</td>
                                                            <td>{{$product->price}}</td>
                                                            <td>{{$product->discount}}</td>
                                                            <td>{{$product->total_amount}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="row">
                                                <div class="col-lg-6 ms-auto">
                                                    <div class="total-order w-100 max-widthauto m-auto mb-4">
                                                        <ul>
                                                            <li>
                                                                <h4><b>Amount</b></h4>
                                                                <h5>₹{{$sale->amount}}</h5>
                                                            </li>
                                                            <li>
                                                                <h4><b>Discount</b></h4>
                                                                <h5>₹{{$sale->discount}}</h5>
                                                            </li>
                                                            <li>
                                                                <h4><b>Grand Total</b></h4>
                                                                <h5>₹{{$sale->total_amount + $sale->due_amount}}</h5>
                                                            </li>
                                                            <li>
                                                                <h4><b>Paid</b></h4>
                                                                <h5>₹{{$sale->total_amount}}</h5>
                                                            </li>
                                                            @if($sale->due_amount)
                                                            <li>
                                                                <h4></h4><b>Due</b></h4>
                                                                <h5>₹{{$sale->due_amount}}</h5>
                                                            </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <span style="font-weight: bold; margin-left: 450px;">You Have Saved: 110 </span><br><span  style="margin-left: 450px;"> Thanks You! Visit Again</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- /product list -->
        </div>
    </div>

    
@endsection
