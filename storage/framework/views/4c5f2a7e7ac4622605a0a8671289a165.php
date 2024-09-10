

<?php $__env->startSection('content'); ?>

<div class="first_nav_hero_about">
    <!-- ======== 1.1. header section ======== -->
    <?php echo $__env->make('billpeapp/layout/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- ======== End of 1.1. header section ========  -->
            <!-- ======== 9.1. Blogs cards section ========  -->
    <section class="news-cards">
    <div class="container">
        <h2 class="text-center news-h2">OUR LATEST NEWS & EVENTS</h2>
        
        <div class="row d-flex gap-md-0 gap-sm-5 gap-4 mb-5">
            <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-4 d-flex" data-aos="flip-right">
                <div class="card news-card-back">
                    <img src="<?php echo e($blog->blog_image); ?>" alt="card-img">
                    <div class="card-body">
                        <a href="#">
                            <h5><?php echo e($blog->title); ?> - <?php echo e($blog->meta_title); ?></h5>
                        </a>
                        <p class="card-text p-f-s"><?php echo e($blog->meta_description); ?></p>
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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    </section>
    <!-- ======== End of 9.1. Blogs cards section ========  -->
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('billpeapp.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/billp5kj/public_html/resources/views/billpeapp/blogs.blade.php ENDPATH**/ ?>