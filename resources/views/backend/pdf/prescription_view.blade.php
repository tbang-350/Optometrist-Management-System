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

                            {{-- @php

                                $company_info = App\Models\Company::first();

                            @endphp --}}

                            <div class="row">
                                <div class="col-12">
                                    {{-- <div class="prescription-title">

                                        <h3>
                                            <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo"
                                                height="24" /> {{ $company_info->company_name }}
                                        </h3>
                                    </div> --}}
                                    <hr>



                                    {{-- <div class="row">
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
                                    </div> --}}
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


                                        <div class="row">

                                            <div class="row new_customer">
                                                <h6 class="card-title">Customer Information</h6>

                                                <br>
                                                <br>




                                                <div class="form-group col-12">
                                                    <label for="inputEmail4" class="form-label">Name</label>
                                                    <input type="text" name="name" id="name" class="form-control"
                                                        placeholder="Enter Customer Name"
                                                        value="{{ $data->customer->name ?? '' }}" readonly>
                                                    <br>
                                                </div>

                                                <br>


                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4" class="form-label">Age</label>
                                                    <input type="age" name="age" id="age" class="form-control"
                                                        placeholder="Enter Customer Age"
                                                        value="{{ $data->customer->age ?? '' }}" readonly>
                                                </div>

                                                <br>


                                                <div class="form-group col-md-6">
                                                    <label for="date" class="form-label">Date</label>
                                                    <input name="date" class="form-control example-date-input"
                                                        type="date" id="date"
                                                        value="{{ date('Y-m-d', strtotime($data->date)) }}" disabled>
                                                </div>



                                                <div class="form-group col-md-6">
                                                    <br>
                                                    <label for="inputEmail4" class="form-label">Address</label>
                                                    <input type="address" name="address" id="address" class="form-control"
                                                        placeholder="Enter Customer address"
                                                        value="{{ $data->customer->address ?? '' }}" readonly>
                                                </div>

                                                <br>

                                                <div class="form-group col-md-6">
                                                    <br>
                                                    <label for="inputEmail4" class="form-label">Sex</label>
                                                    <select name="sex" id="sex" class="form-select"
                                                        aria-label="Select gender" disabled>
                                                        <option value="" selected>Select gender</option>
                                                        <option value="male"
                                                            @if ($data->customer->sex == 'male') selected @endif>
                                                            Male</option>
                                                        <option value="female"
                                                            @if ($data->customer->sex == 'female') selected @endif>
                                                            Female</option>
                                                    </select>
                                                </div>


                                            </div>


                                        </div>

                                        <hr>

                                        <fieldset class="row">

                                            {{-- <legend class="col-form-label col-md-1">Refraction</legend> --}}

                                            <label for="inputEmail4" class="form-label">Refraction</label>

                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" name="RE" id="address" class="form-control"
                                                        placeholder="RE" value="{{ $data->RE }}" readonly>
                                                </div>

                                                <br>

                                                <div class="form-group">

                                                    <input type="text" name="LE" id="LE" class="form-control"
                                                        placeholder="LE" value="{{ $data->LE }}" readonly>
                                                </div>

                                                <br>

                                                <div class="form-group">

                                                    <input type="text" name="ADD" id="ADD" class="form-control"
                                                        placeholder="ADD" value="{{ $data->ADD }}" readonly>
                                                </div>

                                            </div>

                                        </fieldset>

                                        <hr>

                                        <div class="row">

                                            <div class="form-group col-md-4">

                                                <input type="text" name="VA" id="VA" class="form-control"
                                                    placeholder="VA" value="{{ $data->VA }}" readonly >
                                            </div>


                                            <div class="form-group col-md-4">

                                                <input type="text" name="PD" id="PD" class="form-control"
                                                    placeholder="PD" value="{{ $data->PD }}" readonly >
                                            </div>


                                            <div class="form-group col-md-4">

                                                <input type="text" name="VA2" id="VA2" class="form-control"
                                                    placeholder="VA" value="{{ $data->VA2 }}" readonly >
                                            </div>

                                        </div>

                                        <br>

                                        <div class="row">

                                            <div class="form-group col-md-4">
                                                <input type="text" name="N" id="VA" class="form-control"
                                                    placeholder="N" value="{{ $data->N }}" readonly >
                                            </div>

                                            <div class="form-group col-md-4"
                                                style="visibility: hidden; background-color:transparent">
                                                <input type="text" name="empty" class="form-control">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <input type="text" name="N2" id="N2" class="form-control"
                                                    placeholder="N" value="{{ $data->N2 }}" readonly >
                                            </div>

                                        </div>

                                        <br>

                                        <div class="row">

                                            <div class="form-group col-md-4"
                                                style="visibility: hidden; background-color:transparent">
                                                <input type="text" name="empty" class="form-control">
                                            </div>

                                            <div class="form-group col-md-4"
                                                style="visibility: hidden; background-color:transparent">
                                                <input type="text" name="empty" id="PD" class="form-control"
                                                    placeholder="PD">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <input type="text" name="SIGNS" id="SIGNS" class="form-control"
                                                    placeholder="SIGNS" value="{{ $data->SIGNS }}" readonly >
                                            </div>

                                        </div>

                                        <hr>

                                        <div class="form-group col-12">
                                            <label for="date" class="form-label">Remarks</label>
                                            <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks" disabled>
                                                {{ $data->remarks }}
                                            </textarea>


                                        </div>

                                        <br>

                                        <div class="form-group col-12">
                                            <label for="date" class="form-label">Treatement Given</label>
                                            <textarea name="treatment_given" id="treatment_given" class="form-control" placeholder="Treatment Given" disabled >
                                                {{ $data->treatment_given }}
                                            </textarea>

                                        </div>

                                        <br>


                                        <div class="form-group col-md-6">
                                            <label for="date" class="form-label">Next Appointment</label>
                                            <input name="next_appointment" class="form-control example-date-input"
                                                type="date" id="next_appointment" value="{{ date('Y-m-d', strtotime($data->next_appointment)) }}" >

                                        </div>

                                        @php

                                            $date = new DateTime('now', new DateTimeZone('Africa/Dar_es_Salaam'));

                                        @endphp

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
