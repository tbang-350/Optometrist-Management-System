@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">All Purchases</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">




                            <a style="float:left" >

                                <!-- Small modal -->
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    Import
                                </button>

                            </a>


                            <a href=" {{ route('purchase.add') }} "
                                class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right">
                                <i class="fas fa-plus-circle">
                                    Add Purchase
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
                                        <th>Purchase No</th>
                                        <th>Date</th>
                                        <th>Supplier</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Buying Price</th>
                                        <th>Product Name</th>
                                        <th>Status</th>
                                        {{-- <th>Action</th> --}}

                                </thead>


                                <tbody>

                                    @foreach ($allData as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item->purchase_no }} </td>
                                            <td> {{ date('d-m-Y', strtotime($item->date)) }} </td>
                                            <td> {{ $item->supplier_name }} </td>
                                            <td> {{ $item['category']['name'] }} </td>
                                            <td> {{ $item->buying_qty }} </td>
                                            <td> {{ $item->buying_unit_price }} </td>
                                            <td> {{ $item->total_buying_amount }} </td>
                                            <td> {{ $item['product']['name'] }} </td>
                                            <td>
                                                @if ($item->status == '0')
                                                    <span class="btn btn-warning">Pending</span>
                                                @elseif($item->status == '1')
                                                    <span class="btn btn-success">Approved</span>
                                                @endif
                                            </td>

                                            {{-- <td>

                                                @if ($item->status == '0')
                                                    <a href=" {{ route('purchase.delete', $item->id) }} "
                                                        class="btn btn-danger sm" title="Delete Data" id="delete"> <i
                                                            class="fas fa-trash-alt"></i>
                                                    </a>
                                                @endif

                                            </td> --}}

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->


        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Import purchase</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form action="{{ route('purchase.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" class="form-control">

                            <br>

                            <button class="btn btn-success">Import</button>
                        </form>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                        {{-- <button type="button" class="btn btn-primary waves-effect waves-light">Save</button> --}}
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection
