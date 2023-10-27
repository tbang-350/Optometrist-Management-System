@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">All Invoices</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href=" {{ route('service.invoice.add') }} " class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right">
                                <i class="fas fa-plus-circle">
                                    Add Service Invoice
                                </i>
                            </a>

                            <br>
                            <br>
                            <br>

                            {{-- <h4 class="card-title"> All Supplier Data </h4> --}}


                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Customer Name</th>
                                        <th>Service Invoice No</th>
                                        <th>Date</th>
                                        <th>Payment Method</th>
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
                                            <td> {{ $item['service_payment']['customer']['name'] }} </td>
                                            <td> #{{ $item->service_invoice_no }} </td>
                                            <td> {{ date('d-m-Y', strtotime($item->date)) }} </td>
                                            <td> {{ $item['service_payment']['payment_option'] }} </td>
                                            <td> Tsh {{ $item['service_payment']['total_amount'] }} </td>
                                            <td> Tsh {{ $item['service_payment']['paid_amount'] }} </td>

                                            @if ($item['service_payment']['due_amount'] == 0)
                                                <td> Null </td>
                                            @else
                                                <td> Tsh {{ $item['service_payment']['due_amount'] }} </td>
                                            @endif

                                            <td>
                                                <a href=" {{ route('print.service.invoice', $item->id) }} " class="btn btn-dark sm"
                                                    title="Print Prescription"> <i class="fas fa-print"></i>
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
