@extends('billpeapp.layout.app')

@section('content')


<div class="first_nav_hero_about">
    <!-- ======== 11.1. Coming hero section ======== -->
    <section>
        <div class="container">
            <div class="row coming-hero d-flex gap-md-0 gap-sm-4 gap-4">
                <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center" data-aos="fade-up">
                    <figure class="d-flex align-items-center justify-content-lg-end justify-content-md-center justify-content-center"><img src="{{url('public/billpeapp/assets/images/coming/coming-soon.png')}}" class="moving" alt="img"></figure>
                </div>
                <div class="col-lg-6 col-md-6 d-flex flex-column align-items-md-start align-items-ms-center align-items-center text-md-start text-sm-center text-center" data-aos="fade-down">
                    <h3>WE ARE</h3>
                    <h2>COMING SOON</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi nihil numquam natus corporis dolorem obcaecati esse, deleniti ex maiores libero?</p>
                    <a class="btn-hover1" href="{{route('index')}}">Back to Home</a>
                </div>
            </div>
        </div>
    </section>
        <!-- ======== End of 11.1. Coming hero section ======== -->
        <!-- ======== 11.2. Coming footer section ======== -->
    <div class="footer-coming">
        <div class="d-flex align-items-center justify-content-center gap-4">
            <a href="#"> <i class="fa-brands fa-facebook-f"></i></a>
            <a href="#"> <i class="fa-brands fa-twitter"></i></a>
            <a href="#"> <i class="fa-brands fa-instagram"></i></a>
        </div>
        <p class="text-center ps-1 pe-1">Copyright © 2023 Paypath by Evonicmedia. All Right Reserved.</p>
    </div>
        <!-- ======== End of 11.2. Coming footer section ======== -->
</div>

@endsection