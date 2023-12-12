@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">All Prescriptions</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('prescription.add.plain') }}"
                                class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right">
                                <i class="fas fa-plus-circle">
                                    Add Prescription
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
                                        <th>Date</th>
                                        <th>Customer Name</th>
                                        <th>Next Appointment</th>
                                        <th>Action</th>


                                </thead>


                                <tbody>

                                    @foreach ($prescription as $key => $item)
                                        <tr>

                                            <td> {{ $key + 1 }} </td>
                                            <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                            <td>{{ $item['customer']['name'] }}</td>
                                            <td>{{ $item->next_appointment }}</td>
                                            <td>
                                                <a href=" {{ route('prescription.view', $item->id) }} " class="btn btn-info sm"
                                                    title="View Data">
                                                    <i class="fas fa-eye"></i>
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
