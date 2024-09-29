@component('admin.component')
@slot('title') Delivery Partner @endslot
@slot('subTitle') Delivery Partner Detail @endslot
@slot('content')

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }

    .container_custom {
        width: 100%;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    /* Column B Styling */
    .section {
        margin-bottom: 30px;
        width: 100%;
    }

    .section h3 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #333;
    }

    .column-b {
        padding: 20px;
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
    .bd-top {
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }
    .section img {
        max-height: 150px;
    }
</style>

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


<div class="container_custom">
    <div class="column-b">
        <!-- Personal Details Section -->
        <div class="section">
            @php
                if($user->account_status == "Approved") {
                    $account_status_class = "btn-success";
                } else if ($user->account_status == "Rejected") {
                    $account_status_class = "btn-primary";
                } else {
                    $account_status_class = "btn-info";
                }
            @endphp
            <h3>Account Status</h3>
            <button class="btn {{ $account_status_class }} btn-sm mb-3">{{ $user->account_status }}</button>
            @php
                $accountStatus = [
                    "Pending",
                    "Approved",
                    "Rejected"
                ];
            @endphp
            <select class="form-control accountStatusChange" style="max-width: 200px;">
                @foreach ($accountStatus as $item)
                    <option value="{{ $item }}" {{ $item == $user->account_status ? 'selected' : '' }}>{{ $item }}</option>
                @endforeach
            </select>
        </div>
        <div class="section bd-top">
            <div class="row">
                <div class="col-md-6">
                    <!-- Personal Details Section -->
                    <h3>Personal Details</h3>
                    <p><strong>Name:</strong> {{$user->delivery_boy_detail->name}} </p>
                    <p><strong>Email ID:</strong> {{$user->delivery_boy_detail->email}} </p>
                    <p><strong>Mobile No:</strong> +91-{{$user->delivery_boy_detail->whatsapp_no}}</p>
                    @if($user->delivery_boy_detail->address)
                    {{-- <p><strong>Address:</strong> {{$user->delivery_boy_detail->address}} , {{$user->delivery_boy_detail->city}} , {{$user->delivery_boy_detail->state}} , {{$user->delivery_boy_detail->country}} </p> --}}
                    @endif
                </div>
                <div class="col-md-6">
                    <!-- Work Details Section -->
                    <h3>Work Details</h3>
                    <p><strong>Type:</strong> {{@$user->shift_detail->type}}</p>
                    <p><strong>Shift:</strong> {{@$user->shift_detail->name}}</p>
                    @php
                        $from = Carbon\Carbon::parse(@$user->shift_detail->from);
                        $from = $from->format('g:i A');
            
                        $to = Carbon\Carbon::parse(@$user->shift_detail->to);
                        $to = $to->format('g:i A');
                    @endphp
                    <p><strong>Time:</strong> {{@$user->shift_detail->from ? $from .' - '. $to : ''}}</p>
                </div>
            </div>
        </div>

        <!-- KYC Details Section -->
        <div class="section bd-top">
            <h3>KYC Details</h3>
            <div class="row">
                <div class="col-md-4">
                    <p><strong>AADHAR NO:</strong> {{$user->delivery_boy_detail->aadhar_number}}</p>
                </div>
                <div class="col-md-4">
                    <img src="{{$user->aadhar_front_img}}" alt="Front img" loading="lazy">
                </div>
                <div class="col-md-4">
                    <img src="{{$user->aadhar_back_img}}" alt="Back img" loading="lazy">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <p><strong>PAN No:</strong> {{$user->pan_number}}</p>
                </div>
                <div class="col-md-4">
                    <img src="{{$user->pan_front_img}}" alt="Front img" loading="lazy">
                </div>
            </div>
        </div>

        <!-- Bike Details Section -->
        <div class="section bd-top">
            <h3>Bike Details</h3>
            <div class="row">
                <div class="col-md-4">
                    <p><strong>DL No:</strong> {{$user->delivery_boy_detail->driving_licence}}</p>
                </div>
                <div class="col-md-4">
                    <img src="{{$user->dl_front_img}}" alt="Front img" loading="lazy">
                </div>
                <div class="col-md-4">
                    <img src="{{$user->dl_back_img}}" alt="Back img" loading="lazy">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <p><strong>Registration Cerificate No:</strong> {{$user->rc_number}}</p>
                </div>
                <div class="col-md-4">
                    <img src="{{$user->rc_front_img}}" alt="Front img" loading="lazy">
                </div>
                <div class="col-md-4">
                    <img src="{{$user->rc_back_img}}" alt="Back img" loading="lazy">
                </div>
            </div>
        </div>

        <!-- Bank Details Section -->
        <div class="section bd-top">
            <h3>Bank Details</h3>
            <p><strong>Bank Name:</strong> {{$user->bank_name}}</p>
            <p><strong>Account Holder Name:</strong> {{$user->account_holder_name}}</p>
            <p><strong>Account Number:</strong> {{$user->account_number}}</p>
            <p><strong>IFSC:</strong> {{$user->ifsc}}</p>
        </div>
    </div>
</div>
    @slot('script')
        <script>
            //change account status
            $(document).on('change', '.accountStatusChange', function(){
                var id = '{{ $user->user_id }}';
                var account_status = $(this).val();

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to change account status!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, status updated!"
                    }).then(function(result) {
                    if(result.value){

                        $.ajax({
                            url: "{{ route('admin.deliveryPartner.accountStatusChange') }}",
                            method: 'post',
                            data: { "_token" : "{{csrf_token()}}", 'id': id , 'account_status': account_status},
                            success: function(data)
                            {
                                if(data.status == false){
                                    Swal.fire(data.title,data.message,data.type);
                                } else {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Status!",
                                        text: "Status updated successfully.",
                                        timer: 1500
                                    }).then(function() {
                                        location.reload();
                                    });
                                }
                            }
                        });

                    }else{
                        location.reload();
                    }
                });
            })
        </script>
    @endslot
@endslot
@endcomponent
