@extends('billpeapp.layout.app')

@section('content')

<div class="first_nav_hero_about">
    <!-- ======== 1.1. header section ======== -->
    @include('billpeapp/layout/header')
    <!-- ======== End of 1.1. header section ========  -->
    <!-- ======== 3.1. hero section ========  -->
    <section class="feature-hero"  data-aos="zoom-in">
        <div class="container">
            <h1 class="text-center">FEATURES</h1>
            <p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro quasi
                obcaecati dolorum!</p>
            <div class="position-relative">
                <div class="featur-video">
                    <a class="video-play-button" href="#">
                        <span class="fa-solid fa-play"></span>
                    </a>

                </div>
                <figure class="feature-img"><img src="{{url('public/billpeapp/assets/images/feauter/feature-girl.png')}}" alt="img">
                </figure>
                <figure class="feature-img2"><img src="{{url('public/billpeapp/assets/images/feauter/feature-rect.png')}}" alt="img">
                </figure>
            </div>
        </div>
    </section>
    <!-- ======== End of 3.1. hero section ========  -->
</div>

<!-- ======== 1.7. services section ========  -->
<section class="services">
    <div class="container">
        <div class="row gap-md-0 gap-sm-4 gap-4">
            <div class="col-lg-6 col-md-6" data-aos="fade-down">
                <h2 class="text-lg-start text-md-start text-sm-center text-center">EXCEPTIONAL SERVICES AND
                    SOLUTIONS</h2>
                <p
                    class="text-lg-start text-md-start text-sm-center text-center mt-lg-4 mt-md-2 mt-sm-2 mt-2 pb-4 ">
                    Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Odio possimus quo ducimus
                    suscipit
                    officiis natus impedit et deleniti omnis, sint, facere aliquam asperiores dolores qui id
                    mollitia obcaecati error perferendis.</p>
                <div class=" d-flex  justify-content-center gap-lg-4 gap-md-3 gap-sm-2 gap-2">
                    <div class="offers">
                        <h5 class="mb-2">Any Time Transection</h5>
                        <p class="p-f-s">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Consequatur!</p>
                    </div>
                    <div class="offers">
                        <h5 class=" mb-2">Zero Hidden Cost</h5>
                        <p class="p-f-s">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Consequatur!</p>
                    </div>
                </div>
                <div
                    class="serives-btn justify-content-md-start justify-content-ms-center justify-content-center d-flex">
                    <a class="btn-hover1" href="#">Learn More</a>
                    <div class="d-flex align-items-center">
                        <a class="ps-4" href="#">Register Now </a>
                        <i class="fa-solid fa-greater-than ps-md-3 ps-sm-1 ps-0"></i>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center sevices_img"
                data-aos="fade-up">
                <div class="position-relative">
                    <div class="social-rating">
                        <div class="d-flex">
                            <div class="d-flex">
                                <span><i class="fa-brands fa-youtube"></i></span>
                                <div>
                                    <h6>Youtube Premium</h6>
                                    <p>9 June 2023</p>
                                </div>
                            </div>
                            <div class="d-flex text-pink">
                                <p>-$</p>
                                <p class="count">3.00</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="d-flex">
                                <span><i class="fa-brands fa-facebook"></i></span>
                                <div>
                                    <h6>Facebook Ads</h6>
                                    <p>5 June 2023</p>
                                </div>
                            </div>
                            <div class="d-flex text-green">
                                <p>+$</p>
                                <p class="count">21.00</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="d-flex">
                                <span><i class="fa-brands fa-pinterest-p"></i></span>
                                <div>
                                    <h6>Pinterest</h6>
                                    <p>2 June 2023</p>
                                </div>
                            </div>
                            <div class="d-flex text-pink">
                                <p>-$</p>
                                <p class="count">14.00</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="d-flex">
                                <span><i class="fa-brands fa-twitter"></i></span>
                                <div>
                                    <h6>Twitter</h6>
                                    <p>1 June 2023</p>
                                </div>

                            </div>
                            <div class="d-flex text-green">
                                <p>+$</p>
                                <p class="count">51.00</p>
                            </div>
                        </div>
                    </div>
                    <figure><img src="{{url('public/billpeapp/assets/images/feauter/lady-mobile.png')}}" alt="sevice_img2"></figure>
                    <figure><img src="{{url('public/billpeapp/assets/images/icon/whitStar.png')}}" alt="sevice_img3"></figure>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======== End of 1.7. services section ========  -->
<!-- ======== 3.2. core section ========  -->
<section class="core">
    <div class="container">
        <h2 class="text-center">CORE FEATURES</h2>
        <p class="core-p">Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati qui repellat,
            consectetur adipisicing elit.blanditiis rem earum dolore corrupti vel!</p>
        <div class="row d-flex gap-md-0 gap-sm-5 gap-5">
            <div class="col-lg-4 col-md-4 d-flex flex-column gap-3 justify-content-center" data-aos="fade-up">
                <div class="core-card">
                    <h5>Secure Transactions</h5>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non veniam reiciendis
                        molestiae.</p>
                </div>
                <div class="core-card">
                    <h5>Seamless Integration</h5>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non veniam reiciendis
                        molestiae.</p>
                </div>
                <div class="core-card">
                    <h5>Robust Security</h5>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non veniam reiciendis
                        molestiae.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 d-flex justify-content-center align-items-center" data-aos="zoom-in">
                <figure><img src="{{url('public/billpeapp/assets/images/feauter/mobile.png')}}" alt="img"></figure>
            </div>
            <div class="col-lg-4 col-md-4 d-flex flex-column gap-3 justify-content-center" data-aos="fade-down">
                <div class="core-card1">
                    <h5>Multiple Payment</h5>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non veniam reiciendis
                        molestiae.</p>
                </div>
                <div class="core-card1">
                    <h5>Customizable Checkout</h5>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non veniam reiciendis
                        molestiae.</p>
                </div>
                <div class="core-card1">
                    <h5>Reporting and Analytics</h5>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non veniam reiciendis
                        molestiae.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======== End of 3.2. core section ========  -->
<!-- ======== 1.8. visa section ========  -->
<section class="visa mt-md-5 mt-sm-5 mt-5 mb-0">
    <div class="container">
        <div class="visa-bg" data-aos="zoom-in">
            <figure><img src="{{url('public/billpeapp/assets/images/feauter/vesa-back.png')}}" alt="visa-img"></figure>
        </div>
        <div class="visa-contant" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <h3 class="text-md-start text-sm-center text-center">Replacing complexity with
                        simplicity
                    </h3>
                    <p class="text-md-start text-sm-center text-center p-f-s">Lorem ipsum dolor sit amet
                        consectetur
                        adipisicing elit. Iusto doloribus adipisci facere voluptatum, suscipit deserunt,
                        cupiditate
                        facilis impedit assumenda saepe, in vitae labore molestias.</p>
                    <p class="text-md-start text-sm-center text-center p-f-s">Lorem ipsum dolor sit amet
                        consectetur
                        adipisicing elit. Nam aut explicabo at qui laudantium.</p>
                    <div class="visa-btn text-sm-center text-md-start text-center">
                        <a class="btn-hover1" href="#">Try PayPath Now</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="visa-logo d-flex justify-content-between align-items-center pt-2 pb-3">
                        <figure><img src="{{url('public/billpeapp/assets/images/icon/vis-1.png')}}" alt="vica-icon1"> </figure>
                        <figure><img src="{{url('public/billpeapp/assets/images/icon/ves-2.png')}}" alt="vica-icon2"></figure>
                        <figure><img src="{{url('public/billpeapp/assets/images/icon/ves-3.png')}}" alt="vica-icon3"></figure>
                        <figure><img src="{{url('public/billpeapp/assets/images/icon/ves-4.png')}}" alt="vica-icon4"></figure>
                        <figure><img src="{{url('public/billpeapp/assets/images/icon/ves-5.png')}}" alt="vica-icon5"></figure>
                    </div>
                    <div
                        class="d-flex pt-2 justify-content-md-start justify-content-center justify-content-center">
                        <h2 class="count">280</h2>
                        <h2>+</h2>
                        <h6 class="d-flex align-items-center ps-2 ">Integrations</h6>
                    </div>
                    <p class="pt-2 pb-3 text-md-start text-sm-center text-center p-f-s">Lorem ipsum dolor sit
                        amet consectetur, adipisicing elit. Illum
                        laboriosam
                        officiis autem ut sit mollitia blanditiis.</p>
                    <div class="visa-card position-relative mt-3">
                        <img src="{{url('public/billpeapp/assets/images/feauter/Card.png')}}" alt="visa-card">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======== End of 1.8. visa section ========  -->

@endsection