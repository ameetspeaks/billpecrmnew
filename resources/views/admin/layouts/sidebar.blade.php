<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

       
        
        <li class="nav-item">
            <div class="d-flex sidebar-profile " style="padding: 1.75rem 1.125rem 0rem 1.125rem; !important">
                <div class="sidebar-profile-image" > 
                    <img src="{{ auth()->user()->image ? auth()->user()->image : asset('public/admin/images/user-image.png') }}" alt="image">
                    <span class="sidebar-status-indicator"></span>
                </div>
                <div class="sidebar-profile-name">
                    <p class="sidebar-name">
                       {{ auth()->user()->name}}
                    </p>
                    <p class="sidebar-designation">
                        Welcome
                    </p>
                </div>
            </div>
            {{-- <div class="nav-search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Type to search..." aria-label="search" aria-describedby="search">
                    <div class="input-group-append">
                        <span class="input-group-text" id="search">
                            <i class="typcn typcn-zoom"></i>
                        </span>
                    </div>
                </div>
            </div> --}}
        </li>
            
            @canany(['View Dashboard', 'View Module'])
            <p class="sidebar-menu-title capitalize">Dash menu</p>
            @endcanany

            @can('View Dashboard')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard menu-icon"></i>
                    <span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>
                </a>
            </li>
            @endcan

            @can('View Zone')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.zone.index') }}">
                    <i class="fa fa-globe menu-icon"></i>
                    <span class="menu-title">Zone</span>
                </a>
            </li>
            @endcan

            <!-- @can('View Sub Zone')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.subzone.index') }}">
                    <i class="fa fa-globe menu-icon"></i>
                    <span class="menu-title">Sub Zone</span>
                </a>
            </li>
            @endcan -->

            @can('View Module')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.module.index') }}">
                    <i class="fa fa-globe menu-icon"></i>
                    <span class="menu-title">Module</span>
                </a>
            </li>
            @endcan

            @canany(['View Permission','View All Roles','View All User'])
            <p class="sidebar-menu-title capitalize">Roles and Permission</p>
            @endcanany

            @can('View Permission')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.permission.index') }}">
                    <i class="fa fa-store menu-icon"></i>
                    <span class="menu-title">Permissions</span>
                </a>
            </li>
            @endcan

            @can('View All Roles')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.role.index') }}">
                    <i class="fa fa-shopping-cart menu-icon"></i>
                    <span class="menu-title">Role</span>
                </a>
            </li>
            @endcan

            @can('View All User')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.user.index') }}">
                    <i class="fa fa-user menu-icon"></i>
                    <span class="menu-title">Users</span>
                </a>
            </li>
            @endcan
            
            @canany(['View All Store','Manual Payment'])
            <p class="sidebar-menu-title capitalize">Stores management</p>
            @endcanany

            @can('View All Store')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.store.index') }}">
                    <i class="fa fa-store menu-icon"></i>
                    <span class="menu-title">Store</span>
                </a>
            </li>
            @endcan

            @can('Manual Payment')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.store.manualPayment') }}">
                    <i class="fa fa-store menu-icon"></i>
                    <span class="menu-title">Manual Payment</span>
                </a>
            </li>
            @endcan

            @can('View Bill History')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.store.billHistory') }}">
                    <i class="fa fa-store menu-icon"></i>
                    <span class="menu-title">Bill History</span>
                </a>
            </li>
            @endcan

            @canany(['View Package','View Addon','View Coupan'])
            <p class="sidebar-menu-title capitalize">Package and Coupan</p>
            @endcanany

            @can('View Package')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.subscription.index') }}">
                    <i class="fa fa-trophy menu-icon"></i>
                    <span class="menu-title">Subscription Package</span>
                </a>
            </li>
            @endcan

            @can('View Addon')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.addon.index') }}">
                    <i class="fa fa-puzzle-piece menu-icon"></i>
                    <span class="menu-title">Addon Item</span>
                </a>
            </li>
            @endcan

            @can('View Addon')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.coupan.index') }}">
                    <i class="fa fa-building menu-icon"></i>
                    <span class="menu-title">Coupan</span>
                </a>
            </li>
            @endcan

            @canany(['View All Product'])
            <p class="sidebar-menu-title capitalize">Product management</p>
            @endcanany

            @can('View All Product')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.product.index') }}">
                    <i class="fa fa-project-diagram menu-icon"></i>
                    <span class="menu-title">Product</span>
                </a>
            </li>
            @endcan

            @can('View Template')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#analytics" aria-expanded="false">
                    <i class="fa fa-bar-chart menu-icon"></i>
                    <span class="menu-title">Templates</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="analytics">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.template.category') }}">Category</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.template.type') }}">Type</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.template.marketing') }}">Marketing</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.template.offer') }}">Offers</a></li>
                    </ul>
                </div>
            </li>
            @endcan

            @can('View Blog')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#blog" aria-expanded="false">
                    <i class="fa fa-bar-chart menu-icon"></i>
                    <span class="menu-title">Blog</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="blog">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.blog.category') }}">Category</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.blog.index') }}">Blog</a></li>
                    </ul>
                </div>
            </li>
            @endcan

            @canany(['View Banner','Homepage Video'])
            <p class="sidebar-menu-title capitalize">Home Page</p>
            @endcanany

            @can('View Banner')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#banner" aria-expanded="false">
                    <i class="fa fa-bar-chart menu-icon"></i>
                    <span class="menu-title">Banner</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="banner">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.promotionalBanner.index') }}">Promotional Banner</a></li>
                    </ul>
                </div>
            </li>
            @endcan

            @can('Homepage Video')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.homepagevideo.index') }}">
                    <i class="fa fa-project-diagram menu-icon"></i>
                    <span class="menu-title">Homepage Video</span>
                </a>
            </li>
            @endcan

            @can('View Tutorial')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.tutorial.index') }}">
                    <i class="fa fa-project-diagram menu-icon"></i>
                    <span class="menu-title">Tutorial</span>
                </a>
            </li>
            @endcan
     </nav>
