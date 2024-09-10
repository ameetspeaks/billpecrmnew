<?php $page = 'sales-list'; ?>
@extends('store.storeAdmin.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4> Sales List</h4>
                        <h6>Manage Your Sales</h6>
                    </div>
                </div>
            </div>

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                 
                    <div class="table-responsive sales-list">
                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Grand Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Payment Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- /product list -->
        </div>
    </div>

     <!-- details popup -->
     <div class="modal fade" id="sales-details-new">
        <div class="modal-dialog sales-details-modal">
            <div class="modal-content">
                <div class="page-wrapper details-blk">
                    <div class="content p-0">
                        <div class="page-header p-4 mb-0">
                            <div class="add-item d-flex">
                                <div class="page-title modal-datail">
                                    <h4>Sales Detail : SL0101</h4>
                                </div>
                            </div>
                           
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <form action="sales-list">
                                    <div class="invoice-box table-height"
                                        style="max-width: 1600px;width:100%;overflow: auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                                        <div class="sales-details-items d-flex">
                                            <div class="details-item">
                                                <h6>Customer Info</h6>
                                                <p>walk-in-customer<br>
                                                    walk-in-customer@example.com<br>
                                                    123456780<br>
                                                    N45 , Dhaka
                                                </p>
                                            </div>
                                            <div class="details-item">
                                                <h6>Company Info</h6>
                                                <p>DGT<br>
                                                    admin@example.com<br>
                                                    6315996770<br>
                                                    3618 Abia Martin Drive
                                                </p>
                                            </div>
                                            <div class="details-item">
                                                <h6>Invoice Info</h6>
                                                <p>Reference<br>
                                                    Payment Status<br>
                                                    Status
                                                </p>
                                            </div>
                                            <div class="details-item">
                                                <h5><span>SL0101</span>Paid<br> Completed</h5>
                                            </div>
                                        </div>
                                        <h5 class="order-text">Order Summary</h5>
                                        <div class="table-responsive no-pagination">
                                            <table class="table  datanew">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Qty</th>
                                                        <th>Purchase Price($)</th>
                                                        <th>Discount($)</th>
                                                        <th>Tax(%)</th>
                                                        <th>Tax Amount($)</th>
                                                        <th>Unit Cost($)</th>
                                                        <th>Total Cost(%)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="productimgname">
                                                                <a href="javascript:void(0);"
                                                                    class="product-img stock-img">
                                                                    <img src="{{ URL::asset('/build/img/products/stock-img-02.png')}}"
                                                                        alt="product">
                                                                </a>
                                                                <a href="javascript:void(0);">Nike Jordan</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="product-quantity">
                                                                <span class="quantity-btn">+<i
                                                                        data-feather="plus-circle"
                                                                        class="plus-circle"></i></span>
                                                                <input type="text" class="quntity-input"
                                                                    value="2">
                                                                <span class="quantity-btn"><i
                                                                        data-feather="minus-circle"
                                                                        class="feather-search"></i></span>
                                                            </div>
                                                        </td>
                                                        <td>2000</td>
                                                        <td>500</td>
                                                        <td>
                                                            0.00
                                                        </td>
                                                        <td>0.00</td>
                                                        <td>0.00</td>
                                                        <td>1500</td>
                                                    </tr>
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
                                                            <h4>Order Tax</h4>
                                                            <h5>$ 0.00</h5>
                                                        </li>
                                                        <li>
                                                            <h4>Discount</h4>
                                                            <h5>$ 0.00</h5>
                                                        </li>
                                                        <li>
                                                            <h4>Grand Total</h4>
                                                            <h5>$ 5200.00</h5>
                                                        </li>
                                                        <li>
                                                            <h4>Paid</h4>
                                                            <h5>$ 5200.00</h5>
                                                        </li>
                                                        <li>
                                                            <h4>Due</h4>
                                                            <h5>$ 0.00</h5>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /details popup -->

    

    <script>
        $(function () {
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                order: [],
            
                ajax: "{{ route('store.sales-list') }}",
                
                "columns": [
                    {
                        "data": "customer_name",
                    },
                    {
                        "data": "createBillDate",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            console.log(row)
                            if(row.due_amount){
                                return ' <span class="badge badge-bgdanger">Pending</span> ' ;
                            }else{
                                return ' <span class="badge badge-bgsuccess">Completed</span> ' ;
                            }
                        },
                    },
                    {
                        "data": "amount",
                    },
                    {
                        "data": "total_amount",
                    },
                    {
                        "data": "due_amount",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            console.log(row)
                            if(row.due_amount){
                                return ' <span class="badge badge-linedanger">Due</span> ' ;
                            }else{
                                return ' <span class="badge badge-linesuccess">Paid</span> ' ;
                            }
                        },
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            console.log(row)
                             return ' <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>  <ul class="dropdown-menu">  <li><a href="{{ url('store/salesDetail') }}/' + data +'" "" ><i data-feather="eye" class="info-img"></i>Sale Detail</a></li>  </ul> ' ;
                        },
                    },
                ],
            });
        });

    </script>
@endsection
