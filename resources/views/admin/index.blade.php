@extends('admin.admin_master')
@section('admin')
    @php
        $stats = $stats ?? [
            'totalProductSales' => 0,
            'totalServiceSales' => 0,
            'todayProductSales' => 0,
            'todayServiceSales' => 0,
            'totalCustomers' => 0,
            'newCustomersToday' => 0,
            'totalServices' => 0,
            'totalEmployees' => 0,
            'totalLocations' => 0,
            'totalStock' => 0,
            'pendingInvoices' => 0,
            'approvedInvoices' => 0,
            'productDueTotal' => 0,
            'serviceDueTotal' => 0,
            'unseenConsultations' => 0,
            'consultationsToday' => 0,
            'prescriptionsToday' => 0,
            'lowStockCount' => 0,
        ];

        $latestInvoices = $latestInvoices ?? collect();
        $topProducts = $topProducts ?? collect();
        $lowStockProducts = $lowStockProducts ?? collect();

        if (!isset($chart)) {
            $chart = app()->make(App\Charts\MonthlySalesChart::class)->build();
        }

        if (!isset($chart2)) {
            $chart2 = app()->make(App\Charts\PriceComparison::class)->build();
        }
    @endphp
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
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

                @if ($role == 1 || $role == 2)
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-14 mb-2">Total Product Sales</p>
                                        <h4 class="mb-2">{{ number_format($stats['totalProductSales'], 2) }}</h4>

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
                                        <h4 class="mb-2">{{ number_format($stats['totalServiceSales'], 2) }}</h4>

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
                @endif



                @if ($role == '1')
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-truncate font-size-14 mb-2">Total Employees</p>
                                        <h4 class="mb-2">{{ $stats['totalEmployees'] }}</h4>

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
                                        <h4 class="mb-2">{{ $stats['totalLocations'] }}</h4>

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
                                        <p class="text-truncate font-size-14 mb-2">Stock</p>
                                        <h4 class="mb-2">{{ $stats['totalStock'] }}</h4>

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
                                    <h4 class="mb-2">{{ $stats['totalCustomers'] }}</h4>

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
                                    <h4 class="mb-2">{{ $stats['totalServices'] }}</h4>

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
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Today Product Sales</p>
                                    <h4 class="mb-2">{{ number_format($stats['todayProductSales'], 2) }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="mdi mdi-currency-usd font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Today Service Sales</p>
                                    <h4 class="mb-2">{{ number_format($stats['todayServiceSales'], 2) }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="mdi mdi-currency-usd font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Pending Invoices</p>
                                    <h4 class="mb-2">{{ $stats['pendingInvoices'] }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-file-list-2-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Unseen Consultations</p>
                                    <h4 class="mb-2">{{ $stats['unseenConsultations'] }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-stethoscope-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Product Due</p>
                                    <h4 class="mb-2">{{ number_format($stats['productDueTotal'], 2) }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-money-dollar-circle-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Service Due</p>
                                    <h4 class="mb-2">{{ number_format($stats['serviceDueTotal'], 2) }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-money-dollar-circle-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">New Customers Today</p>
                                    <h4 class="mb-2">{{ $stats['newCustomersToday'] }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-user-add-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Prescriptions Today</p>
                                    <h4 class="mb-2">{{ $stats['prescriptionsToday'] }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="ri-file-text-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Sales (This Month)</h4>
                            {!! $chart->container() !!}
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Payment Options</h4>
                            {!! $chart2->container() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Latest Transactions</h4>
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
                                    </thead>
                                    <tbody>
                                        @foreach ($latestInvoices as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->payment?->customer?->name ?? 'N/A' }}</td>
                                                <td>#{{ $item->invoice_no }}</td>
                                                <td>{{ $item->date ? date('d-m-Y', strtotime($item->date)) : 'N/A' }}</td>
                                                <td>Tsh {{ number_format($item->payment?->total_amount ?? 0, 2) }}</td>
                                                <td>Tsh {{ number_format($item->payment?->paid_amount ?? 0, 2) }}</td>
                                                @if (($item->payment?->due_amount ?? 0) == 0)
                                                    <td>Null</td>
                                                @else
                                                    <td>Tsh {{ number_format($item->payment?->due_amount ?? 0, 2) }}</td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('print.invoice', $item->id) }}"
                                                        class="btn btn-dark sm" title="Print Invoice">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Top Products (Last 30 Days)</h4>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-end">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($topProducts as $row)
                                            <tr>
                                                <td>{{ $row->product_name }}</td>
                                                <td class="text-end">{{ number_format($row->total_qty, 0) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2">No data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Low Stock Alerts</h4>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-end">Stock</th>
                                            <th class="text-end">Reorder</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($lowStockProducts as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td class="text-end">{{ number_format($product->quantity, 0) }}</td>
                                                <td class="text-end">{{ number_format($product->reorder_level, 0) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">No low stock items</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2 text-muted">
                                Total alerts: {{ $stats['lowStockCount'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script src="{{ $chart->cdn() }}"></script>
        {!! $chart->script() !!}

        <script src="{{ $chart2->cdn() }}"></script>
        {!! $chart2->script() !!}
    @endsection
