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
        <p>Refunds are considered if the request is made within 3 days of TRIAL period of APP/Desktop. Products that are damaged or defective upon receipt are eligible for refunds or replacements, pending verification by our Customer Service team. Non-refundable/non-cancellable products include all kind of printer and scanner.</p>
    </div>
    <!-- ======== End of 6.2. Refund Eligibility section ========  -->
    
    <!-- ======== 6.3. Timeframes section ========  -->
    <div class="timeframes mt-4">
        <h3>Refund Timeline</h3>
        <p>Refund will be issued to the end customer in 14 days (if applicable). </p>
    </div>
    <!-- ======== End of 6.3. Timeframes section ========  -->
    
    <!-- ======== 6.4. Return/Replace Request Process section ========  -->
    <div class="return-process mt-4">
        <h3>Cancellation Timeline</h3>
        <p>You are eligible to cancel your subscription within 3 days (only if it is applicable).  </p>
    </div>
    <!-- ======== End of 6.4. Return/Replace Request Process section ========  -->
    
    <-- ======== 6.5. Cancellation Procedures section ========  -->
    <div class="cancellation-procedures mt-4">
        <h3>Cancellation Procedures</h3>
        <p>Cancellations are accepted if requested immediately after placing the order. Cancellations may not be accepted if the order has been processed and shipped. To cancel an order, contact our Customer Service team as soon as possible.</p>
    </div>
    <!-- ======== End of 6.5. Cancellation Procedures section ========  -->
    
    <!-- ======== 6.6. Cancellation Fees and Requirements section ========   -->
    <div class="fees-requirements mt-4">
        <h3>Cancellation Fees and Requirements</h3>
        <p>No fees for cancellations requested immediately after placing the order, provided the order has not been processed and shipped. Once processed and shipped, cancellation requests will not be entertained. In case of return of device standard deduction 40% upto ₹2000 or (which is higher) is applicable 
        For any issues regarding products with manufacturer warranties, please contact the manufacturer directly.</p>
    </div>
    <!-- ======== End of 6.6. Cancellation Fees and Requirements section ========  -->
</div>

<div class="container mt-5 text-white">
    <!-- ======== 6.7. Contact Information section ========  ========  -->
    <div class="contact-information">
        <h3>Contact Information</h3>
        <p>If you have any questions or need further assistance, please reach out to our Customer Service team.</p>
        <ul>
            <li>Email: billpeapp@gmail.com</li>
            <li>Phone: 7290009110</li>
        </ul>
        <p>Thank you for choosing BillPe, a product by ARJH TECH LABS PRIVATE LIMITED.</p>
    </div>
    <!-- ======== End of 6.7. Contact Information section ========  -->
</div>

@endsection
