
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('public/admin/upload/'.\App\Models\Setting::where('type','company_logo')->first()->value) }}" alt="logo" class="object-contain" style="height:100px;"/>

        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('public/admin/upload/'.\App\Models\Setting::where('type','company_logo')->first()->value) }}" alt="logo" style="height:100px;"/>
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
                    <span style="color:rgb(127, 147, 163);font-weight:bold"> Online</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                    @can('View Order')
                    <a class="dropdown-item preview-item" href="{{ route('admin.order.allOrder') }}">All Order</a>
                    @endcan

                    @can('View Loyalty Point')
                    <a class="dropdown-item preview-item" href="{{ route('admin.loyaltypoint.index') }}">Loyalty Point</a>
                    @endcan

                    @can('View Customer Coupan')
                    <a class="dropdown-item preview-item" href="{{ route('admin.customerCoupan.index') }}">Customer Coupan</a>
                    @endcan

                    @can('View Charges')
                    <a class="dropdown-item preview-item" href="{{ route('admin.charges.index') }}">Charges</a>
                    @endcan

                    @can('Customer Banner')
                    <a class="dropdown-item preview-item" href="{{ route('admin.customerbanner.index') }}">Customer Banner</a>
                    @endcan

                    @can('View Shift Timings')
                    <a class="dropdown-item preview-item" href="{{ route('admin.shiftTimings.index') }}">Shift Timings</a>
                    @endcan

                    @can('View Delivery Partner')
                    <a class="dropdown-item preview-item" href="{{ route('admin.deliveryPartner.index') }}">Delivery Partner</a>
                    @endcan
                </div>
            </li>

            <li class="nav-item dropdown d-flex">
                {{-- @can('View Chat')
                <a class="nav-link count-indicator d-flex justify-content-center align-items-center" href="{{ route('admin.chat') }}">
                    <i class="fa fa-commenting" aria-hidden="true"></i>&nbsp;
                    <span style="color:rgb(127, 147, 163);font-weight:bold"> Chat</span>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                @endcan --}}
                @can('View Activity')
                <a class="nav-link count-indicator d-flex justify-content-center align-items-center" href="{{ route('admin.activity') }}">
                    <i style="color:rgb(127, 147, 163);font-size: 16px;" class="fa-solid fa-info-circle" aria-hidden="true"></i>&nbsp;
                    <span style="color:rgb(127, 147, 163);font-weight:bold"> Activity</span>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                @endcan
                <a class="nav-link count-indicator d-flex justify-content-center align-items-center" href="{{ route('admin.notification') }}">
                    <i style="color:rgb(127, 147, 163);font-size: 16px;" class="fa-solid fa-bell" aria-hidden="true"></i>&nbsp;
                    <span style="color:rgb(127, 147, 163);font-weight:bold"> Notification</span>
                </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
                    <i style="color:rgb(127, 147, 163);font-size: 16px;" class="fa fa-folder-open" aria-hidden="true"></i>&nbsp;
                    <span style="color:rgb(127, 147, 163);font-weight:bold"> Library</span>

                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                    @can('View Library')
                    <a class="dropdown-item preview-item" href="{{ route('admin.centralLibrary.index') }}">List products</a>
                    @endcan
                    @can('View Category')
                    <a class="dropdown-item preview-item" href="{{ route('admin.category.index') }}">Category</a>
                    @endcan
                    @can('View Sub Category')
                    <a class="dropdown-item preview-item" href="{{ route('admin.subcategory.index') }}">Sub Category</a>
                    @endcan
                    @can('View Attribute')
                    <a class="dropdown-item preview-item" href="{{ route('admin.attribute.index') }}">Attributes</a>
                    @endcan
                    @can('View Unit')
                    <a class="dropdown-item preview-item" href="{{ route('admin.unit.index') }}">Units</a>
                    @endcan
                    @can('View Sub Unit')
                    <a class="dropdown-item preview-item" href="{{ route('admin.subunit.index') }}">Sub Units</a>
                    @endcan
                    @can('View Gallery')
                    <a class="dropdown-item preview-item" href="{{ route('admin.gallery.index') }}">All Gallery</a>
                    <a class="dropdown-item preview-item" href="{{ route('admin.gallery.add') }}">Add Gallery</a>
                    @endcan

                </div>
                {{-- <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
                    <i class="typcn typcn-message-typing"></i>
                    <span class="count bg-success">2</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="{{ asset('public/admin/images/faces/face4.jpg') }}" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                            </h6>
                            <p class="font-weight-light small-text mb-0">
                                The meeting is cancelled
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="{{ asset('public/admin/images/faces/face2.jpg') }}" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                            </h6>
                            <p class="font-weight-light small-text mb-0">
                                New product launch
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="{{ asset('public/admin/images/faces/face3.jpg') }}" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                            </h6>
                            <p class="font-weight-light small-text mb-0">
                                Upcoming board meeting
                            </p>
                        </div>
                    </a>
                </div> --}}
            </li>
            {{-- <li class="nav-item dropdown  d-flex">
                <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="typcn typcn-bell mr-0"></i>
                    <span class="count bg-danger">2</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-success">
                                <i class="typcn typcn-info-large mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">Application Error</h6>
                            <p class="font-weight-light small-text mb-0">
                                Just now
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-warning">
                                <i class="typcn typcn-cog mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">Settings</h6>
                            <p class="font-weight-light small-text mb-0">
                                Private message
                            </p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-info">
                                <i class="typcn typcn-user-outline mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">New user registration</h6>
                            <p class="font-weight-light small-text mb-0">
                                2 days ago
                            </p>
                        </div>
                    </a>
                </div>
            </li> --}}
            <li class="nav-item nav-profile dropdown">

                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
                    <i style="color:rgb(127, 147, 163);font-size: 16px;" class="fa fa-user" aria-hidden="true"></i>&nbsp;
                    <span style="color:rgb(127, 147, 163);font-weight:bold"> Profile</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('admin.setting') }}">
                        <i class="typcn typcn-cog text-primary"></i>
                        Settings
                    </a>
                    <a href="{{ route('admin.logout') }}" class="dropdown-item">
                        <i class="typcn typcn-power text-primary"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
</nav>
