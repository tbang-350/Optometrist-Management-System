@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Customer Invoice</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">

                                <li class="breadcrumb-item active">Customer Invoice</li>
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

                            <a href=" {{ route('credit.service.customer') }} "
                                class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right">
                                <i class="fas fa-list">
                                    Back
                                </i>
                            </a>



                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <div class="p-2">
                                            <h3 class="font-size-16"><strong>Invoice no:
                                                    #{{ $service_payment['service_invoice']['service_invoice_no'] }}</strong>
                                            </h3>
                                        </div>
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td><strong>Customer Name</strong></td>
                                                            <td class="text-center"><strong>Age</strong></td>
                                                            <td class="text-center"><strong>Sex</strong></td>
                                                            <td class="text-center"><strong>Phone Number</strong></td>
                                                            <td class="text-center"><strong>Address</strong>
                                                            </td>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                        <tr>
                                                            <td>{{ $service_payment['customer']['name'] }}</td>
                                                            <td class="text-center">
                                                                {{ $service_payment['customer']['age'] }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $service_payment['customer']['sex'] }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $service_payment['customer']['phonenumber'] }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $service_payment['customer']['address'] }}
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

                                    <form
                                        action="{{ route('customer.update.service.invoice', $service_payment->service_invoice_id) }}"
                                        method="post" id="myForm">
                                        @csrf
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
                                                                <input type="hidden" name="new_paid_amount"
                                                                    value="{{ $service_payment->due_amount }}">
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
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-3">

                                                        <label for="service_payment status">Payment Status</label>
                                                        <select name="paid_status" id="paid_status" class="form-select">

                                                            <option value="">Select Payement Status</option>
                                                            <option value="full_paid">Fully Paid</option>
                                                            <option value="partial_paid">Partially Paid</option>

                                                        </select>

                                                        <br>

                                                        <input type="text" name="paid_amount"
                                                            class="form-control paid_amount"
                                                            placeholder="Enter Paid Amount..." style="display: none">

                                                    </div>

                                                    <div class="form-group col-md-3">

                                                        <label for="example-text-input" class="form-label">Date</label>
                                                        <div class=" form-group col-sm-10">
                                                            <input name="date" class="form-control example-date-input"
                                                                type="date" id="date" placeholder="YYYY-MM-DD">
                                                        </div>

                                                    </div>

                                                    <div class="form-group col-md-3">

                                                        <div class="md-3" style="padding-top: 28px">
                                                            <button type="submit" class="btn btn-info">Invoice
                                                                Update</button>
                                                        </div>

                                                    </div>

                                                </div>


                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div> <!-- end row -->

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->


    <script type="text/javascript">
        $(document).on('change', '#paid_status', function() {
            var paid_status = $(this).val();
            if (paid_status == 'partial_paid') {
                $('.paid_amount').show();
            } else {
                $('.paid_amount').hide();
            }
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    paid_amount: {
                        required: true,
                    },
                    date: {
                        required: true,
                    },
                    paid_status: {
                        required: true,
                    },


                },
                messages: {
                    paid_amount: {
                        required: 'Please Enter Paid Amount',
                    },
                    date: {
                        required: 'Date is required',
                    },
                    paid_status: {
                        required: 'Please choose service_payment status',
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection
