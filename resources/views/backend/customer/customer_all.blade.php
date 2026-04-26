@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
                                <i class="fas fa-plus-circle"> Add Customer </i>
                            </a>

                            <br><br><br>

                            @php
                                $role = Auth::user()->role;
                            @endphp

                            <table id="customer-datatable" class="table table-bordered dt-responsive nowrap"
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
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#customer-datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('customer.data') }}",
                    "type": "GET"
                },
                "columns": [
                    { "data": 0, "orderable": false }, // Sl
                    { "data": 1 }, // Name
                    { "data": 2 }, // Age
                    { "data": 3 }, // Sex
                    { "data": 4 }, // Phone Number
                    { "data": 5 }, // Address
                    @if ($role == '1')
                        { "data": 6 }, // Location
                        { "data": 7, "orderable": false } // Action
                    @else
                        { "data": 6, "orderable": false } // Action
                    @endif
                ],
                "language": {
                    "paginate": {
                        "previous": "<i class='mdi mdi-chevron-left'>",
                        "next": "<i class='mdi mdi-chevron-right'>"
                    }
                },
                "drawCallback": function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                }
            });
        });
    </script>
@endsection
