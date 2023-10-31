@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">All Stock Report</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href=" {{ route('stock.report.pdf') }} "
                                class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right">
                                <i class="fas fa-print">
                                    Print Stock Report
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
                                        <th>Product Name</th>
                                        <th>Supplier name</th>
                                        <th>Category</th>
                                        <th>In Qty</th>
                                        <th>Out Qty</th>
                                        <th>Stock</th>

                                </thead>


                                <tbody>

                                    @foreach ($allData as $key => $item)
                                        @php
                                            $buying_total = App\Models\Purchase::where('category_id', $item->category_id)
                                                ->where('product_id', $item->id)
                                                ->where('status', '1')->sum('buying_qty');

                                            $selling_total = App\Models\InvoiceDetail::where('category_id',$item->category_id)
                                                ->where('product_id', $item->id)
                                                ->where('status','1')->sum('selling_qty')

                                        @endphp

                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item->name }} </td>
                                            <td> {{ $item->spplier_name }} </td>

                                            <td> {{ $item['category']['name'] }} </td>
                                            <td> {{ $buying_total }} </td>
                                            <td> {{ $selling_total }} </td>
                                            <td> {{ $item->quantity }} </td>

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
