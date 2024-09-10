

<?php $__env->startSection('content'); ?>

<!-- ======== 5.1. map help section ========  -->
<div class="first_nav_hero_about">
    <!-- ======== 1.1. header section ======== -->
        <?php echo $__env->make('billpeapp/layout/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- ======== End of 1.1. header section ========  -->
    <!-- ======== 5.1. contact-hero section ========  -->
    <div class="container pb-5">
        <div class="contact-hero">
            <h2 class="text-center">CONTACT US</h2>
        </div>
    </div>
    <!-- ======== End of 5.1. contact-hero section ========  -->
</div>


    <!-- ======== End of 5.1. contact-hero section ========  -->
    </div>
    <section class="d-flex justify-content-center">
    <div class="help position-relative">
    <div class="container">
        <div class="row d-flex gap-lg-5 gap-md-3 gap-sm-4 gap-3 justify-content-center">
            <div class="col-lg-5 col-md-5 help-crd1" data-aos="fade-down"
            data-aos-easing="linear"
            data-aos-duration="1500">
                <h4>HOW CAN WE HELP?</h4>
                <P>Reach us out with all your queries! </P>
                <div class="d-flex gap-4 align-items-center">
                    <i class="fa-solid fa-house"></i>
                    <span>D-9 Ground Floor Sector 3, Noida 201301</span>
                </div>
                <div class="d-flex gap-4 align-items-center">
                    <i class="fa-solid fa-phone"></i>
                    <span>+91-7290009110</span>
                </div>
                <div class="d-flex gap-4 align-items-center">
                    <i class="fa-solid fa-envelope"></i>
                    <span>billpeapp@gmail.com</span>
                </div>
                <h5>OPERATING HOURS</h5>
                <div class="d-flex gap-4 align-items-center">
                    <i class="fa-solid fa-clock"></i>
                    <span>Monday To Saturday <br> 9:00am to 6:00pm IST</span>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 contact-email" data-aos="fade-down"
            data-aos-easing="linear"
            data-aos-duration="1500">
                <h4>EMAIL US</h4>
                <form action="action_page.php"  id="footer-sub">  
                    <div class="row justify-content-center gap-3">
                        <input type="text" name="name" id="name" class="col-md-5 col-sm-12 col-12" placeholder="Your Name" required>
                        <input type="text" name="email" id="email" class="col-md-5 col-sm-12 col-12" placeholder="Email Address" required>
                        <input type="text" name="number" id="number" class="col-md-5 col-sm-12 col-12" placeholder="Phone Number" required>
                        <input type="text" name="subject" id="subject" class="col-md-5 col-sm-12 col-12" placeholder="Subject" required>
                        <textarea class="col-md-11 col-12" name="massage" id="massage" cols="30" rows="10" placeholder="Write here message"></textarea>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <button class=" e-btn btn-hover1" type="submit">Submit</button>
                    </div>
                </form>
            </div>
            <div id="Succes-box"></div> 
        </div>
    </div>
    </div>
    </section>
    <!-- ======== End of 5.1. map help section ========  -->
    
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('billpeapp.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/billp5kj/public_html/resources/views/billpeapp/contact.blade.php ENDPATH**/ ?>