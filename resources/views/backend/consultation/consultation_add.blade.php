@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Consultation </h4><br><br>


                            <form method="post" action="{{ route('consultation.store') }}" id="myForm"
                                  enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3">
                                    <label>Customer Name</label>
                                    <div class=" form-group col-sm-4">
                                        <select name="customer_id" id="customer_id" class="form-control">
                                            <option value="">Select Customer</option>

                                            @foreach ($customer as $cust)
                                                <option value="{{ $cust->id }}">
                                                    {{ $cust->name }}
                                                </option>
                                            @endforeach

                                            <option value="0">New Customer</option>

                                        </select>
                                    </div>
                                </div>

                                {{-- Hidden New Customer Form --}}
                                <div class="row new_customer" style="display: none">

                                    <h6 class="card-title">Add New Customer</h6>

                                    <div class="form-group col-md-3">
                                        <input type="text" name="name" id="name" class="form-control"
                                               placeholder="Enter Customer Name">
                                    </div>

                                    <br>

                                    <div class="form-group col-md-3">
                                        <input type="address" name="address" id="address" class="form-control"
                                               placeholder="Enter Customer address">
                                    </div>

                                    <br>

                                    <div class="form-group col-md-3">
                                        <input type="age" name="age" id="age" class="form-control"
                                               placeholder="Enter Customer Age">
                                    </div>

                                    <br>

                                    <div class="form-group col-md-3 ">

                                        <select name="sex" class="form-select" aria-label="Default select example">
                                            <option value="" selected="">Select gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>

                                    </div>

                                    <br>

                                </div>

                                {{-- Hidden New Customer Form --}}

                                <div class="row mb-3">
                                    <div class=" form-group col-sm-6">
                                        <label for="example-text-input" class="col-sm-6 col-form-label">Consultation
                                            Fee</label>
                                        <div class=" form-group col-sm-10">
                                            <input name="consultation_fee" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Consultation">
                            </form>


                        </div>
                    </div>
                </div> <!-- end col -->
            </div>


        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#myForm').validate({
                rules: {
                    customer_id: {
                        required: true,
                    },
                    consultation_fee: {
                        required: true
                    },
                    name: {
                        required: true
                    },
                    age: {
                        required: true
                    },
                    sex: {
                        required: true
                    },
                    address: {
                        required: true
                    }

                },
                messages: {
                    customer_id: {
                        required: 'Please Select Customer',
                    },
                    consultation_fee: {
                        required: 'Please Enter Consultation Fee'
                    },
                    name: {
                        required: 'Please Enter Customer Name'
                    },
                    age: {
                        required: 'Please Enter Customer Age'
                    },
                    sex: {
                        required: 'Please Enter Customer Gender'
                    },
                    address: {
                        required: 'Please Enter Customer Address'
                    }

                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#image').change(function (e) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    <script type="text/javascript">
        $(document).on('change', '#paid_status', function () {
            var paid_status = $(this).val();
            if (paid_status == 'partial_paid') {
                $('.paid_amount').show();
            } else {
                $('.paid_amount').hide();
            }
        });

        $(document).on('change', '#customer_id', function () {
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

        $(document).on('change', '#payment_option', function () {
            var payment_option = $(this).val();
            if (payment_option !== '') {
                $('.paid_status').show();
            } else {
                $('.paid_status').hide();
            }
        });
    </script>
@endsection
