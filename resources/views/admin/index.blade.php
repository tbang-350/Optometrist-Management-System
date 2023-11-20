@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            @php
                $role = Auth::user()->role;
            @endphp

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Upcube</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

                @php

                    $current_location = Auth::user()->location_id;

                    if ($current_location == 1) {

                        $total_sales = App\Models\PaymentDetails::sum('current_paid_amount');

                        $total_service_sales = App\Models\ServicePaymentDetail::sum('current_paid_amount');

                        $total_services = App\Models\Service::count();

                        $total_employees = App\Models\User::whereIn('role', ['2', '3'])->count();

                        $total_locations = App\Models\Location::count();

                        $total_customers = App\Models\Customer::count();

                    } else {

                        $total_sales = App\Models\PaymentDetails::where('location_id',$current_location)->sum('current_paid_amount');

                        $total_service_sales = App\Models\ServicePaymentDetail::where('location_id',$current_location)->sum('current_paid_amount');

                        $total_services = App\Models\Service::count();

                        $total_employees = App\Models\User::whereIn('role', ['2', '3'])->count();

                        $total_locations = App\Models\Location::count();

                        $total_customers = App\Models\Customer::where('location_id', $current_location)->count();
                    }

                @endphp

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Product Sales</p>
                                    <h4 class="mb-2">{{ $total_sales }}</h4>

                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="mdi mdi-currency-usd  font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Service Sales</p>
                                    <h4 class="mb-2">{{ $total_service_sales }}</h4>

                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="mdi mdi-currency-usd  font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->


                @if ($role == '1')
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-14 mb-2">Total Employees</p>
                                        <h4 class="mb-2">{{ $total_employees }}</h4>

                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-light text-primary rounded-3">
                                            <i class=" ri-user-2-line font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end cardbody -->
                        </div><!-- end card -->
                    </div><!-- end col -->


                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-14 mb-2">Locations</p>
                                        <h4 class="mb-2">{{ $total_locations }}</h4>

                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-light text-primary rounded-3">
                                            <i class=" ri-user-line font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end cardbody -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                @endif



                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Customers</p>
                                    <h4 class="mb-2">{{ $total_customers }}</h4>

                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class=" ri-user-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->


                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Services</p>
                                    <h4 class="mb-2">{{ $total_services }}</h4>

                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class=" ri-user-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->








            </div><!-- end row -->

            <div class="row">


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>

                                </div>

                                <h4 class="card-title mb-4">Latest Transactions</h4>

                                @php

                                    $current_location = Auth::user()->location_id;

                                    if ($current_location == 1) {
                                        $allData = App\Models\Invoice::orderBy('date', 'desc')
                                            ->orderBy('id', 'desc')
                                            ->take(10)
                                            ->get();
                                    } else {
                                        $allData = App\Models\Invoice::orderBy('date', 'desc')
                                            ->orderBy('id', 'desc')
                                            ->where('location_id', $current_location)
                                            ->take(10)
                                            ->get();
                                    }

                                @endphp

                                <div class="table-responsive">
                                    <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Sl</th>
                                                <th>Customer Name</th>
                                                <th>Invoice No</th>
                                                <th>Date</th>
                                                <th>Total Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Due Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead><!-- end thead -->


                                        <tbody>
                                            @foreach ($allData as $key => $item)
                                                <tr>
                                                    <td> {{ $key + 1 }} </td>
                                                    <td> {{ $item['payment']['customer']['name'] }} </td>
                                                    <td> #{{ $item->invoice_no }} </td>
                                                    <td> {{ date('d-m-Y', strtotime($item->date)) }} </td>

                                                    <td> Tsh {{ $item['payment']['total_amount'] }} </td>
                                                    <td> Tsh {{ $item['payment']['paid_amount'] }} </td>

                                                    @if ($item['payment']['due_amount'] == 0)
                                                        <td> Null </td>
                                                    @else
                                                        <td> Tsh {{ $item['payment']['due_amount'] }} </td>
                                                    @endif
                                                    <td>
                                                        <a href=" {{ route('print.invoice', $item->id) }} "
                                                            class="btn btn-dark sm" title="Print Invoice"> <i
                                                                class="fas fa-eye"></i>
                                                        </a>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>


                                    </table> <!-- end table -->
                                </div>
                            </div><!-- end card -->
                        </div><!-- end card -->
                    </div>
                    <!-- end col -->



                </div>
                <!-- end row -->
            </div>

        </div>
    @endsection
