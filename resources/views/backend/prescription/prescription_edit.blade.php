@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Prescription </h4><br><br>



                            <form method="post" action="{{ route('prescription.store') }}" id="myForm"
                                enctype="multipart/form-data">
                                @csrf




                                <div class="row new_customer">
                                    <h6 class="card-title">Customer Information</h6>

                                    <br>
                                    <br>

                                    <input type="hidden" name="customer_id"
                                        value="{{ $prescription->customer->id ?? '' }}">


                                    <div class="form-group col-12">
                                        <label for="inputEmail4" class="form-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Enter Customer Name"
                                            value="{{ $prescription->customer->name ?? '' }}" readonly>
                                        <br>
                                    </div>

                                    <br>


                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4" class="form-label">Age</label>
                                        <input type="age" name="age" id="age" class="form-control"
                                            placeholder="Enter Customer Age"
                                            value="{{ $prescription->customer->age ?? '' }}" readonly>
                                    </div>

                                    <br>


                                    <div class="form-group col-md-6">
                                        <label for="date" class="form-label">Date</label>
                                        <input name="date" class="form-control example-date-input" type="date"
                                            id="date" value="{{ date('Y-m-d', strtotime($prescription->date)) }}" disabled>
                                    </div>


                                    <div class="form-group col-md-6">
                                        <br>
                                        <label for="inputEmail4" class="form-label">Address</label>
                                        <input type="address" name="address" id="address" class="form-control"
                                            placeholder="Enter Customer address"
                                            value="{{ $prescription->customer->address ?? '' }}" readonly>
                                    </div>

                                    <br>

                                    <div class="form-group col-md-6">
                                        <br>
                                        <label for="inputEmail4" class="form-label">Sex</label>
                                        <select name="sex" id="sex" class="form-select" aria-label="Select gender"
                                            disabled>
                                            <option value="" selected>Select gender</option>
                                            <option value="male" @if ($prescription->customer->sex == 'male') selected @endif>
                                                Male</option>
                                            <option value="female" @if ($prescription->customer->sex == 'female') selected @endif>
                                                Female</option>
                                        </select>
                                    </div>


                                </div>




                                <br>



                                <fieldset class="row">

                                    {{-- <legend class="col-form-label col-md-1">Refraction</legend> --}}

                                <label for="inputEmail4" class="form-label">Refraction</label>

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <input type="text" name="RE" id="RE" class="form-control"
                                            placeholder="RE" value="{{ $prescription->RE }}">
                                    </div>

                                    <br>

                                    <div class="form-group">

                                        <input type="text" name="LE" id="LE" class="form-control"
                                            placeholder="LE" value="{{ $prescription->LE }}">
                                    </div>

                                    <br>

                                    <div class="form-group">

                                        <input type="text" name="ADD" id="ADD" class="form-control"
                                            placeholder="ADD" value="{{ $prescription->ADD }}" >
                                    </div>



                                </div>
                                </fieldset>

                                <hr>

                                <div class="row">

                                    <div class="form-group col-md-4">

                                        <input type="text" name="VA" id="VA" class="form-control"
                                            placeholder="VA" value="{{ $prescription->VA }}">
                                    </div>


                                    <div class="form-group col-md-4">

                                        <input type="text" name="PD" id="PD" class="form-control"
                                            placeholder="PD" value="{{ $prescription->PD }}">
                                    </div>


                                    <div class="form-group col-md-4">

                                        <input type="text" name="VA2" id="VA2" class="form-control"
                                            placeholder="VA" value="{{ $prescription->VA2 }}">
                                    </div>

                                </div>

                                <br>

                                <div class="row">

                                    <div class="form-group col-md-4">
                                        <input type="text" name="N" id="VA" class="form-control"
                                            placeholder="N" value="{{ $prescription->N }}">
                                    </div>

                                    <div class="form-group col-md-4"
                                        style="visibility: hidden; background-color:transparent">
                                        <input type="text" name="empty" class="form-control">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <input type="text" name="N2" id="N2" class="form-control"
                                            placeholder="N" value="{{ $prescription->N2 }}">
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
                                            placeholder="PD" value="{{ $prescription->PD }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <input type="text" name="SIGNS" id="SIGNS" class="form-control"
                                            placeholder="SIGNS" value="{{ $prescription->SIGNS }}">
                                    </div>

                                </div>

                                <hr>

                                <div class="form-group col-12">

                                    <textarea name="remarks" id="remarks" class="form-control"  placeholder="Remarks">
                                        {{ $prescription->remarks }}
                                    </textarea>


                                </div>

                                <br>

                                <div class="form-group col-12">

                                    <textarea name="treatment_given" id="treatment_given" class="form-control" placeholder="Treatment Given">
                                        {{ $prescription->treatment_given }}
                                    </textarea>

                                </div>

                                <br>


                                <div class="form-group col-md-6">
                                    <label for="date" class="form-label">Next Appointment</label>
                                    <input name="next_appointment" class="form-control example-date-input" type="date"
                                        id="next_appointment" value="{{ date('Y-m-d', strtotime($prescription->next_appointment)) }}" >

                                </div>

                                <br>

                                <input type="submit" class="btn btn-info waves-effect waves-light"
                                    value="Edit Prescription">
                            </form>


                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

        </div>
    </div>


    </div>
    </div>
    </div> <!-- end col -->
    </div>


    </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            // $('#myForm').validate({
            //     rules: {
            //         RE: {
            //             required: true,
            //         },
            //         LE: {
            //             required: true,
            //         },
            //         ADD: {
            //             required: true,
            //         },
            //         VA: {
            //             required: true,
            //         },
            //         PD: {
            //             required: true,
            //         },
            //         VA2: {
            //             required: true,
            //         },
            //         N: {
            //             required: true,
            //         },
            //         N2: {
            //             required: true,
            //         },
            //         SIGNS: {
            //             required: true,
            //         },
            //         remarks : {
            //             required: true
            //         },
            //         treatment_given : {
            //             required: true
            //         },
            //         next_appointment : {
            //             required: true
            //         }



            //     },

            //     messages: {
            //         RE: {
            //             required: "Enter RE",
            //         },
            //         LE: {
            //             required: "Enter LE",
            //         },
            //         ADD: {
            //             required: "Enter ADD",
            //         },
            //         VA: {
            //             required: "Enter VA",
            //         },
            //         PD: {
            //             required: "Enter PD",
            //         },
            //         VA2: {
            //             required: "Enter VA2",
            //         },
            //         N: {
            //             required: "Enter N",
            //         },
            //         N2: {
            //             required: "Enter N2",
            //         },
            //         SIGNS: {
            //             required: "Enter SIGNS",
            //         },
            //         remarks : {
            //             required: "Remarks required"
            //         },
            //         treatment_given : {
            //             required: "Treatment given required"
            //         },
            //         next_appointment : {
            //             required: "Next appointment date required"
            //         }



            //     },

            //     errorElement: 'span',
            //     errorPlacement: function(error, element) {
            //         error.addClass('invalid-feedback');
            //         element.closest('.form-group').append(error);
            //     },
            //     highlight: function(element, errorClass, validClass) {
            //         $(element).addClass('is-invalid');
            //     },
            //     unhighlight: function(element, errorClass, validClass) {
            //         $(element).removeClass('is-invalid');
            //     },
            // });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    <script type="text/javascript">
        $(document).on('change', '#paid_status', function() {
            var paid_status = $(this).val();
            if (paid_status == 'partial_paid') {
                $('.paid_amount').show();
            } else {
                $('.paid_amount').hide();
            }
        });

        $(document).on('change', '#customer_id', function() {
            var customer_id = $(this).val();
            if (customer_id == '0') {
                $('.new_customer').show();
            } else {
                $('.new_customer').hide();
            }
        });

        // $(document).ready(function() {
        //     // Add an event listener to the payment option dropdown
        //     $('#payment_option').change(function() {
        //         var selectedOption = $(this).val();
        //         var paidStatusField = $('#paid_status');

        //         // Show the paid status field only if a payment option is selected
        //         if (selectedOption !== '') {
        //             paidStatusField.show();
        //         } else {
        //             paidStatusField.hide();
        //         }
        //     });
        // });

        $(document).on('change', '#payment_option', function() {
            var payment_option = $(this).val();
            if (payment_option !== '') {
                $('.paid_status').show();
            } else {
                $('.paid_status').hide();
            }
        });
    </script>
@endsection
