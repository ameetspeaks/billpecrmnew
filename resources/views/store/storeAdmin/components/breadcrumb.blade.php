

@if (
    !Route::is([
        'store.add-product',
        'store.chart-apex',
        'store.chart-c3',
        'store.chart-flot',
        'store.chart-js',
        'store.chart-morris',
        'store.chart-peity',
        'store.data-tables',
        'tables-basic',
        'store.form-basic-inputs',
        'store.form-checkbox-radios',
        'store.form-input-groups',
        'store.form-grid-gutters',
        'store.form-select',
        'store.form-mask',
        'store.form-fileupload',
        'store.form-horizontal',
        'store.form-vertical',
        'store.form-floating-labels',
        'store.form-validation',
        'store.form-select2',
        'store.form-wizard',
        'store.icon-fontawesome',
        'store.icon-feather',
        'store.icon-ionic',
        'store.icon-material',
        'store.icon-pe7',
        'store.icon-simpleline',
        'store.icon-themify',
        'store.icon-weather',
        'store.icon-typicon',
        'store.icon-flag',
        'store.ui-clipboard',
        'store.ui-counter',
        'store.ui-drag-drop',
        'store.ui-rating',
        'store.ui-ribbon',
        'store.ui-scrollbar',
        'store.ui-stickynote',
        'store.ui-text-editor',
        'store.ui-timeline',
    ]))
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ $title }}</h4>
                <h6>{{ $li_1 }}</h6>
            </div>
        </div>
        <!-- <ul class="table-top-head">
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img
                        src="{{ URL::asset('/public/build/img/icons/pdf.svg') }}" alt="img"></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img
                        src="{{ URL::asset('/public/build/img/icons/excel.svg') }}" alt="img"></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Print"><i data-feather="printer"
                        class="feather-rotate-ccw"></i></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw"
                        class="feather-rotate-ccw"></i></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                        data-feather="chevron-up" class="feather-chevron-up"></i></a>
            </li>
        </ul> -->
        @if (Route::is(['store.warranty']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i> {{ $li_2 }}</a>
            </div>
        @endif
        @if (Route::is(['store.warehouse']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>{{ $li_2 }}</a>
            </div>
        @endif
        @if (Route::is(['store.varriant-attributes']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i> {{ $li_2 }}</a>
            </div>
        @endif
        @if (Route::is(['store.units']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i> {{ $li_2 }}</a>
            </div>
        @endif
        @if (Route::is(['store.suppliers']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Supplier</a>
            </div>
        @endif
        @if (Route::is(['store.sub-categories']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-category"><i
                        data-feather="plus-circle" class="me-2"></i> Add Sub Category</a>
            </div>
        @endif
        @if (Route::is(['store.store-list']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-stores"><i
                        data-feather="plus-circle" class="me-2"></i> Add Store</a>
            </div>
        @endif
        @if (Route::is(['store.stock-transfer']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Add New</a>
            </div>
            <div class="page-btn import">
                <a href="#" class="btn btn-added color" data-bs-toggle="modal" data-bs-target="#view-notes"><i
                        data-feather="download" class="me-2"></i>Import Transfer</a>
            </div>
        @endif
        @if (Route::is(['store.stock-adjustment']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Add New</a>
            </div>
        @endif
        @if (Route::is(['store.states']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Add New State</a>
            </div>
        @endif
        @if (Route::is(['store.shift']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Shift</a>
            </div>
        @endif
        @if (Route::is(['store.sales-returns']))
            <div class="page-btn">
                <a href="{{ url('createsalesreturn') }}" class="btn btn-added" data-bs-toggle="modal"
                    data-bs-target="#add-sales-new"><i data-feather="plus-circle" class="me-2"></i>Add New Sales
                    Return</a>
            </div>
        @endif
        @if (Route::is(['store.sales-list']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-sales-new"><i
                        data-feather="plus-circle" class="me-2"></i> Add New Sales</a>
            </div>
        @endif
        @if (Route::is(['store.quotation-list']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Quotation</a>
            </div>
        @endif
        @if (Route::is(['store.purchase-returns']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-sales-new">
                    <i data-feather="plus-circle" class="me-2"></i>Add Purchase Return
                </a>
            </div>
        @endif
        @if (Route::is(['store.payroll-list']))
            <div class="page-btn">
                <button class="btn btn-primary add-em-payroll" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasRight-add" aria-controls="offcanvasRight-add"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Payoll</button>
            </div>
        @endif
        @if (Route::is(['store.manage-stocks']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Add New</a>
            </div>
        @endif
        @if (Route::is(['store.leaves-employee']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Apply Leave</a>
            </div>
        @endif
        @if (Route::is(['store.leaves-admin']))
            <div class="page-btn">
                <a href="{{ url('leave-types') }}" class="btn btn-added">Leave type</a>
            </div>
        @endif
        @if (Route::is(['store.leave-types']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Add Leave type</a>
            </div>
        @endif
        @if (Route::is(['store.holidays']))
            <div class="page-btn">
                <a href="" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-department"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Holiday</a>
            </div>
        @endif
        @if (Route::is(['store.expense-list']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i> Add New Expense</a>
            </div>
        @endif
        @if (Route::is(['store.expense-category']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i> Add Expense Category</a>
            </div>
        @endif
        @if (Route::is(['store.employees-grid']))
            <div class="page-btn">
                <a href="{{ url('add-employee') }}" class="btn btn-added"><i data-feather="plus-circle"
                        class="me-2"></i>Add New Employee</a>
            </div>
        @endif
        @if (Route::is(['store.designation']))
            <div class="page-btn">
                <a href="" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-department"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Designation</a>
            </div>
        @endif
        @if (Route::is(['store.department-grid']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-department"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Department</a>
            </div>
        @endif
        @if (Route::is(['store.customers']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Customer</a>
            </div>
        @endif
        @if (Route::is(['store.coupons']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Coupons</a>
            </div>
        @endif
        @if (Route::is(['store.countries']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Country</a>
            </div>
        @endif
        @if (Route::is(['store.category-list']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-category"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Category</a>
            </div>
        @endif
        @if (Route::is(['store.brand-list']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-brand"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Brand</a>
            </div>
        @endif
        @if (Route::is(['store.attendance-admin']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Add New Attendance</a>
            </div>
        @endif
        @if (Route::is(['store.users']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i>Add New User</a>
            </div>
        @endif
        @if (Route::is(['store.roles-permissions']))
            <div class="page-btn">
                <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                        data-feather="plus-circle" class="me-2"></i> Add New Role</a>
            </div>
        @endif
        @if (Route::is(['store.product-list']))
            <div class="page-btn">
                <a href="{{ $li_2 }}" class="btn btn-added"><i data-feather="plus-circle"
                        class="me-2"></i>{{ $li_3 }}</a>
            </div>
            
        @endif
    </div>
@endif

@if (Route::is([
        'store.chart-apex',
        'store.chart-c3',
        'store.chart-flot',
        'store.chart-js',
        'store.chart-morris',
        'store.chart-peity',
        'store.data-tables',
        'store.tables-basic',
        'store.form-basic-inputs',
        'store.form-checkbox-radios',
        'store.form-input-groups',
        'store.form-grid-gutters',
        'store.form-select',
        'store.form-mask',
        'store.form-fileupload',
        'store.form-horizontal',
        'store.form-vertical',
        'store.form-floating-labels',
        'store.form-validation',
        'store.form-select2',
        'store.form-wizard',
        'store.icon-fontawesome',
        'store.icon-feather',
        'store.icon-ionic',
        'store.icon-material',
        'store.icon-pe7',
        'store.icon-simpleline',
        'store.icon-themify',
        'store.icon-weather',
        'store.icon-typicon',
        'store.icon-flag',
        'store.ui-clipboard',
        'store.ui-counter',
        'store.ui-drag-drop',
        'store.ui-rating',
        'store.ui-ribbon',
        'store.ui-scrollbar',
        'store.ui-stickynote',
        'store.ui-text-editor',
        'store.ui-timeline',
    ]))
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">{{ $title }}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('index') }}">{{ $li_1 }}</a></li>
                    <li class="breadcrumb-item active">{{ $li_2 }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
@endif
