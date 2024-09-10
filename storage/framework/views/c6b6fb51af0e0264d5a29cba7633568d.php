<header>
    <meta name="facebook-domain-verification" content="n53f9j48ils1vr44zbunufif5h6mw4" />
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
     fbq('init', '390306733340605'); 
    fbq('track', 'PageView');
        fbq('track', 'Contact');
        fbq('track', 'StartTrial', {value: '0.00', currency: 'INR', predicted_ltv: '0.00'});
        fbq('track', 'AddPaymentInfo');
        fbq('track', 'InitiateCheckout');
        fbq('track', 'Purchase', {value: 0.00, currency: 'INR'});

    </script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=390306733340605&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->   
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-23M1ND71NC"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-23M1ND71NC');
</script>
<script>
// Define dataLayer and the gtag function.
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  // Set default consent to 'denied' as a placeholder
  // Determine actual values based on your own requirements
  gtag('consent', 'default', {
    'ad_storage': 'denied',
    'ad_user_data': 'denied',
    'ad_personalization': 'denied',
    'analytics_storage': 'denied'
  });
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-XXXXXX');</script>
<!-- End Google Tag Manager -->

<!-- Create one update function for each consent parameter -->
<script>
  function consentGrantedAdStorage() {
    gtag('consent', 'update', {
      'ad_storage': 'granted'
    });
  }
</script>
<!-- Invoke your consent functions when a user interacts with your banner -->
<body>
  ...
  <button onclick="consentGrantedAdStorage()">Yes</button>
  ...
</body>

    <nav class="container navbar navbar-expand-lg ">
        <div class="container-fluid">
            <!-- site logo -->
            <a class="nav-logo p-0" href="<?php echo e(route('index')); ?>"><img src="<?php echo e(url('public/billpeapp/assets/images/Logo.png')); ?>" alt="logo"></a>
                    <!-- navigation button  -->
            <button class="navbar-toggle" onclick="openNav()" type="button"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
            <!-- navigation bar manu  -->
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul
                    class="navbar-nav d-flex justify-content-center align-items-center gap-lg-2 gap-md-2 gap-sm-2 gap-2 mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Request::path() == 'index'? 'active' : ''); ?>" href="<?php echo e(route('index')); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Request::path() == 'about'? 'active' : ''); ?>" href="<?php echo e(route('about')); ?>">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(Request::path() == 'blogs'? 'active' : ''); ?>" href="<?php echo e(route('blogs')); ?>">Blogs</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a id="search-bar-bt" class="nav-link" href="#"><i
                                class="fa-solid fa-magnifying-glass"></i></a>
                    </li> -->
                    <li class="nav-item header_btn ">
                        <a class="nav-link nav-hrf btn-hover1" href="<?php echo e(route('store.login')); ?>" target="_blank">Free Trial</a>
                    </li>
                    <li class="nav-item" onclick="open_right_side()">
                        <a class="nav-link" href="#"><i class="fa-sharp fa-solid fa-bars"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--============ navigation left slidebar================-->
    <aside>
        <div id="mySidenav" class="sidenav">
            <div class="side-nav-logo d-flex justify-content-between align-items-center ps-4 pe-3">
                <figure class="navbar-brand"><a href="<?php echo e(route('index')); ?>"><img src="<?php echo e(url('public/billpeapp/assets/images/Logo.png')); ?>" alt="img"
                    class="nav-logo"></a></figure>
                <div class="closebtn" onclick="closeNav()"><i
                        class="fa-solid fa-square-xmark side-bar-close-btn"></i></div>
            </div>
            <ul>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request::path() == 'index'? 'active' : ''); ?>" href="<?php echo e(route('index')); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request::path() == 'about'? 'active' : ''); ?>" href="<?php echo e(route('about')); ?>">About us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request::path() == 'blogs'? 'active' : ''); ?>" href="<?php echo e(route('blogs')); ?>">Blogs</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link <?php echo e(Request::path() == 'feature'? 'active' : ''); ?>" href="<?php echo e(route('feature')); ?>">Feature</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(Request::path() == 'pricing'? 'active' : ''); ?>" href="<?php echo e(route('pricing')); ?>">Pricing</a>
                </li> -->
                <!-- <li class="nav-item">
                    <div class="d-flex align-items-center justify-content-between pt-3" id="slid-btn">
                        <button class="a-slid">More</button>
                        <i class="fa-solid fa-caret-down pe-4"></i>
                    </div>
                    <ul id="slid-drop" class="myst">
                        <li><a class="dropdown-item <?php echo e(Request::path() == 'contact'? 'active' : ''); ?>" href="<?php echo e(route('contact')); ?>">Contact</a></li>
                        <li><a class="dropdown-item <?php echo e(Request::path() == 'blogs'? 'active' : ''); ?>" href="<?php echo e(route('blogs')); ?>">Blogs</a></li>
                        <li><a class="dropdown-item <?php echo e(Request::path() == 'faq'? 'active' : ''); ?>" href="<?php echo e(route('faq')); ?>">FAQ</a></li>

                        
                    </ul>
                </li> -->
            </ul>
        </div>
    </aside>
    <!--================== navigation drop search bar================-->
    <div class="search" id="search-bar">
        <form class="d-flex nav-search">
            <input type="text" name="search" placeholder="Enter your text">
            <button class="btn-hover1" type="submit">Search</button>
        </form>
        <button id="remove-btn">
            <i class="fa-solid fa-square-xmark "></i>
        </button>
    </div>
    <!--=================navigation Right slidebar==================-->
    <section class="right-sidbar" id="right_side">
        <div class="d-flex justify-content-between align-items-center">
            <!-- site logo -->
            <a class="p-0 " href="<?php echo e(route('index')); ?>"><img src="<?php echo e(url('public/billpeapp/assets/images/Logo.png')); ?>" alt="logo"></a>
            <button class="close_right_sidebar fa-solid fa-xmark" onclick="close_right_sade()"> </button>
        </div>
        <p class="mt-4 pb-3">BillPe simplifies your invoicing with easy-to-use tools for creating, managing, and sending professional invoices. Our platform ensures secure transactions and efficient billing, empowering your business to thrive and focus on what matters most.
        </p>
        <a href="https://billpeapp.com/store/login" class="btn-hover1">Get Started</a>
        <hr>
        <h5 class="mt-4 mb-4">Contact details:</h5>
        <ul class="d-flex flex-column gap-3">
            <li>
                <a href="#"> <i class="fa-solid fa-phone"></i></a>
                <a href="#">billpeapp@gmail.com</a>
            </li>
            <li>
                <a href="#"><i class="fa-solid fa-envelope"></i></a>
                <a href="#">+91-7290009110</a>
            </li>
            <li>
                <a href="#"><i class="fa-solid fa-clock"></i></a>
                <a href="#">Office Hours: 9AM - 6PM Sunday -
                    Weekend Day</a>
            </li>
        </ul>
        <span class="d-flex gap-4 mt-4">
            <a href="https://www.facebook.com/billpeappofficial" class="p-0"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://www.instagram.com/billpeappofficial" class="p-0"><i class="fa-brands fa-instagram"></i></a>
        </span>
    </section>
</header><?php /**PATH /home4/billp5kj/public_html/resources/views/billpeapp/layout/header.blade.php ENDPATH**/ ?>