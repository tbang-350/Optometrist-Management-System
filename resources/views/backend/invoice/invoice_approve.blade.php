@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Invoice Approval</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            @php
                $payment = App\Models\Payment::where('invoice_id', $invoice->id)->first();
            @endphp

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4>Invoice No: #{{ $invoice->invoice_no }} ~ {{ date('d-m-Y', strtotime($invoice->date)) }}
                            </h4>

                            <a href=" {{ route('invoice.pending.list') }} "
                                class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right">
                                <i class="fas fa-list">
                                    Pending Invoices
                                </i>
                            </a>

                            <br>
                            <br>
                            <br>

                            <table class="table table-dark" width="100%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <p>Customer Info</p>
                                        </td>
                                        <td>
                                            <p>Name: <strong>{{ $payment['customer']['name'] }}</strong></p>
                                        </td>
                                        <td>
                                            <p>Mobile No: <strong>{{ $payment['customer']['phonenumber'] }}</strong></p>
                                        </td>
                                        <td>
                                            <p>address: <strong>{{ $payment['customer']['address'] }}</strong></p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td colspan="3">
                                            <p>Description: <strong>{{ $invoice->description }}</strong></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>


                            <form method="POST" action="{{ route('approval.store' , $invoice->id) }}">

                                @csrf

                                <table border="1" class="table table-dark" width="100%">

                                    <thead>
                                        <tr>
                                            <th class="text-center">S.No</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Product Name</th>
                                            <th class="text-center" style="background-color: #8B008B">Current Stock</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-center">Total Price</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @php
                                            $total_sum = '0';
                                        @endphp

                                        @foreach ($invoice['invoice_details'] as $key => $details)
                                            <tr>

                                                <input type="hidden" name="category_id[]" value="{{ $details->category_id }}">
                                                <input type="hidden" name="product_id[]" value="{{ $details->product_id }}">
                                                <input type="hidden" name="selling_qty[{{ $details->id }}]" value="{{ $details->selling_qty }}">

                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">{{ $details['category']['name'] }}</td>
                                                <td class="text-center">{{ $details['product']['name'] }}</td>
                                                <td class="text-center" style="background-color: #8B008B">{{ $details['product']['quantity'] }}</td>
                                                <td class="text-center">{{ $details->selling_qty }}</td>
                                                <td class="text-center">{{ $details->unit_price }}</td>
                                                <td class="text-center">{{ $details->selling_price }}</td>
                                            </tr>

                                            @php
                                                $total_sum += $details->selling_price;
                                            @endphp

                                        @endforeach

                                        <tr>
                                            <td colspan="6">Sub Total</td>
                                            <td class="text-center">{{ number_format($total_sum,2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">Discount</td>
                                            <td class="text-center">{{ number_format($payment->discount_amount,2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">Paid Amount</td>
                                            <td class="text-center">{{ number_format($payment->paid_amount,2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">Due Amount</td>
                                            <td class="text-center">{{ number_format($payment->due_amount,2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">Grand Total</td>
                                            <td class="text-center">{{ number_format($payment->total_amount,2) }}</td>
                                        </tr>

                                    </tbody>

                                </table>

                                <button type="submit" class="btn btn-info">Approve Invoice</button>

                            </form>






                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>
@endsection
