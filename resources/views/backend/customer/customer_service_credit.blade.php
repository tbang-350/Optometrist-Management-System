@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">All Credit Service Customers</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href=" {{ route('service.credit.customer.print.pdf') }} "
                                class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right">
                                <i class="fas fa-print">
                                    Print Credit Customer(s)
                                </i>
                            </a>

                            <a href=" {{ route('credit.customer') }} "
                                class="btn btn-dark btn-rounded waves-effect waves-light" style="float:left">
                                <i class="fas fa-arrow">
                                    Product Credit Customers
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
                                        <th>Invoice No</th>
                                        <th>Date</th>
                                        <th>Due Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>

                                    @foreach ($allServiceData as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item['customer']['name'] }} </td>
                                            <td> #{{ $item['service_invoice']['service_invoice_no'] }} </td>
                                            <td> {{ date('d-m-Y', strtotime($item['service_invoice']['date'])) }} </td>
                                            <td> Tsh {{ $item->due_amount }} </td>

                                            <td>
                                                <a href="{{ route('customer.edit.service.invoice',$item->service_invoice_id) }}"
                                                    class="btn btn-info sm" title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="{{ route('customer.service.invoice.details.pdf', $item->service_invoice_id) }} "
                                                    class="btn btn-danger sm" title="Customer Invoice Details"> <i
                                                        class="fas fa-eye"></i>
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
