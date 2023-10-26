@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Customer service_payment Report</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">

                                <li class="breadcrumb-item active">Customer service_payment Report</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            @php

                                $company_info = App\Models\Company::first();

                            @endphp

                            <div class="row">
                                <div class="col-12">
                                    <div class="invoice-title">
                                        <h4 class="float-end font-size-16"><strong>Invoice No #
                                                {{ $service_payment['service_invoice']['service_invoice_no'] }}</strong></h4>
                                        <h3>
                                            <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo"
                                                height="24" /> {{ $company_info->company_name }}
                                        </h3>
                                    </div>
                                    <hr>



                                    <div class="row">
                                        <div class="col-6 mt-4">
                                            <address>
                                                <strong>{{ $company_info->company_name }}:</strong><br>
                                                {{ $company_info->company_address }}<br>
                                                {{ $company_info->company_email }}<br>
                                                {{ $company_info->company_phone }}<br>
                                            </address>
                                        </div>
                                        <div class="col-6 mt-4 text-end">
                                            <address>
                                                <strong>Invoice Date:</strong><br>
                                                {{ date('d-m-Y', strtotime($service_payment['service_invoice']['date'])) }}<br><br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @php
                                $service_payment = App\Models\ServicePayment::where('service_invoice_id', $service_payment->service_invoice_id)->first();
                            @endphp

                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <div class="p-2">
                                            <h3 class="font-size-16"><strong>Customer Invoice</strong></h3>
                                        </div>
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td><strong>Customer Name</strong></td>
                                                            <td class="text-center"><strong>Phone Number</strong></td>
                                                            <td class="text-center"><strong>Address</strong>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                        <tr>
                                                            <td>{{ $service_payment['customer']['name'] }}</td>
                                                            <td class="text-center">{{ $service_payment['customer']['phonenumber'] }}
                                                            </td>
                                                            <td class="text-center">{{ $service_payment['customer']['address'] }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- end row -->



                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <div class="p-2">

                                        </div>
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td class="text-center">
                                                                <strong>S.No</strong>
                                                            </td>

                                                            <td class="text-center">
                                                                <strong>Service Name</strong>
                                                            </td>

                                                            <td class="text-center">
                                                                <strong>Total Price(Tshs)</strong>
                                                            </td>

                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                        @php

                                                            $total_sum = '0';

                                                            $service_invoice_details = App\Models\ServiceInvoiceDetails::where('service_invoice_id', $service_payment->service_invoice_id)->get();

                                                        @endphp

                                                        @foreach ($service_invoice_details as $key => $details)
                                                            <tr>
                                                                <td class="text-center">{{ $key + 1 }}</td>
                                                                    <td class="text-center">
                                                                        {{ $details['service']['name'] }}
                                                                    </td>

                                                                    <td class="text-center">{{ $details->service_price }}
                                                                    </td>
                                                            </tr>

                                                            @php
                                                                $total_sum += $details->service_selling_price;
                                                            @endphp
                                                        @endforeach

                                                        <tr>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line text-center">
                                                                <h6>
                                                                    <strong>Subtotal(Tshs)</strong>
                                                                </h6>
                                                            </td>
                                                            <td class="thick-line text-center">
                                                                <h6>
                                                                    {{ $total_sum }}
                                                                </h6>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <h6>
                                                                    <strong>Discount Amount(Tshs)</strong>
                                                                </h6>
                                                            </td>
                                                            <td class="no-line text-center">
                                                                <h6>
                                                                    {{ $service_payment->discount_amount }}
                                                                </h6>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <h6>
                                                                    <strong>Paid Amount(Tshs)</strong>
                                                                </h6>
                                                            </td>
                                                            <td class="no-line text-center" colspan="5">
                                                                <h6>
                                                                    {{ $service_payment->paid_amount }}
                                                                </h6>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <h6>
                                                                    <strong>Due Amount(Tshs)</strong>
                                                                </h6>
                                                            </td>
                                                            <td class="no-line text-center">
                                                                <h6>
                                                                    {{ $service_payment->due_amount }}
                                                                </h6>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <h6>
                                                                    <strong>Grand Total(Tshs)</strong>
                                                                </h6>
                                                            </td>
                                                            <td class="no-line text-center">
                                                                <h4 class="m-0">{{ $service_payment->total_amount }}
                                                                </h4>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="3" style="text-align:center; font-weight:bold;">
                                                                Payment History</td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="2" style="text-align:center; font-weight:bold;">
                                                                Date</td>

                                                            <td colspan="1" style="text-align:center; font-weight:bold;">
                                                                Amount</td>
                                                        </tr>

                                                        @php

                                                            $service_payment_details = App\Models\ServicePaymentDetail::where('service_invoice_id', $service_payment->service_invoice_id)->get();

                                                        @endphp

                                                        @foreach ($service_payment_details as $key => $item)
                                                            <tr>
                                                                <td colspan="2"
                                                                    style="text-align:center; font-weight:bold;">
                                                                    {{ date('d-m-Y', strtotime($item->date)) }}</td>

                                                                <td colspan="1"
                                                                    style="text-align:center; font-weight:bold;">
                                                                    {{ $item->current_paid_amount }}</td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="d-print-none">
                                                <div class="float-end">
                                                    <a href="javascript:window.print()"
                                                        class="btn  btn-success waves-effect waves-light"><i
                                                            class="fa fa-print"></i></a>
                                                    {{-- <a href="javascript:window.print()"
                                                        class="btn btn-primary waves-effect waves-light ms-2">Download</a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- end row -->

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
