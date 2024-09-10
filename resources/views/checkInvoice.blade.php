<!-- resources/views/invoice.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Bootstrap CSS -->
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            /* Set the width of the invoice */
            width: 63mm;
            /* width: 80mm; */
            /* width: 100mm; */

            margin: 0 auto;
            padding: 10px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 10px;
        }
        .invoice-details {
            margin-bottom: 10px;
        }
        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .invoice-items th, .invoice-items td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .invoice-items th {
            background-color: #f2f2f2;
        }
        .invoice-total {
            text-align: right;
        }

        .footertext{
            justify-content: center;
            align-items: center;
            display: grid;
        }

        .modal{
            display:none
        }

    </style>
</head>
<body>
    <div id="all">
        <div class="invoice" >
            <div class="invoice-header">
                <img src="{{ $billHistory->store?->store_image ? $billHistory->store?->store_image : asset('public/admin/images/png-shop-1.png') }}" alt="User Image" class="rounded-lg" style="width: 50px; height: 50px" />
                <div class="">
                    <h2 class="text-2xl font-bold text-blue-500 ">{{$billHistory->store?->shop_name}}</h2>
                    <div>
                        Address: {{$billHistory->store?->address}}
                    </div>
                    <div class="mt-1 d-flex justify-content-center">
                        <span>Phone</span> <span>:</span> <span>{{$billHistory->store?->user->whatsapp_no}}</span>
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-blue-500 " style="text-align: center;">TAX INVOICE</h2>
            </div>
            <div class="invoice-details">
                <div class="order-info-id text">
                    <div class="d-flex pl-4"><span><b> Invoice No. </b></span> <span>&nbsp;</span> {{$billHistory?->bill_number}}<span></span></div>
                        @if($billHistory->customer_name && $billHistory->customer_number)
                            <div class="font-size-sm text-body  pl-4" >
                                <span>Customer Name: 
                                </span>
                                <span class="font-weight-bold"> {{$billHistory->customer_name}}</span>
                            </div>
                            <div class="font-size-sm text-body pl-4"  >
                                <span>Customer Phone :
                                </span>
                                <span class="font-weight-bold">{{$billHistory->customer_number}}</span>
                            </div>
                        @endif
                        <div class="pl-4">
                            Date and Time: {{$billHistory->created_at->format('d/m/y h:i ')}}
                            @if($billHistory->token)
                            <span style="    float: right;">Token No:{{$billHistory->token->token_no}}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <table class="invoice-items">
                <thead>
                    <tr class="border-0">
                        <th class=" px-4 py-2 text-left text-body  pl-5">Items</th>
                        <th class="text-center px-4 py-2">Price</th>
                        <th class="text-center px-4 py-2">Qtn</th>
                        <th class="text-center px-4 py-2">Discount</th>
                        <th class="text-center px-4 py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totaldiscount=0;
                    @endphp
                    
                    @foreach (json_decode($billHistory->product_detail) as $item)
                    <tr>
                        
                        <td class="text-left font-bold px-0 py-0 text-break text-body  pl-5">
                            {{$item->product_name}}
                        </td>
                        <td class="text-center px-2 py-1">
                            ₹ {{$item->price}} 
                        </td>
                        <td class="text-center px-2 py-1">
                            {{$item->qtn}}  
                        </td>
                        <td class="text-center px-2 py-1">
                            @if($item->discount)
                                ₹ {{$item->discount}} 
                            @else
                                ₹ 0
                            @endif
                        </td>
                        <td class="text-center px-2 py-1">
                            ₹ {{$item->total_amount}} 
                        </td>
                        
                        @php
                            $totaldiscount=$totaldiscount+$item->discount;
                        @endphp
                    </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="invoice-total">Extra Discount:</td>
                        <td> ₹ {{$billHistory->discount}} </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="invoice-total">Total Paid Amount:</td>
                        <td> ₹ {{$billHistory->total_amount}} </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="invoice-total">Items: </td>
                        <td> {{count(json_decode($billHistory->product_detail))}} </td>
                    </tr>
                </tfoot>
            </table>

            <div class="top-info mt-1 footertext">
                <b>You Have Saved: {{$totaldiscount+$billHistory->discount}}</b>
                <div class=" text-center my-2">Thanks You! Visit Again</div>

                <div class="text-right col-12 pt-4">
                    @if($billHistory->customer_name && $billHistory->customer_number)
                        <form action="{{ route('sharebilltowhatsapp') }}"  method="POST" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="bill_id" value="{{$billHistory->id}}">
                            <input type="hidden" name="customer_name" value="{{$billHistory->customer_name}}">
                            <input type="hidden" name="customer_number" value="{{$billHistory->customer_number}}">
                            
                            <button type="submit" class="btn btn-outline-secondary btn-fw bg-blue-600 text-black  text-capitalize hidden-print">Share</button>
                            <button type="button" onclick="printPage()" class="btn btn-outline-secondary btn-fw bg-blue-600 text-black  text-capitalize hidden-print">Print</button>
                        </form>
                    @else
                        <button type="button" class="btn btn-outline-secondary btn-fw bg-blue-600 text-black  text-capitalize customerShare" data-bs-toggle="modal" data-bs-target="#customer">Share</button>
                        <button type="button" onclick="printPage()" class="btn btn-outline-secondary btn-fw bg-blue-600 text-black  text-capitalize hidden-print">Print</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Customer -->
    <div class="modal fade" id="customersharebill">
        <div class="modal-dialog modal-dialog-centered custom-modal-two">
            <div class="modal-content">
            <form action="{{ route('sharebilltowhatsapp') }}"  method="POST" enctype="multipart/form-data">
            @csrf
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Customer Detail</h4>
                            </div>
                        </div>
                        <input type="hidden" name="bill_id" value="{{$billHistory->id}}">
                        <div class="modal-body custom-modal-body">
                            <div class="mb-3">
                                <label class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                                <span id="error-msgCustomername" style="color:red;"></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Customer Number</label>
                                <input type="number" class="form-control" id="customer_number" name="customer_number" required>
                                <span id="error-msgCustomerNumber" style="color:red;"></span>
                            </div>
                            <div class="modal-footer-btn">
                                <!-- <a href="javascript:void(0);" class="btn btn-cancel me-2 close"
                                    data-bs-dismiss="modal">Cancel</a>
                                <a type="submit" href="javascript:void(0);" class="btn btn-submit">Submit</a> -->
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-primary back">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- Add Customer -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
     <!-- Include Popper.js (required for Bootstrap) -->
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <!-- Include Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        function printPage() {
            // Apply the print styles
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.type = 'text/css';
            link.href = 'path/to/print.css';
            document.head.appendChild(link);
            
            // Trigger the print dialog
            window.print();
            
            // Remove the added link element to avoid affecting the screen view
            document.head.removeChild(link);
        }

        $('.customerShare').click(function(){
            $('#customersharebill').modal('show');
            $('#all').hide();
        })

        $('.back').click(function(){
            $('#customersharebill').modal('hide');
            $('#all').show();
        })
    </script>

</body>
</html>
