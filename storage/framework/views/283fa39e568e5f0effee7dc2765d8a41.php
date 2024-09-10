

<?php $__env->startSection('content'); ?>

<div class="site-wrapper">
    <div class="first_nav_hero_about">
        <!-- ======== 1.1. header section ======== -->
        <?php echo $__env->make('billpeapp/layout/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- ======== End of 1.1. header section ========  -->
        <!-- ======== 4.1. hero section ======== -->
        <div class="container">
            <div class="pricing-hero">
                <h2 class="text-center">PRICING</h2>
                <P class="text-center">Choose the Best for your Shop.</P>
            </div>
        </div>
        <!-- ========End of 4.1. hero section ======== -->
        <!-- ========  1.9. pricing section ========  -->
        <section class="pricing pri-padd">
            <div class="container">
                <form method="post" id="packageForm">
                <?php echo csrf_field(); ?>
                <div class="row d-flex gap-md-0 gap-sm-3 gap-2">
                    <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center pricing-bg"
                        data-aos="fade-up">
                        <div>
                            <figure><img src="<?php echo e($subscriptions[0]->image); ?>" alt="pric-img1" class="moving priceImagechange"></figure>
                            <figure><img src="<?php echo e(url('public/billpeapp/assets/images/icon/hero_star.png')); ?>" alt="pric-img2"></figure>
                        </div>
                    </div>
                   
                        <input type="hidden" id="packageid" name="packageSelectID">
                        <div class="col-lg-6 col-md-6 mt-md-0 mt-sm-5 mt-5" data-aos="fade-down">
                            <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="javascript:void(0)" class="clickPrice" data-image="<?php echo e($subscription->image); ?>" data-id="<?php echo e($subscription->id); ?>">
                                <div class="pric-list">
                                    <h6><?php echo e($subscription->name); ?></h6>
                                    <div class="d-flex">
                                        <div class="d-flex justify-content-between gap-md-5 gap-sm-3 gap-3">
                                            <div class="d-flex pric-sup align-items-center">
                                                <h2>₹<?php echo round($subscription->subscription_price + $subscription->subscription_price*18/100) ?></h2>
                                                <p>/<?php echo round($subscription->subscription_price + $subscription->subscription_price*18/100) ?></p>
                                            </div>
                                            <p class="p-f-s"><?php echo e($subscription->discription); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="text-md-start text-sm-center text-center pt-lg-4 pt-md-2 pt-sm-0 pt-1">
                                <a class="btn-hover1" href="#">Get Started</a>
                            </div>
                        </div>
                </div>
                </form>

            </div>
        </section>
        <!-- ======== End of 1.9. pricing section ========  -->

        <script>
            $('.clickPrice').click(function(){
                var id  = $(this).attr('data-id');
                $('#packageid').val(id);
                $('form#packageForm').submit();
    
                // var image  = $(this).attr('data-image');
                // $('.priceImagechange').attr('src', image);
            })
        </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('billpeapp.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/billp5kj/public_html/resources/views/billpeapp/pricing.blade.php ENDPATH**/ ?>