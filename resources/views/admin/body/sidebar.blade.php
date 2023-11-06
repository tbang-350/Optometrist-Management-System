<div class="vertical-menu">

    <div data-simplebar class="h-100">

        @php
            $role = Auth::user()->role;
        @endphp

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if ($role == '1')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-shield-user-fill"></i>
                            <span>Manage Employees</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('location.all') }}">Locations</a></li>
                            <li><a href="{{ route('employee.all') }}">Employees</a></li>
                        </ul>

                    </li>
                @endif

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-shield-user-fill"></i>
                        <span>Customers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('customer.all') }}">All Customers</a></li>
                        <li><a href="{{ route('credit.customer') }}">Credit Customers</a></li>

                        <li><a href="{{ route('paid.customer') }}">Paid Customers</a></li>
                         <li><a href="{{ route('customer.wise.report') }}">Customer Wise Report</a></li>
                    </ul>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-shield-user-fill"></i>
                        <span>Services</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('service.all') }}">All Services</a></li>
                        {{-- <li><a href="email-read.html">Read Email</a></li> --}}
                    </ul>
                </li>

                <li class="menu-title">Consultation &amp; Prescription</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-shield-user-fill"></i>
                        <span>Consultation</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('consultation.all') }}">All Consultations</a></li>
                        {{-- <li><a href="email-read.html">Read Email</a></li> --}}
                    </ul>
                </li>




                <li>

                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-shield-user-fill"></i>
                        <span>Prescription</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('prescription.all') }}">All Prescriptions</a></li>
                        {{-- <li><a href="email-read.html">Read Email</a></li> --}}
                    </ul>

                </li>

                <li class="menu-title">Product &amp; Purchase </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-hotel-fill"></i>
                        <span>Manage Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- <li><a href="{{ route('supplier.all') }}">Suppliers</a></li> --}}
                        {{-- <li><a href="{{ route('unit.all') }}">Units</a></li> --}}
                        <li><a href="{{ route('category.all') }}">Categories</a></li>
                        <li><a href="{{ route('product.all') }}">Products</a></li>
                    </ul>


                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-shopping-cart-fill"></i>
                        <span>Manage Purchases</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('purchase.all') }}">All Purchases</a></li>
                        {{-- <li><a href="{{ route('purchase.pending') }}">Purchase Approval</a></li> --}}
                        <li><a href="{{ route('daily.purchase.report') }}">Daily Purchase Report</a></li>
                    </ul>

                </li>


                <li class="menu-title">Invoice</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class=" ri-edit-box-fill"></i>
                        <span>Product Invoice</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('invoice.all') }}">All Invoices</a></li>
                        <li><a href="{{ route('invoice.pending.list') }}">Invoice Approval</a></li>
                        <li><a href="{{ route('daily.invoice.report') }}">Daily Invoice Report</a></li>
                    </ul>

                </li>



                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-shield-user-fill"></i>
                        <span>Service Invoice</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('service.invoice.all') }}">All Service Invoices</a></li>
                        {{-- <li><a href="email-read.html">Read Email</a></li> --}}
                    </ul>
                </li>





                <li class="menu-title">Reports</li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Customer</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('customer.wise.report') }}">Customer Wise Report </a></li>

                    </ul>
                </li> --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>Invoice</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('daily.service.invoice.report') }}">Daily Service Invoice Report</a></li>

                    </ul>
                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-profile-line"></i>
                        <span>Payment</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('service.invoice.payment.report') }}">Service Payment Option Report</a></li>

                    </ul>
                </li>



                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-safe-2-fill"></i>
                        <span>Stock</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('stock.report') }}">Stock Report</a></li>
                        {{-- <li><a href="{{ route('stock.supplier.wise') }}">Supplier/Product wise</a></li> --}}

                    </ul>
                </li>

                <li class="mm-active">
                    <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="true">
                        <i class="ri-share-line"></i>
                        <span>Multi Level</span>
                    </a>
                    <ul class="sub-menu mm-collapse mm-show" aria-expanded="true" style="">
                        <li class=""><a href="javascript: void(0);" class="has-arrow" aria-expanded="false">Level 1.2</a>
                            <ul class="sub-menu mm-collapse" aria-expanded="true" style="height: 0px;">
                                <li><a href="javascript: void(0);">Level 2.1</a></li>
                                <li><a href="javascript: void(0);">Level 2.2</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
