@component('admin.component')
@slot('title') Order @endslot
@slot('subTitle') Order Detail @endslot
@slot('content')

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }

    .container {
        display: flex;
        max-width: 1200px;
        margin: 40px auto;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    /* Column A Styling */
    .column-a {
        width: 70%;
        padding: 20px;
        border-right: 1px solid #ddd;
    }

    .column-b {
        width: 30%;
        padding: 20px;
    }

    /* Order Header */
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .order-number {
        font-size: 22px;
        font-weight: bold;
    }

    .order-header button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    /* Order Details */
    .order-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .order-details p {
        margin: 5px 0;
        color: #555;
    }

    /* Table Styling */
    .items table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .items table th, .items table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    .items table th {
        background-color: #f7f7f7;
    }

    /* Totals Section */
    .totals {
        margin-top: 20px;
    }

    .totals-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
    }

    .totals-row strong {
        font-weight: bold;
    }

    .totals-row:last-child {
        font-size: 18px;
        font-weight: bold;
    }

    /* Column B Styling */
    .section {
        margin-bottom: 30px;
    }

    .section h3 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #333;
    }

    .info p {
        margin: 5px 0;
        color: #555;
    }

    /* .dropdown {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
    } */

    .section .assign-hero {
        display: flex;
        flex-direction: column;
    }

    /* General Styling */
    h3 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    p {
        color: #666;
        margin-bottom: 10px;
    }
</style>

<div class="text-right col-12">
    {{-- <a href="{{ route('admin.product.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Add product</button>
    </a> --}}
    {{-- <button type="button" class="btn btn-outline-secondary btn-fw  text-capitalize">Export</button>
    <button type="button" class="btn btn-outline-secondary btn-fw  text-capitalize">Import</button> --}}
</div>

<div class="text-right col-12">
 <span class="text-xs text-red-500 mt-2 errmsg_productExcel"></span>
 <div>
    <ul id="showExportError">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
            @endforeach
        @endif
    </ul>
 </div>
</div>

<div class="text-right col-12">
    <span class="text-xs text-green-500 mt-2 successmsg_productExcel"></span>
</div>


<div class="">
    <!-- Column A -->
    <form class="form-inline" id="orderStatusForm">
        @csrf <!-- Include CSRF token for security -->
        <label for="order" class="mr-sm-2">Order:</label>    
        <select class="form-control mb-2 mr-sm-5" name="order_id" id="order_id" required>
            <option value="">Select Order</option>
            @foreach($orders as $order)
                <option value="{{ $order->id }}">Order No: {{ $order->id }}</option>
            @endforeach
        </select>
        
        <label for="order_status" class="mr-sm-2">Order Status:</label>
        <select class="form-control mb-2 mr-sm-5" name="order_status_id" id="order_status_id" required>
            <option value="">Select Status</option>
            @foreach($allOrderStatus as $orderStatus)
                <option value="{{ $orderStatus->id }}">{{ $orderStatus->name }}</option>
            @endforeach
        </select>
        
        <button type="submit" class="btn btn-primary mb-2">Change Status</button>
    </form>

    <!-- Place to show success message -->
    <div id="responseMessage"></div>

</div>



{{-- close model --}}

@endslot
@slot('script')
<script>

$(document).ready(function () {
    $('#orderStatusForm').on('submit', function (e) {
        e.preventDefault(); // Prevent form from submitting the traditional way

        var order_id = $('#order_id').val();
        var order_status_id = $('#order_status_id').val();

        if (order_id && order_status_id) {
            $.ajax({
                url: "{{ route('admin.updateOrderStatus') }}", // Route defined in Laravel
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: order_id,
                    order_status_id: order_status_id
                },
                success: function (response) {
                    // alert(response.message);
                    $('#responseMessage').html('<div class="alert alert-success">' + response.message + '</div>');

                    // Optionally clear the form
                    $('#orderStatusForm')[0].reset();

                    // If you want to trigger further actions on success, you can do it here.
                },
                error: function (xhr) {
                    // Show an error message if the request fails
                    $('#responseMessage').html('<div class="alert alert-danger">Something went wrong. Please try again.</div>');
                }
            });
        } else {
            $('#responseMessage').html('<div class="alert alert-warning">Please select an order and status.</div>');
        }
    });
});

</script>
@endslot
@endcomponent