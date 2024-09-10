<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

       
        
        <li class="nav-item">
            <div class="d-flex sidebar-profile " style="padding: 1.75rem 1.125rem 0rem 1.125rem; !important">
                <div class="sidebar-profile-image" > 
                    <img src="<?php echo e(auth()->user()->image ? auth()->user()->image : asset('public/admin/images/user-image.png')); ?>" alt="image">
                    <span class="sidebar-status-indicator"></span>
                </div>
                <div class="sidebar-profile-name">
                    <p class="sidebar-name">
                       <?php echo e(auth()->user()->name); ?>

                    </p>
                    <p class="sidebar-designation">
                        Welcome
                    </p>
                </div>
            </div>
            
        </li>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['View Dashboard', 'View Module'])): ?>
            <p class="sidebar-menu-title capitalize">Dash menu</p>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Dashboard')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.dashboard')); ?>">
                    <i class="fa fa-dashboard menu-icon"></i>
                    <span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Zone')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.zone.index')); ?>">
                    <i class="fa fa-globe menu-icon"></i>
                    <span class="menu-title">Zone</span>
                </a>
            </li>
            <?php endif; ?>

            <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Sub Zone')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.subzone.index')); ?>">
                    <i class="fa fa-globe menu-icon"></i>
                    <span class="menu-title">Sub Zone</span>
                </a>
            </li>
            <?php endif; ?> -->

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Module')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.module.index')); ?>">
                    <i class="fa fa-globe menu-icon"></i>
                    <span class="menu-title">Module</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['View Permission','View All Roles','View All User'])): ?>
            <p class="sidebar-menu-title capitalize">Roles and Permission</p>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Permission')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.permission.index')); ?>">
                    <i class="fa fa-store menu-icon"></i>
                    <span class="menu-title">Permissions</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View All Roles')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.role.index')); ?>">
                    <i class="fa fa-shopping-cart menu-icon"></i>
                    <span class="menu-title">Role</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View All User')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.user.index')); ?>">
                    <i class="fa fa-user menu-icon"></i>
                    <span class="menu-title">Users</span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['View All Store','Manual Payment'])): ?>
            <p class="sidebar-menu-title capitalize">Stores management</p>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View All Store')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.store.index')); ?>">
                    <i class="fa fa-store menu-icon"></i>
                    <span class="menu-title">Store</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Manual Payment')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.store.manualPayment')); ?>">
                    <i class="fa fa-store menu-icon"></i>
                    <span class="menu-title">Manual Payment</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Bill History')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.store.billHistory')); ?>">
                    <i class="fa fa-store menu-icon"></i>
                    <span class="menu-title">Bill History</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['View Package','View Addon','View Coupan'])): ?>
            <p class="sidebar-menu-title capitalize">Package and Coupan</p>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Package')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.subscription.index')); ?>">
                    <i class="fa fa-trophy menu-icon"></i>
                    <span class="menu-title">Subscription Package</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Addon')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.addon.index')); ?>">
                    <i class="fa fa-puzzle-piece menu-icon"></i>
                    <span class="menu-title">Addon Item</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Addon')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.coupan.index')); ?>">
                    <i class="fa fa-building menu-icon"></i>
                    <span class="menu-title">Coupan</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['View All Product'])): ?>
            <p class="sidebar-menu-title capitalize">Product management</p>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View All Product')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.product.index')); ?>">
                    <i class="fa fa-project-diagram menu-icon"></i>
                    <span class="menu-title">Product</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Template')): ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#analytics" aria-expanded="false">
                    <i class="fa fa-bar-chart menu-icon"></i>
                    <span class="menu-title">Templates</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="analytics">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('admin.template.category')); ?>">Category</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('admin.template.type')); ?>">Type</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('admin.template.marketing')); ?>">Marketing</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('admin.template.offer')); ?>">Offers</a></li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Blog')): ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#blog" aria-expanded="false">
                    <i class="fa fa-bar-chart menu-icon"></i>
                    <span class="menu-title">Blog</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="blog">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('admin.blog.category')); ?>">Category</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('admin.blog.index')); ?>">Blog</a></li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['View Banner','Homepage Video'])): ?>
            <p class="sidebar-menu-title capitalize">Home Page</p>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Banner')): ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#banner" aria-expanded="false">
                    <i class="fa fa-bar-chart menu-icon"></i>
                    <span class="menu-title">Banner</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="banner">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="<?php echo e(route('admin.promotionalBanner.index')); ?>">Promotional Banner</a></li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Homepage Video')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.homepagevideo.index')); ?>">
                    <i class="fa fa-project-diagram menu-icon"></i>
                    <span class="menu-title">Homepage Video</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Tutorial')): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.tutorial.index')); ?>">
                    <i class="fa fa-project-diagram menu-icon"></i>
                    <span class="menu-title">Tutorial</span>
                </a>
            </li>
            <?php endif; ?>
     </nav>
<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>