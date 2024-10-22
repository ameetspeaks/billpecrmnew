@extends('billpeapp.layout.app')

@section('content')

<div class="first_nav_hero_about">
    <!-- ======== 1.1. header section ======== -->
    @include('billpeapp/layout/header')
    <!-- ======== End of 1.1. header section ========  -->
    <!-- ========  6.1. team-hero section ========  -->
    <div class="container text-white">
        <div class="team-hero">
            <h2 class="text-center">Privacy Policy</h2>
        </div>
    </div>
    <!-- ======== End of 6.1. team-hero section ========  -->
</div>

<div class="container mt-5 text-white">
    <div class="privacy-policy">
        <h3>Shipping Policy</h3>
        <p class="pt-3">Last updated on 10-09-2024 10:00:00</p>
        <p class="pt-3">At ParcelPe, we are dedicated to providing you with swift and efficient delivery services. Our goal is to ensure that your orders reach you within 10 minutes of confirmation, bringing your essentials right to your doorstep promptly and reliably.
    </p>
        <p class="pt-3"><strong>Processing Time</strong><br></p>
        <ul class="pt-3">
            <li>Order Processing: Orders are processed immediately upon receipt. Our team will confirm your order and prepare it for delivery.</li>
            <li>Delivery Time: We strive to deliver all orders within 10 minutes. Delivery times may vary slightly based on the distance from the store and current traffic conditions.</li>
            
        </ul>
        <p class="pt-3">Delivery Areas: We operate within specified local zones. Please ensure that your delivery address is within our serviceable area. For a list of serviceable areas, please refer to the service area map available on our app or website.</p>
        
        <p class="pt-3"><strong>Delivery Conditions</strong><br> Packing: Orders must be packed carefully to ensure they reach you in perfect condition. Items are packed according to their type and requirement.</p>
        <p class="pt-3"><strong>ParcelPe - Delivery Service Details</strong><br>As part of our delivery service, ParcelPe facilitates the timely delivery of your orders. We collect and use your delivery address, contact information, and order details to ensure accurate and efficient delivery. The information collected is used solely for the purpose of delivering your orders and for improving our delivery services.</p>
        <p class="pt-3">For the ParcelPe service, we may share your delivery information with our trusted delivery partners to fulfill your orders. These partners are bound by confidentiality agreements and are only permitted to use your data for the purpose of completing your delivery.</p>
        <p class="pt-3">ParcelPe ensures that your data is handled with the utmost care and in compliance with applicable data protection laws. We take appropriate measures to safeguard your information during the delivery process.</p>
        <p class="pt-3"><strong>Who do we share your data with</strong><br>We may share your information or data with:</p>
        <ul class="pt-3">
            <li>Third parties including our service providers in order to facilitate the provisions of goods or services to you, carry out your requests, respond to your queries, fulfill your orders or for other operational and business reasons.</li>
            <li>With our group companies (to the extent relevant)</li>
            <li>Our auditors or advisors to the extent required by them for performing their services</li>
            <li>Governmental bodies, regulatory authorities, law enforcement authorities pursuant to our legal obligations or compliance requirements.</li>
        </ul>

</div>

@endsection
