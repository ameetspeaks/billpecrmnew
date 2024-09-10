<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Fav Icon --}}
    <link rel="shortcut icon" href="{{ asset('public/admin/upload/'.\App\Models\Setting::where('type','company_fav_icon')->first()->value) }}" />
    
    <title>BillPe Billing APP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .invoice-container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: right;
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            height: 100px;
            width: 100px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header .invoice-number {
            font-size: 14px;
            color: #888;
        }
        .details, .items, .total {
            width: 100%;
            margin-top: 20px;
        }
        .details td, .items td, .total td {
            padding: 5px;
        }
        .details .title {
            background: #FFA500;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
        .details th {
            text-align: left;
            width: 25%;
        }
        .details td {
            text-align: left;
            width: 25%;
        }
        .items th, .items td {
            border: 1px solid #ddd;
            text-align: center;
        }
        .items th {
            background: #FFA500;
            color: #fff;
        }
        .total td {
            text-align: right;
        }
        .footer {
            /* text-align: center; */
            color: #888;
            font-size: 17px;
            margin-top: 20px;
        }
        .btnsave {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .btn {
            margin-left: 10px;
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="btnsave">
            @if(Auth::user())
                @if(Auth::user()->role_type == 2)
                <a href="{{ route('store.dashboard') }}"><button type="button" class="btn btn-light">Home</button></a>
                @elseif(Auth::user()->role_type == 7 || Auth::user()->role_type == 8)
                <a href="{{ route('admin.store.manualPayment') }}"><button type="button" class="btn btn-light">Home</button></a>
                @endif
            @endif
            <button type="button" class="btn btn-light" onclick="printPage()">Print</button>
        </div>
        <div class="header">
            <img src="{{ asset('public/admin/upload/'.\App\Models\Setting::where('type', 'company_logo')->first()->value)}}" alt="BillPe Logo">
            <div>
                <h1>INVOICE</h1>
                <div class="invoice-number">
                    No: BP-{{$packageOrder->order_number}}/2024/2025
                </div>
            </div>
        </div>

        <table class="details">
            <tr class="title">
                <th colspan="4">Buyer Details</th>
            </tr>
            <tr>
                <th>Buyer's Name</th>
                <td>{{$packageOrder->store->shop_name}}</td>
                <th>Order ID</th>
                <td>{{$packageOrder->packagetransection->order_id}}</td>
            </tr>
            <tr>
                <th>Transaction ID</th>
                <td>{{$packageOrder->packagetransection->cf_payment_id}}</td>
                <th>Date & Time</th>
                <td>{{$packageOrder->packagetransection->payment_completion_time}}</td>
            </tr>
            <tr>
                <th>Buyer Contact</th>
                <td>{{$packageOrder->store->user->whatsapp_no}}</td>
                <th>GST No</th>
                <td>{{$packageOrder->store->gst}}</td>
            </tr>
            <tr>
                <th>Billing Address</th>
                <td colspan="3">{{$packageOrder->store->address}} {{$packageOrder->store->city}} {{$packageOrder->store->pincode}}</td>
            </tr>
        </table>
        <table class="items">
            <tr>
                <th>No</th>
                <th>Package Name</th>
                <th>Description</th>
                <th>HSN</th>
                <th>Rate</th>
                <th>GST %</th>
                <th>Total</th>
            </tr>
            <?php $products = json_decode($packageOrder->product_details); ?>
            <tr>
                <td>1</td>
                <td>{{$products->name}}</td>
                <td>{{$products->discription}}</td>
                <td>{{\App\Models\Setting::where('type','company_package_hsn')->first()->value ?? ''}}</td>
                <td>{{$products->price}}</td>
                <td>18</td>
                <td>{{$products->price + $products->price * 18 / 100}}</td>
            </tr>
        </table>
        @if($packageOrder->copanCode)
        <table class="items">
            <tr>
                <td>Discount/Coupon Applied</td>
                <td>{{$packageOrder->copanCode}}</td>
                <td>{{$packageOrder->coupanAmount}}</td>
            </tr>
        </table>
        @endif
        <table class="total">
            <tr>
                <td colspan="3"><b>Total</b></td>
                <td>₹<b>{{$packageOrder->packagetransection->payment_amount}}</b></td>
            </tr>
        </table>
        <div class="footer">
            <p style="font-size: 16px; font-weight:bold">ARJH TECH LABS PVT LTD<br>
            GSTIN: 09AAVCA8770F1Z0<br>
            D-9 Ground Floor Vyapar marg <br>
            Sector 3, Noida Gautam Buddha<br>
             Nagar, Uttar Pradesh India 201301</p>
            <p style="float:right">Sincerely,<br><b>Amit Pandey</b><br>CEO</p>

            <p><b>Warranty on Device:</b> 1-year Manufacturer Warranty from<br>
            the date of dispatch (6 Months on Charger and Battery)<br>
            <b>APP Validity:</b> {{$products->name}} with all functions except of<br>
            add-ons & marketing will be charged separately. </p>
            <p style="text-align: center;font-weight: bold;">This is a computer-generated document. No signature is required.</p>
        </div>
    </div>

    <script>
        function printPage() {
            window.print();
        }
    </script>
</body>
</html>
