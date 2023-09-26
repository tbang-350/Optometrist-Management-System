@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Credit Customer Report</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">

                                <li class="breadcrumb-item active">prescription</li>
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
                                    <div class="prescription-title">

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

                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <div>
                                            <h3 class="font-size-16 card-title">
                                                <strong>Customer Prescription</strong>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row -->

                            <br>
                            <br>

                            <div class="row">
                                <div class="col-12">
                                    <div>


                                        <div class="container">
                                            <table class="table table-responsive">
                                                <tbody>
                                                    <tr>
                                                        <th colspan="2" class=" font-weight-bold">Customer Information</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Name</th>
                                                        <td>{{ $data->customer->name ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Age</th>
                                                        <td>{{ $data->customer->age ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Date</th>
                                                        <td>
                                                            <input name="date" class="form-control example-date-input" type="date" id="date"
                                                                value="{{ date('Y-m-d', strtotime($data->date)) }}" disabled>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td>{{ $data->customer->address ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sex</th>
                                                        <td>
                                                            <select name="sex" id="sex" class="form-select" aria-label="Select gender" disabled>
                                                                <option value="" selected>Select gender</option>
                                                                <option value="male" @if ($data->customer->sex == 'male') selected @endif>Male</option>
                                                                <option value="female" @if ($data->customer->sex == 'female') selected @endif>Female</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <hr>

                                            <table class="table table-responsive">
                                                <tbody>
                                                    <tr>
                                                        <th class="font-weight-bold">Refraction</th>
                                                        <th colspan="2">RE</th>
                                                        <th colspan="2">LE</th>
                                                        <th colspan="2">ADD</th>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <td colspan="2">{{ $data->RE }}</td>
                                                        <td colspan="2">{{ $data->LE }}</td>
                                                        <td colspan="2">{{ $data->ADD }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <hr>

                                            <table class="table table-responsive">
                                                <tbody>
                                                    <tr>
                                                        <th class="font-weight-bold">VA</th>
                                                        <td>{{ $data->VA }}</td>
                                                        <th class="font-weight-bold">PD</th>
                                                        <td>{{ $data->PD }}</td>
                                                        <th class="font-weight-bold">VA</th>
                                                        <td>{{ $data->VA2 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="font-weight-bold">N</th>
                                                        <td>{{ $data->N }}</td>
                                                        <th></th>
                                                        <td></td>
                                                        <th class="font-weight-bold">N</th>
                                                        <td>{{ $data->N2 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <td></td>
                                                        <th></th>
                                                        <td></td>
                                                        <th class="font-weight-bold">SIGNS</th>
                                                        <td>{{ $data->SIGNS }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <hr>

                                            <table class="table table-responsive">
                                                <tbody>
                                                    <tr>
                                                        <th class="font-weight-bold">Remarks</th>
                                                        <td colspan="5">
                                                            <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks"
                                                                disabled>{{ $data->remarks }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="font-weight-bold">Treatment Given</th>
                                                        <td colspan="5">
                                                            <textarea name="treatment_given" id="treatment_given" class="form-control"
                                                                placeholder="Treatment Given" disabled>{{ $data->treatment_given }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="font-weight-bold">Next Appointment</th>
                                                        <td colspan="5">
                                                            <input name="next_appointment" class="form-control example-date-input" type="date"
                                                                id="next_appointment"
                                                                value="{{ date('Y-m-d', strtotime($data->next_appointment)) }}" disabled>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>



                                        @php

                                            $date = new DateTime('now', new DateTimeZone('Africa/Dar_es_Salaam'));

                                        @endphp

                                        <br>

                                        <i>Printing Time : {{ $date->format('F j, Y, g:i a') }}</i>

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
                            </div> <!-- end row -->

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
