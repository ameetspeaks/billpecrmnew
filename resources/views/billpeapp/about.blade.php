@extends('billpeapp.layout.app')

@section('content')

<div class="first_nav_hero_about">
    <!-- ======== 1.1. header section ======== -->
    @include('billpeapp/layout/header')
    <!-- ======== End of 1.1. header section ========  -->
    <!-- ======== 2.1. hero section ========  -->
    <section>
        <div class="about-hero container">
            <h1 class="text-center">About Us</h1>
            <p class="text-center about-p">Join Smart Bharat Smart Billing Club.</p>
            <div class="services  pb-lg-4 pb-md-2 pb-sm-0 pb-0 mb-lg-2 mb-md-1 mb-sm-0 mb-0">
                <div class="container">
                    <div class="row gap-md-0 gap-sm-4 gap-4">
                        <div class="col-lg-6 col-md-6" data-aos="fade-up">
                            <h2 class="text-lg-start text-md-start text-sm-center text-center">Smart & Hassle FREE Billing with BillPe </h2>
                            <p
                                class="text-lg-start text-md-start text-sm-center text-center mt-lg-4 mt-md-2 mt-sm-2 mt-2 pb-4 ">
                                BillPe simplifies your invoicing with easy-to-use tools for creating, managing, and sending professional invoices. 
                                .</p>
                            <p class="text-lg-start text-md-start text-sm-center text-center pb-4 ">
                                Our platform ensures secure transactions and efficient billing, empowering your business to thrive and focus on what matters most.
                                .</p>

                            <div
                                class="serives-btn justify-content-md-start justify-content-ms-center justify-content-center d-flex pt-lg-4 pt-md-2 pt-sm-2 pt-2">
                                <a class="btn-hover1" href="https://billpeapp.com/store/login">Get started for FREE</a>

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center abt" data-aos="fade-down">
                            <div class="position-relative">
                                <figure class="abut-hero-img1"><img src="{{url('public/billpeapp/assets/images/index/hero.png')}}" alt="img"></figure>
                                <figure class="abut-hero-img2"><img src="{{url('public/billpeapp/assets/images/icon/whitStar.png')}}" alt="img"></figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======== 2.1. hero section ========  -->
</div>

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
                <div class="pric-list">
                    <h6>mPOS</h6>
                    <div class="d-flex">
                        <div class="mt-3 me-3"><i class="fa-solid fa-check"></i></div>

                        <div class="d-flex justify-content-between gap-1">
                            <p class="p-f-s">BillPe Billing software with 2'inch Thermal Printer & 1 -Year Subscription</p>
                            <div class="d-flex pric-sup">
                                <h2>₹</h2>
                                <h2 >4999</h2>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pric-list second">
                    <h6>APP Only</h6>
                    <div class="d-flex justify-content-between">
                        <div class="mt-3 me-3"><i class="fa-solid fa-check"></i></div>
                        <div class="d-flex justify-content-between">
                            <p class="p-f-s">BillPe Billing software with 1 -Year Subscription</p>
                            <div class="d-flex pric-sup ">
                                <h2>₹</h2>
                                <h2>1999</h2>
                                <p>/year</p>
                            </div>
                        </div>
                    </div>
                </div>
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

@endsection