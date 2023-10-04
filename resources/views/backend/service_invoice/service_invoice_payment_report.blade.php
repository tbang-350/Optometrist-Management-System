@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Payment Options</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">







                            <!-- Payment Option Wise -->
                            <div class="show_credit">

                                <form action="{{ route('service.payment.option.report') }}" method="get" id="myForm">

                                    <div class="row">
                                        <div class="col-sm-8 form-group">
                                            <label for="payment option">Payment Options</label>

                                            <select name="payment_option" class="form-select"
                                                aria-label="Default select example">


                                                <option value="">Select Payment Option</option>
                                                <option value="cash">Cash</option>
                                                <option value="cheque">Cheque</option>
                                                <option value="insurance">Insurance</option>
                                                <option value="selcom">Selcom</option>

                                            </select>

                                        </div>

                                        <div class="col-sm-4" style="padding-top: 29px">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <!-- End Customer Credit wise Wise -->

                            <br>




                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {

                    payment_option: {
                        required: true,
                    },

                },
                messages: {

                    payment_option: {
                        required: 'Please Select Payment Option',
                    },

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>



    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm2').validate({
                rules: {

                    customer_id: {
                        required: true,
                    },

                },
                messages: {

                    customer_id: {
                        required: 'Please Select Customer',
                    },

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>


    {{-- <script type="text/javascript">
        $(document).on('change', '.search_value', function() {
            var search_value = $(this).val();
            if (search_value == 'customer_wise_credit') {
                $('.show_credit').show();
            } else {
                $('.show_credit').hide();
            }
        });

        $(document).on('change', '.search_value', function() {
            var search_value = $(this).val();
            if (search_value == 'customer_wise_paid') {
                $('.show_paid').show();
            } else {
                $('.show_paid').hide();
            }
        });
    </script> --}}
@endsection
