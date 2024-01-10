@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Customer Invoice History</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">



                            <h1 class="card-title font-size-24"> Customer Name : {{ $customer->name }} </h1>

                            <br>
                            <br>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Customer Name</th>
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Payment Option</th>
                                        <th>Total Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Due Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>

                                    @foreach ($allData as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item['payment']['customer']['name'] }} </td>
                                            <td> #{{ $item->invoice_no }} </td>
                                            <td> {{ date('d-m-Y', strtotime($item->date)) }} </td>
                                            <td> {{ $item['payment']['payment_option'] }} </td>
                                            <td> Tsh {{ number_format($item['payment']['total_amount'],2) }} </td>
                                            <td> Tsh {{ number_format($item['payment']['paid_amount'],2) }} </td>

                                            @if ($item['payment']['due_amount'] == 0)
                                                <td> Null </td>
                                            @else
                                                <td> Tsh {{ number_format($item['payment']['due_amount'],2) }} </td>
                                            @endif

                                            <td>
                                                <a href=" {{ route('print.invoice', $item->id) }} " class="btn btn-dark sm"
                                                    title="Print Invoice"> <i class="fas fa-print"></i>
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>
@endsection
