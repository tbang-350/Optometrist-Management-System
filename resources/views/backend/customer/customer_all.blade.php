@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">All Customers</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('customer.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right">
                                <i class="fas fa-plus-circle">
                                    Add Customer
                                </i>
                            </a>

                            <br>
                            <br>
                            <br>

                            {{-- <h4 class="card-title"> All Supplier Data </h4> --}}

                            @php
                                $role = Auth::user()->role;
                            @endphp


                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Sex</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        @if ($role == '1')
                                            <th>Location</th>
                                        @endif

                                        <th width="10%" >Action</th>

                                </thead>


                                <tbody>

                                    @foreach ($customer as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item->name }} </td>
                                            <td> {{ $item->age }} </td>
                                            <td> {{ $item->sex }} </td>
                                            <td> {{ $item->phonenumber }} </td>
                                            <td> {{ $item->address }} </td>

                                            @if ($role == '1')
                                                <td> {{ $item['location']['location_name'] }} </td>
                                            @endif

                                            <td>

                                                {{-- <a href=" {{ route('customer.prescription.history', $item->id) }} " class="btn btn-warning sm"
                                                    title="Prescription History">
                                                    <i class=" fas fa-clinic-medical"></i>
                                                </a>


                                                <a href=" {{ route('customer.purchase.history', $item->id) }} " class="btn btn-dark sm"
                                                    title="Purchase History">
                                                    <i class="fas fa-cart-arrow-down"></i>
                                                </a> --}}

                                                <a href=" {{ route('customer.edit', $item->id) }} " class="btn btn-info sm"
                                                    title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </a>



                                                <a href=" {{ route('customer.delete', $item->id) }} "
                                                    class="btn btn-danger sm" title="Delete Data" id="delete"> <i
                                                        class="fas fa-trash-alt"></i>
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
