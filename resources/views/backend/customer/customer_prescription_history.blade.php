@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Prescription History</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            {{-- <a href="{{ route('prescription.add.plain') }}"
                                class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right">
                                <i class="fas fa-plus-circle">
                                    Add Prescription
                                </i>
                            </a> --}}



                            <h1 class="card-title font-size-24"> Customer Name : {{ $customer->name }} </h1>

                            <br>
                            <br>


                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="10%">Sl</th>
                                        <th>Date</th>
                                        <th>Next Appointment</th>
                                        <th width="10%">Action</th>


                                </thead>


                                <tbody>

                                    @foreach ($prescription as $key => $item)
                                        <tr>

                                            <td> {{ $key + 1 }} </td>
                                            <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>

                                            <td>{{ date('d-m-Y', strtotime($item->next_appointment)) }}</td>

                                            <td>
                                                <a href=" {{ route('prescription.view', $item->id) }} " class="btn btn-dark sm"
                                                    title="View Data">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                {{-- <a href=" {{ route('prescription.edit', $item->id) }} " class="btn btn-info sm"
                                                    title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href=" {{ route('prescription.delete', $item->id) }} "
                                                    class="btn btn-danger sm" title="Delete Data" id="delete"> <i
                                                        class="fas fa-trash-alt"></i>
                                                </a> --}}
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
