@extends('billpeapp.layout.app')

@section('content')

<div class="first_nav_hero_about">
    <!-- ======== 1.1. header section ======== -->
    @include('billpeapp/layout/header')
    <!-- ======== End of 1.1. header section ========  -->
    <!-- ======== 1.2. hero section ======== -->
    <section class="hero">
        <div class="container">
            <div class="row text-md-start text-sm-center text-center gap-md-0 gap-sm-4 gap-5" >
                <div  data-aos="fade-up" class="col-md-6 d-flex align-items-md-start align-items-ms-center align-items-center justify-content-center flex-column" >
                    <h1>Billing Made Easy</h1>
                    <p>Billing in 2 clicks with BillPe- Manage your billing, sales on mobile with BillPe mobile POS
</p>
                    <a class="btn-hover1" href="https://play.google.com/store/apps/details?id=com.arjhtechlabs.billpe">GET FREE TRIAL</a>
                </div>
                <div data-aos="fade-down" class="col-md-6 position-relative d-flex flex-column justify-content-center align-items-center mt-md-0 mt-sm-5 mt-4">
                    <img src="{{url('public/billpeapp/assets/images/index/hero.png')}}" alt="hero_img1" class="moving">
                    <img src="{{url('public/billpeapp/assets/images/index/hero_watch.png')}}" alt="hero_img2">
                    <img src="{{url('public/billpeapp/assets/images/icon/hero_star.png')}}" alt="hero_icon">
                </div>
            </div>
        </div>
    </section>
    <!-- ======== End of 1.2. hero section ========  -->
    <!-- ======== 1.3. about section ========  -->
    <section class="about">
        <div class="container">
            <div class="row text-md-start text-sm-center text-center">
                <div class="col-md-6 d-flex justify-content-between">
                    <div class="ab_card1"  data-aos="flip-left">
                        <h3>About</h3>
                        <p class="p-f-s">BillPe simplifies your invoicing with easy-to-use tools for creating, managing, and sending professional invoices. Our platform ensures secure transactions and efficient billing, empowering your business to thrive and focus on what matters most.</p>
                        <div
                            class="d-flex align-items-center justify-content-lg-start justify-content-md-center justify-content-center">
                            <a class="btn-hover1" href="about.html">Learn More</a>
                            <div class="abut-video">
                                <a class="video-play-button" href="#">
                                <span class="fa-solid fa-play"></span>
                                </a>
    
                            </div>
                            <div class="p-f-s w-v">Watch Demo</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-center mt-md-0 mt-sm-3 mt-3">
                    <div class="ab_card2 d-flex flex-column justify-content-between" data-aos="flip-right">
                        <div>
                            <div class="row gap-md-0 gap-sm-3 gap-3">
                                <div class="col-md-5 col-sm-12 col-12 ">
                                    <div
                                        class="d-flex justify-content-md-start justify-content-sm-center justify-content-center">
                                        <h3 class="count">2500</h3>
                                        <h3>+</h3>
                                    </div>
                                    <p class="p-f-s">Kirana Shops have already joined us!</p>
                                </div>
                                <div class="col-2 p-0 d-flex justify-content-center align-items-center">
                                    <hr>
                                </div>
                                <div class="col-md-5 col-sm-12 col-12 p-0">
                                    <h3>FREE</h3>
                                    <p class="p-f-s">Unlimited Stock Management  Unlimited Billing
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="d-flex mb-3 mt-4 gap-4 justify-content-md-start justify-content-ms-center justify-content-center">
                            <div class="position-relative">
                                <img src="{{url('public/billpeapp/assets/images/index/about_card_img1.jpg')}}" alt="about_img1">
                                <img src="{{url('public/billpeapp/assets/images/index/about_card_img2.jpg')}}" alt="about_img2">
                            </div>
                            <div class="ps-2">
                                <span>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </span>
                                <p>So many people like this service</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- ======== End of 1.3. about section ========  -->

<!-- ======== 1.4. finance section ========  -->
<section class="finance">
    <div class="container text-center">
        <h2>Unlocking the Power of Kirana Shops with BillPe</h2>
        <P class="mt-0">Revolutionize your local retail business with BillPe's efficient invoicing and billing solutions. Streamline operations, enhance customer satisfaction, and focus on growing your Kirana shop with our easy-to-use platform.</P>
        <div class="finanes-card row gap-md-0 gap-sm-4 gap-4">
            <div class="col-lg-4 col-md-4 d-flex justify-content-center pe-lg-3 pe-md-0 pe-sm-3 pe-3">
                <div class="fin-card" data-aos="flip-up">
                    <figure><img src="{{url('public/billpeapp/assets/images/icon/graphe.png')}}" alt="praph"></figure>
                    <h4>Grow Sales</h4>
                    <p class="p-f-s">Boost your revenue with BillPe's efficient invoicing and seamless payment solutions, designed to attract and retain more customers.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 d-flex justify-content-center pe-lg-3 pe-md-0 pe-sm-3 pe-3">
                <div class="fin-card" data-aos="flip-up">
                    <figure> <img src="{{url('public/billpeapp/assets/images/icon/doller.png')}}" alt="doller"></figure>
                    <h4>Manage Stock</h4>
                    <p class="p-f-s">Keep your inventory in check effortlessly with BillPe's real-time stock management, ensuring you never run out of essential items.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 d-flex justify-content-center">
                <div class="fin-card" data-aos="flip-up">
                    <figure><img src="{{url('public/billpeapp/assets/images/icon/arow.png')}}" alt="arow"></figure>
                    <h4>Track Everything</h4>
                    <p class="p-f-s">Stay on top of your business with BillPe's tracking features, offering insights into sales, expenses, and performance for informed decision-making.

                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======== End of 1.4. finance section ========  -->
<!-- ======== 1.5. ispsum section

<div class="ispsum-logo">
    <div class="container">
        <hr>
        <div class="logo_ispsum_slider">
            <a href="#">
                <figure><img src="{{url('public/billpeapp/assets/images/icon/ipsum-1.png')}}" alt="img"></figure>
            </a>
            <a href="#">
                <figure><img src="{{url('public/billpeapp/assets/images/icon/ipsum-2.png')}}" alt="img"></figure>
            </a>
            <a href="#">
                <figure><img src="{{url('public/billpeapp/assets/images/icon/ispum-3.png')}}" alt="img"></figure>
            </a>
            <a href="#">
                <figure><img src="{{url('public/billpeapp/assets/images/icon/ipsum-4.png')}}" alt="img"></figure>
            </a>
            <a href="#">
                <figure><img src="{{url('public/billpeapp/assets/images/icon/ipsum-1.png')}}" alt="img"></figure>
            </a>
            <a href="#">
                <figure><img src="{{url('public/billpeapp/assets/images/icon/ipsum-2.png')}}" alt="img"></figure>
            </a>
            <a href="#">
                <figure><img src="{{url('public/billpeapp/assets/images/icon/ispum-3.png')}}" alt="img"></figure>
            </a>
            <a href="#">
                <figure><img src="{{url('public/billpeapp/assets/images/icon/ipsum-4.png')}}" alt="img"></figure>
            </a>
        </div>
        <hr>
    </div>
</div>
<!-- ======== End of 1.5. ispsum section ========  -->
<!-- ======== 1.6. gateway section 
<section class="gateway">
    <div class="container">
        <div class="row gap-lg-0 gap-md-0 gap-sm-4 gap-4">
            <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center" data-aos="fade-up">
                <div class=" gateway-bg-img mt-5 ">
                    <figure><img src="{{url('public/billpeapp/assets/images/index/gateway-1.png')}}" alt="gate_img1" class="moving"></figure>
                </div>
            </div>
            <div class="col-lg-6 col-md-6  text-md-start text-sm-center text-center" data-aos="fade-down">
                <h2>SIMPLIFY YOUR Store</h2>
                <P class="pt-lg-4 pt-md-3 pt-sm-2 pt-2">Effortlessly create accounts, customize settings, and enjoy full access. Simplify billing, manage stock, and track everything for a seamless retail experience.</P>
                <div
                    class="gate mt-md-3 mt-sm-0 mt-4   d-flex flex-md-row flex-sm-column flex-column align-items-center">
                    <figure class="d-flex align-items-center"><img src="{{url('public/billpeapp/assets/images/icon/gate-icon1.png')}}"
                            alt="gate-img1"></figure>
                    <div class="account-text ms-3">
                        <h5 class="pb-2">1 Click Account Setup</h5>
                        <p class="p-f-s">Get your store up and running 5 Seconds. Just a few simple steps and you're ready to start managing your business efficiently.</p>
                    </div>
                </div>
                <div class="gate d-flex mt-4  flex-md-row flex-sm-column flex-column align-items-center">
                    <figure class="d-flex align-items-center"><img src="{{url('public/billpeapp/assets/images/icon/gate-icon2.png')}}"
                            alt="gate-img2"></figure>
                    <div class="ms-3">
                        <h5 class="pb-2">Effortless Billing</h5>
                        <p class="p-f-s">Keep your inventory organized with BillPe’s real-time stock management. Track stock levels, receive low-stock alerts, and ensure you never run out of essential items.</p>
                    </div>
                </div>
                <div class="gate d-flex mt-4  flex-md-row flex-sm-column flex-column align-items-center">
                    <figure class="d-flex align-items-center"><img src="{{url('public/billpeapp/assets/images/icon/gate-icon3.png')}}"
                            alt="gate-img3"></figure>
                    <div class="ms-3">
                        <h5 class="pb-2">Integrated Barcode Tools</h5>
                        <p class="p-f-s">Simplify inventory and sales management with BillPe’s barcode scanner and generator. Quickly scan items for faster checkout and generate barcodes for efficient product tracking and organization.</p>
                    </div>
                </div>
                <div class="gate-link text-lg-start text-md-start text-sm-center text-center">
                    <a class="btn-hover1" href="about.html">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======== End of 1.6. gateway section ========  -->
<!-- ======== 1.7. services section
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
                <div class="serives-btn justify-content-md-start justify-content-ms-center justify-content-center d-flex">
                    <a class="btn-hover1" href="#">Learn More</a>
                    <div class="d-flex align-items-center">
                        <a class="ps-4" href="#">Register Now </a>
                        <i class="fa-solid fa-greater-than ps-md-3 ps-sm-1 ps-0"></i>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center sevices_img" data-aos="fade-up"> 
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
                    <figure><img src="{{url('public/billpeapp/assets/images/index/lady-mobile.png')}}" alt="sevice_img2"></figure>
                    <figure><img src="{{url('public/billpeapp/assets/images/icon/whitStar.png')}}" alt="sevice_img3"></figure>
                </div>
            </div>
        </div>
    </div>
</section>
 1.7. services section ========  -->

<!-- ======== End of 1.7. services section ========  -->
<!-- ======== 1.8. visa section 
<section class="visa">
    <div class="container">
        <div class="visa-bg" data-aos="zoom-in">
            <figure><img src="{{url('public/billpeapp/assets/images/index/vesa-back.png')}}" alt="visa-img"></figure>
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
                    <div class="d-flex pt-2 justify-content-md-start justify-content-center justify-content-center">
                        <h2 class="count">280</h2>
                        <h2>+</h2>
                        <h6 class="d-flex align-items-center ps-2 ">Integrations</h6>
                    </div>
                    <p class="pt-2 pb-3 text-md-start text-sm-center text-center p-f-s">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Illum
                        laboriosam
                        officiis autem ut sit mollitia blanditiis.</p>
                    <div class="visa-card position-relative mt-3">
                        <img src="{{url('public/billpeapp/assets/images/index/Card.png')}}" alt="visa-card">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======== End of 1.8. visa section ========  -->
<!-- ========  1.9. pricing section ========  -->
<section class="pricing pricing-b-g">
    <div class="container">
        <div class="row ">
            <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center pricing-bg" data-aos="fade-up">
                <div>
                    <figure><img src="{{url('public/billpeapp/assets/images/index/pricinge.png')}}" alt="pric-img1" class="moving"></figure>
                    <figure><img src="{{url('public/billpeapp/assets/images/icon/hero_star.png')}}" alt="pric-img2"></figure>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mt-md-0 mt-sm-5 mt-5" data-aos="fade-down">
                <h2 class=" text-md-start text-sm-center text-center">ECONOMICAL PRICING OPTIONS</h2>
                <p class="text-md-start text-sm-center text-center p-md-0 p-sm-2 p-2">BillPe Billing software with 2'inch Thermal Printer & 1 -Year Subscription</p>
                <form method="post" id="packageForm">
                @csrf
                    <input type="hidden" id="packageid" name="packageSelectID">
                    @foreach($subscriptions as $subscription)
                    <?php $price =  round((int)$subscription->subscription_price + (int)$subscription->subscription_price*18/100) 
                    
                    ?>
                    <a href="javascript:void(0)" class="clickPrice" data-image="{{$subscription->image}}" data-id="{{$subscription->id}}">
                        <div class="pric-list">
                            <h6>{{$subscription->name}}</h6>
                            <div class="d-flex">
                                <div class="d-flex justify-content-between gap-md-5 gap-sm-3 gap-3">
                                    <div class="d-flex pric-sup align-items-center">
                                        <h2>₹ {{$subscription->discount_price}} </h2>
                                        <p>/ @if ($subscription->validity_days % 30 == 0) 
                                                Monthly
                                            @elseif ($subscription->validity_days % 365 == 0) 
                                                Yearly 
                                            @else 
                                                Custom
                                            @endif</p>
                                    </div>
                                    <p class="p-f-s">{{$subscription->discription}}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </form>
                <div class="text-md-start text-sm-center text-center pt-lg-4 pt-md-2 pt-sm-0 pt-1">
                    <a class="btn-hover1" href="https://billpeapp.com/store/login">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======== End of 1.9. pricing section ========  -->
<!-- ======== 1.10. profaessional section ========  -->
<section class="profaessional">
    <div class="container">
        <h2 class="text-center">Trusted By Shopowners</h2>
        <P class="text-center pt-3 pb-5 mb-2">See What Our Existing Customer Says About Us </P>
        <div class="prof-size"  data-aos="zoom-in-up">
            <div class="prof-slider ">
                <div class="prof-slide position-relative">
                    <div>
                        <div class="d-flex  align-items-center justify-content-center">
                            <img src="{{url('public/billpeapp/assets/images/slider/pf2.jpg')}}" alt="img" class="prof-img-2">
                        </div>
                        <div>
                             <img src="{{url('public/billpeapp/assets/images/slider/Comma.png')}}" alt="img" class="prof-img-1">
                        </div>
                        <p class="text-center p-f-s">बिलपे ने हमारे छोटे किराना स्टोर को बहुत आसानी से संचालित करने में मदद की। बिलिंग और रिपोर्टिंग को बहुत ही सुरक्षित और आसान बना दिया है।!</p>
                        <div class="prof-star pt-2 pb-2 text-center">
                            <span class="stars text-lg-start">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </span>
                        </div>
                        <h5 class="text-center">राजेश</h5>
                        <p class="text-center pt-2 pb-5 p-f-s">दिल्ली</p>
                    </div>
                </div>
                <div class="prof-slide position-relative">
                    <div>
                        <div class="d-flex  align-items-center justify-content-center">
                            <img src="{{url('public/billpeapp/assets/images/slider/pf3.jpg')}}" alt="img" class="prof-img-2">
                        </div>
                        <div>
                            <img src="{{url('public/billpeapp/assets/images/slider/Comma.png')}}" alt="img" class="prof-img-1">
                        </div>
                        <p class="text-center p-f-s">बिलपे एप्लिकेशन माझ्या मोबाइल पोस सिस्टमसाठी एकदम उपयुक्त आहे! बिलिंग, विपणी आणि अहवाल सुविधांचं उपयोग सर्वच सोपं बनवलं आहे!</p>
                        <div class="prof-star pt-2 pb-2 text-center">
                            <span class="stars text-lg-start">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </span>
                        </div>
                        <h5 class="text-center">किरण</h5>
                        <p class="text-center pt-2 pb-5 p-f-s">नासिक</p>
                    </div>
                </div>
                <div class="prof-slide position-relative">
                    <div>
                        <div class="d-flex  align-items-center justify-content-center">
                            <img src="{{url('public/billpeapp/assets/images/slider/profacitional.jpg')}}" alt="img" class="prof-img-2">
                        </div>
                        <div>
                            <img src="{{url('public/billpeapp/assets/images/slider/Comma.png')}}" alt="img" class="prof-img-1">
                        </div>
                        <p class="text-center p-f-s">BillPe is a game-changer for general store owners. It simplifies invoicing, inventory management, and sales analysis, making daily operations effortless and efficient.</p>
                        <div class="prof-star pt-2 pb-2 text-center">
                            <span class="stars text-lg-start">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </span>
                        </div>
                        <h5 class="text-center">Ankit Sharma</h5>
                        <p class="text-center pt-2 pb-5 p-f-s">Lucknow</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======== End of 1.10. profaessional section ========  -->
<!-- ======== 8.1. question section ========  -->
    <div class="container">
        <div class="ques-top-text" >
            <h2>QUESTIONS</h2>
            <p>Simplyfying Billing</p>
        </div>
        <div class="question-page">
            <h4>HOW TO USE?</h4>
            <p  class="page-p">Billing is so simple Just in 2 Clicks.</p>
            <div class="question-collapes" data-aos="zoom-in">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h5 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                How do I create a new bill?
                            </button>
                        </h5>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p> To create a new bill, simply open the BillPe app and navigate to the "New Bill" section. Enter the required details such as customer information, items purchased, and the amount. Finally, click on the "Save" button to create the bill.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h5 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                How do I send bills to customers?
                            </button>
                        </h5>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p> You can send bills to customers via WhatsApp from the BillPe app. After creating a bill, select the "Send" option and directly sendto customer WhatsApp.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h5 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false"
                                aria-controls="collapseThree">
                                Is it possible to track bill payments?
                            </button>
                        </h5>
                        <div id="collapseThree" class="accordion-collapse collapse"
                            aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p> Yes, you can track bill payments in the BillPe App. The app provides a report dashboard where you can view the status of each bill, including paid and pending bills.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h5 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false"
                                aria-controls="collapseFour">
                                How can I contact with support?
                            </button>
                        </h5>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>We have one click Support in APP. Click on Support in Profile and Chat with Support Team anytime.</p>
                            </div>
                        </div>
                    </div>                                                                              
                </div>
            </div>
        </div>

        <div class="accordian-2nd">
        <h4 class="mt-lg-5 mt-md-3 mt-sm-1 mt-1">FREE CHARGES AND FEATURES</h4>
        <p  class="page-p">100% Transparency 200% TRUST</p>
        <div class="accordion1"  data-aos="zoom-in">
            <div class="accordion-item1">
                <div class="accordion-header1">
                <h6>  Is there a free trial available for the App/Desktop version?</h6>
                <div class="accordion-toggle1 accordion-toggle-img active"></div>
                </div>
                <div class="accordion-content">
                <p>Yes, BillPe offers a free trial for the APP/desktop version. You can try out the premium features for a limited period before deciding to subscribe. </p>
                </div>
            </div>
            
            <div class="accordion-item1">
                <div class="accordion-header1">
                    <h6> What are the different subscription plans offered by BillPe?</h6>
                <div class="accordion-toggle1 accordion-toggle-img"></div>
                </div>
                <div class="accordion-content">
                <p>BillPe offers two subscription plans. The basic plan starts from ₹499 per year and includes features such as billing and stock management. The desktop version is priced at ₹1999 per year and includes premium features like lending management, marketing tools, and free premium access.</p>
                </div>
            </div>
            
            <div class="accordion-item1">
                <div class="accordion-header1">
                <h6>  Are there any discounts available for long-term subscriptions?</h6>
                <div class="accordion-toggle1 accordion-toggle-img"></div>
                </div>
                <div class="accordion-content">
                <p>Yes, BillPe offers discounts for long-term subscriptions. The longer the subscription period, the greater the discount you can avail.</p>
                </div>
            </div>

            <div class="accordion-item1">
                <div class="accordion-header1">
                <h6>  Can I cancel my subscription at any time?</h6>
                <div class="accordion-toggle1 accordion-toggle-img"></div>
                </div>
                <div class="accordion-content">
                <p>Yes, you can cancel your subscription at any time. However, please note that subscription fees are non-refundable.</p>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- ======== End of 8.1. question section ========-->
<!-- ======== 1.12. news-cards section 
<section class="news-cards">
    <div class="container">
        <h2 class="text-center">OUR LATEST NEWS & EVENTS</h2>
        <P class="text-center news-p">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae eum
            vitae voluptatibus ad laudantium culpa consequatur aperiam nulla.</P>
        <div class="row d-flex gap-md-0 gap-sm-5 gap-4">
            <div class="col-lg-4 col-md-4 d-flex" data-aos="flip-right">
                <div class="card news-card-back">
                    <img src="{{url('public/billpeapp/assets/images/index/news-1.png')}}" alt="card-img">
                    <div class="card-body">
                        <a href="#">
                            <h5>Choosing a Payment Gateway: Key Factors to Consider</h5>
                        </a>
                        <p class="card-text p-f-s">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Voluptates magni veniam officia?.</p>
                    </div>
                    <hr class="dotted-line">
                    <div class="card-viewer d-flex justify-content-between ">
                        <div>
                            <i class="fa-solid fa-calendar-days"></i>
                            <span>2023/06/12</span>
                        </div>
                        <div>
                            <i class="fa-regular fa-message"></i>
                            <span>0</span>
                        </div>
                    </div>
                    <div class="news-link">
                        <a class="btn-hover1" href="#">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 d-flex"  data-aos="flip-right">
                <div class="card news-card-back">
                    <img src="{{url('public/billpeapp/assets/images/index/news-2.png')}}" alt="image">
                    <div class="card-body">
                        <a href="#">
                            <h5>Top Strategies to do Successful Online Business</h5>
                        </a>
                        <p class="card-text p-f-s">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Molestias aperiam doloribus totam.</p>
                    </div>
                    <hr class="dotted-line">
                    <div class="card-viewer d-flex justify-content-between ">
                        <div>
                            <i class="fa-solid fa-calendar-days"></i>
                            <span>2023/06/12</span>
                        </div>
                        <div>
                            <i class="fa-regular fa-message"></i>
                            <span>0</span>
                        </div>
                    </div>
                    <div class="card-color">
                        <a class="btn-hover1" href="#">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 d-flex" data-aos="flip-right">
                <div class="card news-card-back">
                    <img src="{{url('public/billpeapp/assets/images/index/news-3.png')}}" alt="image">
                    <div class="card-body">
                        <a href="#">
                            <h5>The Benefits of Microfinancing for Small Business</h5>
                        </a>
                        <p class="card-text p-f-s">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Tenetur, error impedit.</p>
                    </div>
                    <hr class="dotted-line">
                    <div class="card-viewer d-flex justify-content-between ">
                        <div>

                            <i class="fa-solid fa-calendar-days"></i>
                            <span>2023/06/12</span>
                        </div>
                        <div>
                            <i class="fa-regular fa-message"></i>
                            <span>0</span>
                        </div>
                    </div>
                    <div>
                        <a class="btn-hover1" href="#">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
 ======== End of 1.12. news-cards section ========  -->


    <script>
        $('.clickPrice').click(function(){
            var id  = $(this).attr('data-id');
            $('#packageid').val(id);
            $('form#packageForm').submit();

            // var image  = $(this).attr('data-image');
            // $('.priceImagechange').attr('src', image);
        })
    </script>
@endsection