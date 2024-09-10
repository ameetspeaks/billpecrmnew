
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="<?php echo e(route('admin.dashboard')); ?>">
            <img src="<?php echo e(asset('public/admin/upload/'.\App\Models\Setting::where('type','company_logo')->first()->value)); ?>" alt="logo" class="object-contain" style="height:100px;"/>

        </a>
        <a class="navbar-brand brand-logo-mini" href="<?php echo e(route('admin.dashboard')); ?>">
            <img src="<?php echo e(asset('public/admin/upload/'.\App\Models\Setting::where('type','company_logo')->first()->value)); ?>" alt="logo" style="height:100px;"/>
        </a>
        <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button" data-toggle="minimize">
            <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">

        </ul>
        <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item dropdown d-flex">
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
                    <i style="color:rgb(127, 147, 163);font-size: 16px;" class="fa fa-folder-open" aria-hidden="true"></i>&nbsp;
                    <span style="color:rgb(127, 147, 163);font-weight:bold"> Customer</span>

                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Order')): ?>
                    <a class="dropdown-item preview-item" href="<?php echo e(route('admin.order.allOrder')); ?>">All Order</a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Loyalty Point')): ?>
                    <a class="dropdown-item preview-item" href="<?php echo e(route('admin.loyaltypoint.index')); ?>">Loyalty Point</a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Customer Coupan')): ?>
                    <a class="dropdown-item preview-item" href="<?php echo e(route('admin.customerCoupan.index')); ?>">Customer Coupan</a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Charges')): ?>
                    <a class="dropdown-item preview-item" href="<?php echo e(route('admin.charges.index')); ?>">Charges</a>
                    <?php endif; ?>
                </div>
            </li>

            <li class="nav-item dropdown d-flex">
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Activity')): ?>
                <a class="nav-link count-indicator d-flex justify-content-center align-items-center" href="<?php echo e(route('admin.activity')); ?>">
                    <i style="color:rgb(127, 147, 163);font-size: 16px;" class="fa-solid fa-info-circle" aria-hidden="true"></i>&nbsp;
                    <span style="color:rgb(127, 147, 163);font-weight:bold"> Activity</span>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php endif; ?>
                <a class="nav-link count-indicator d-flex justify-content-center align-items-center" href="<?php echo e(route('admin.notification')); ?>">
                    <i style="color:rgb(127, 147, 163);font-size: 16px;" class="fa-solid fa-bell" aria-hidden="true"></i>&nbsp;
                    <span style="color:rgb(127, 147, 163);font-weight:bold"> Notification</span>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
                    <i style="color:rgb(127, 147, 163);font-size: 16px;" class="fa fa-folder-open" aria-hidden="true"></i>&nbsp;
                    <span style="color:rgb(127, 147, 163);font-weight:bold"> Library</span>

                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Library')): ?>
                    <a class="dropdown-item preview-item" href="<?php echo e(route('admin.centralLibrary.index')); ?>">List products</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Category')): ?>
                    <a class="dropdown-item preview-item" href="<?php echo e(route('admin.category.index')); ?>">Category</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Sub Category')): ?>
                    <a class="dropdown-item preview-item" href="<?php echo e(route('admin.subcategory.index')); ?>">Sub Category</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Attribute')): ?>
                    <a class="dropdown-item preview-item" href="<?php echo e(route('admin.attribute.index')); ?>">Attributes</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Unit')): ?>
                    <a class="dropdown-item preview-item" href="<?php echo e(route('admin.unit.index')); ?>">Units</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Sub Unit')): ?>
                    <a class="dropdown-item preview-item" href="<?php echo e(route('admin.subunit.index')); ?>">Sub Units</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Gallery')): ?>
                    <a class="dropdown-item preview-item" href="<?php echo e(route('admin.gallery.index')); ?>">All Gallery</a>
                    <a class="dropdown-item preview-item" href="<?php echo e(route('admin.gallery.add')); ?>">Add Gallery</a>
                    <?php endif; ?>

                </div>
                
            </li>
            
            <li class="nav-item nav-profile dropdown">

                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
                    <i style="color:rgb(127, 147, 163);font-size: 16px;" class="fa fa-user" aria-hidden="true"></i>&nbsp;
                    <span style="color:rgb(127, 147, 163);font-weight:bold"> Profile</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="<?php echo e(route('admin.setting')); ?>">
                        <i class="typcn typcn-cog text-primary"></i>
                        Settings
                    </a>
                    <a href="<?php echo e(route('admin.logout')); ?>" class="dropdown-item">
                        <i class="typcn typcn-power text-primary"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>
            <?php if(session()->has('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session()->get('error')); ?>

                </div>
            <?php endif; ?>
            <?php if(session()->has('message')): ?>
                <div class="alert alert-success">
                    <?php echo e(session()->get('message')); ?>

                </div>
            <?php endif; ?>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
</nav>
<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/layouts/header.blade.php ENDPATH**/ ?>