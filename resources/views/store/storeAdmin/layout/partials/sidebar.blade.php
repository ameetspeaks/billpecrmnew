<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Main</h6>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);"
                                class="{{ Request::is('store/dashboard', 'store/sales-dashboard') ? 'active subdrop' : '' }}"><i
                                    data-feather="grid"></i><span>Dashboard</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('store.dashboard') }}"
                                        class="{{ Request::is('store.dashboard', '/') ? 'active' : '' }}">Admin Dashboard</a></li>
                                <!-- <li><a href="{{ route('store.sales-dashboard') }}"
                                        class="{{ Request::is('store.sales-dashboard') ? 'active' : '' }}">Sales Dashboard</a>
                                </li> -->
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Inventory</h6>
                    <ul>
                        <li class="{{ Request::is('store/product-list','store/product-details') ? 'active' : '' }}"><a
                                href="{{ route('store.product-list') }}"><i data-feather="box"></i><span>Products</span></a>
                        </li>
                        <li class="{{ Request::is('store/add-product','store/edit-product') ? 'active' : '' }}"><a
                                href="{{ route('store.add-product') }}"><i data-feather="plus-square"></i><span>Create
                                    Product</span></a></li>
                        <li class="{{ Request::is('store/expired-products') ? 'active' : '' }}"><a
                                href="{{ route('store.expired-products') }}"><i data-feather="codesandbox"></i><span>Expired
                                    Products</span></a></li>
                        <li class="{{ Request::is('store/low-stocks') ? 'active' : '' }}"><a
                                href="{{ route('store.low-stocks') }}"><i data-feather="trending-down"></i><span>Low
                                    Stocks</span></a></li>
                        <!-- <li class="{{ Request::is('store/barcode') ? 'active' : '' }}"><a href="{{ route('store.barcode') }}"><i
                                    data-feather="align-justify"></i><span>Print
                                    Barcode</span></a></li>
                        <li class="{{ Request::is('store/qrcode') ? 'active' : '' }}"><a href="{{ route('store.qrcode') }}"><i
                                    data-feather="maximize"></i><span>Print QR Code</span></a>
                        </li> -->
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Stock</h6>
                    <ul>
                        <li class="{{ Request::is('store/manage-stocks') ? 'active' : '' }}"><a
                                href="{{ route('store.manage-stocks') }}"><i data-feather="package"></i><span>Manage
                                    Stock</span></a></li>
                        <!-- <li class="{{ Request::is('store/stock-adjustment') ? 'active' : '' }}"><a
                                href="{{ route('store.stock-adjustment') }}"><i data-feather="clipboard"></i><span>Stock
                                    Adjustment</span></a></li> -->
                        <!-- <li class="{{ Request::is('stock-transfer') ? 'active' : '' }}"><a
                                href="{{ url('stock-transfer') }}"><i data-feather="truck"></i><span>Stock
                                    Transfer</span></a></li> -->
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Sales</h6>
                    <ul>
                        <li class="{{ Request::is('store/sales-list') ? 'active' : '' }}"><a
                                href="{{ route('store.sales-list') }}"><i
                                    data-feather="shopping-cart"></i><span>Sales</span></a></li>
                        <li class="{{ Request::is('store/invoice-report') ? 'active' : '' }}"><a
                                href="{{ route('store.invoice-report') }}"><i
                                    data-feather="file-text"></i><span>Invoices</span></a></li>
                        <!-- <li class="{{ Request::is('store/sales-returns') ? 'active' : '' }}"><a
                                href="{{ route('store.sales-returns') }}"><i data-feather="copy"></i><span>Sales
                                    Return</span></a></li> -->
                        <!-- <li class="{{ Request::is('store/quotation-list') ? 'active' : '' }}"><a
                                href="{{ route('store.quotation-list') }}"><i
                                    data-feather="save"></i><span>Quotation</span></a>
                        </li> -->
                        <!-- <li class="{{ Request::is('store/pos') ? 'active' : '' }}"><a href="{{ route('store.pos') }}"><i
                                    data-feather="hard-drive"></i><span>POS</span></a></li> -->
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Peoples</h6>
                    <ul>
                        <li class="{{ Request::is('store/customers') ? 'active' : '' }}"><a
                                href="{{ route('store.customers') }}"><i data-feather="user"></i><span>Customers</span></a>
                        </li>
                        <li class="{{ Request::is('store/suppliers') ? 'active' : '' }}"><a
                                href="{{ route('store.suppliers') }}"><i data-feather="users"></i><span>Suppliers</span></a>
                        </li>
                        <li class="{{ Request::is('store/store-list') ? 'active' : '' }}"><a
                                href="{{ route('store.store-list') }}"><i data-feather="home"></i><span>Stores</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">User Management</h6>
                    <ul>
                        <li class="{{ Request::is('store/staff') ? 'active' : '' }}"><a href="{{ route('store.staff') }}"><i
                                    data-feather="user-check"></i><span>Staff</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
