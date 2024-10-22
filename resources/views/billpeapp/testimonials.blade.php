@extends('billpeapp.layout.app')

@section('content')

<div class="first_nav_hero_about">
    <!-- ======== 1.1. header section ======== -->
    @include('billpeapp/layout/header')
    <!-- ======== End of 1.1. header section ========  -->
    <!-- ======== 7.1. testimonials-hero section ========  -->
    <div class="container">
        <div class="testimon-hero">
            <h2>TESTIMONIALS</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto eligendi in provident nam impedit corporis?</p>
        </div>
    </div>
    <!-- ======== End of 7.1. testimonials-hero section ========  -->
    <!-- ======== 1.10. profaessional section ========  -->
    <section class="profaessional mb-lg-4 mb-md-2 mb-sm-1 mb-1">
        <div class="container">
            <div class="prof-size d-flex flex-column gap-5">
                    <div class="prof-slid position-relative" data-aos="zoom-in-up">
                        <div>
                            <div class="d-flex  align-items-center justify-content-center">
                                <img src="{{url('public/billpeapp/assets/images/slider/profational2.jpg')}}" alt="img" class="prof-img-2">
                            </div>
                            <div class="pe-3">
                                <img src="{{url('public/billpeapp/assets/images/slider/Comma.png')}}" alt="img" class="prof-img-1">
                            </div>
                            <p class="text-center p-f-s">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                                Enim
                                qui
                                porro perferendis voluptatibus minima, eius illo animi nihil sed natus! Deleniti
                                officia
                                dolores culpa alias quasi repellat corrupti doloremque aliquam!</p>
                            <div class="prof-star pt-2 pb-2 text-center">
                                <span class="stars text-lg-start">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                            </div>
                            <h5 class="text-center">Johnny Stone</h5>
                            <p class="text-center pt-2 pb-5 p-f-s">Entrepreneur</p>
                        </div>
                    </div>
                    <div class="prof-slid position-relative" data-aos="zoom-in-up">
                        <div>
                            <div class="d-flex  align-items-center justify-content-center">
                                <img src="{{url('public/billpeapp/assets/images/slider/profactional3.jpg')}}" alt="img" class="prof-img-2">
                            </div>
                            <div class="pe-3">
                                <img src="{{url('public/billpeapp/assets/images/slider/Comma.png')}}" alt="img" class="prof-img-1">
                            </div>
                            <p class="text-center p-f-s">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                                Enim
                                qui
                                porro perferendis voluptatibus minima, eius illo animi nihil sed natus! Deleniti
                                officia
                                dolores culpa alias quasi repellat corrupti doloremque aliquam!</p>
                            <div class="prof-star pt-2 pb-2 text-center">
                                <span class="stars text-lg-start">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                            </div>
                            <h5 class="text-center">Stephen Stewart</h5>
                            <p class="text-center pt-2 pb-5 p-f-s">Entrepreneur</p>
                        </div>
                    </div>
                    <div class="prof-slid position-relative" data-aos="zoom-in-up">
                        <div>
                            <div class="d-flex  align-items-center justify-content-center">
                                <img src="{{url('public/billpeapp/assets/images/slider/profacitional.jpg')}}" alt="img" class="prof-img-2">
                            </div>
                            <div class="pe-3">
                                <img src="{{url('public/billpeapp/assets/images/slider/Comma.png')}}" alt="img" class="prof-img-1">
                            </div>
                            <p class="text-center p-f-s">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                                Enim
                                qui
                                porro perferendis voluptatibus minima, eius illo animi nihil sed natus! Deleniti
                                officia
                                dolores culpa alias quasi repellat corrupti doloremque aliquam!</p>
                            <div class="prof-star pt-2 pb-2 text-center">
                                <span class="stars text-lg-start">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                            </div>
                            <h5 class="text-center">Tom Hiddellon</h5>
                            <p class="text-center pt-2 pb-5 p-f-s">Entrepreneur</p>
                        </div>
                    </div>
            </div>
        </div>
    </section>
    <!-- ======== End of 1.10. profaessional section ========  -->
</div>

@endsection