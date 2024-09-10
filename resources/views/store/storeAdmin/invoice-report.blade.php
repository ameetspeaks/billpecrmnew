<?php $page = 'invoice-report'; ?>
@extends('store.storeAdmin.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Invoice Report</h4>
                        <h6>Manage Your Invoice Report</h6>
                    </div>
                </div>
            </div>

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                    
                    <!-- /Filter -->
                    <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="user" class="info-img"></i>
                                        <select class="select">
                                            <option>Choose Name</option>
                                            <option>Rose</option>
                                            <option>Kaitlin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <i data-feather="stop-circle" class="info-img"></i>
                                        <select class="select">
                                            <option>Choose Status</option>
                                            <option>Paid</option>
                                            <option>Unpaid</option>
                                            <option>Overdue</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <div class="position-relative daterange-wraper">
                                            <input type="text" class="form-control" name="datetimes"
                                                placeholder="From Date - To Date">
                                            <i data-feather="calendar" class="feather-14 info-img"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <a class="btn btn-filters ms-auto"> <i data-feather="search"
                                                class="feather-search"></i> Search </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Filter -->
                    <div class="table-responsive">
                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Paid</th>
                                    <th>Amount Due</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
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


    <script>
        $(function () {
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('store.invoice-report') }}",
                
                "columns": [
                    {
                        "data": "bill_number",
                    },
                    {
                        "data": "customer_name",
                    },
                    {
                        "data": "grandTotal",
                    },
                    {
                        "data": "total_amount",
                    },
                    {
                        "data": "due_amount",
                    },
                    {
                        "data": "due_date",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            console.log(row)
                            if(row.due_amount){
                                return ' <span class="badge badge-linedanger">Unpaid</span> ' ;
                            }else{
                                return ' <span class="badge badge-linesuccess">Paid</span> ' ;
                            }
                        },
                    },               
                ],
            });
        });
    </script>
@endsection
