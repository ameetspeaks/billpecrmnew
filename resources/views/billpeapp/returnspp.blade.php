@extends('billpeapp.layout.app')

@section('content')

<div class="first_nav_hero_about">
    <!-- ======== 1.1. header section ======== -->
    @include('billpeapp/layout/header')
    <!-- ======== End of 1.1. header section ========  -->
    <!-- ========  6.1. team-hero section ========  -->
    <div class="container text-white">
        <div class="team-hero">
            <h2 class="text-center">Refund and Cancellation Policy</h2>
            <p class="text-center"></p>
        </div>
    </div>
    <!-- ======== End of 6.1. team-hero section ========  -->
</div>

<div class="container mt-5 text-white">
    <!-- ======== 6.2. Refund Eligibility section ========  ========  -->
    <div class="refund-eligibility">
        <h3>Refund Eligibility</h3>
        <p>ParcelPe Refunds are considered if the request is made same day of receipt for damaged or defective products. Once an order is dispatched, no refunds or returns will be offered, except in cases where the product is damaged, expired, or in any unforeseen circumstances. Return requests are not applicable once the order is dispatched.</p>
    </div>
    <!-- ======== End of 6.2. Refund Eligibility section ========  -->
    
    <!-- ======== 6.3. Timeframes section ========  -->
    <div class="timeframes mt-4">
        <h3>Refund Timeline</h3>
        <p>Refunds, if applicable, will be issued to the end customer within 14 days of the request.</p>
    </div>
    <!-- ======== End of 6.3. Timeframes section ========  -->
    
    <!-- ======== 6.4. Return/Replace Request Process section ========  -->
    <div class="return-process mt-4">
        <h3>Return and Replacement Request Process</h3>
        <p>As return requests are not applicable once an order is dispatched, please ensure that you check the product upon receipt. If the product is damaged, expired, or if there are unforeseen circumstances, contact our Customer Service team immediately.</p>
    </div>
    <!-- ======== End of 6.4. Return/Replace Request Process section ========  -->
    
    <!-- ======== 6.5. Cancellation Procedures section ========  -->
    <div class="cancellation-procedures mt-4">
        <h3>Cancellation Procedures</h3>
        <p>Orders can be canceled if the request is made before the order is dispatched. Once the order is dispatched, cancellations will not be accepted. To cancel an order, contact our Customer Service team as soon as possible.</p>
    </div>
    <!-- ======== End of 6.5. Cancellation Procedures section ========  -->
    
    <!-- ======== 6.6. Cancellation Fees and Requirements section ========  -->
    <div class="fees-requirements mt-4">
        <h3>Cancellation Fees and Requirements for ParcelPe </h3>
        <p>No fees are applied for cancellations made before the order is dispatched. Once the order is dispatched, cancellations are not possible. For returns of devices, a standard deduction of 40% or up to ₹2000 (whichever is higher) is applicable. For any issues with products under manufacturer warranties, please contact the manufacturer directly.</p>
    </div>
    <!-- ======== End of 6.6. Cancellation Fees and Requirements section ========  -->
</div>

<div class="container mt-5 text-white">
    <!-- ======== 6.7. Contact Information section ========  -->
    <div class="contact-information">
        <h3>Contact Information</h3>
        <p>If you have any questions or need further assistance, please reach out to our Customer Service team.</p>
        <ul>
            <li>Email: parcelpe@gmail.com</li>
            <li>Phone: 7290009110</li>
        </ul>
        <p>Thank you for choosing ParcelPe, a product by ARJH TECH LABS PRIVATE LIMITED.</p>
    </div>
    <!-- ======== End of 6.7. Contact Information section ========  -->
</div>

@endsection
