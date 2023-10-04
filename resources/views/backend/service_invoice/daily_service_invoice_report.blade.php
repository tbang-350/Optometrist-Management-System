@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Daily Prescription Report</h4><br><br>

                            <form action="{{ route('daily.service.invoice.pdf') }}" method="get" id="myForm">

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="md-3">
                                            <label for="example-text-input" class="form-label">Start Date</label>
                                            <div class=" form-group col-sm-10">
                                                <input name="start_date" class="form-control example-date-input" type="date"
                                                    id="start_date" placeholder="YY-MM-DD">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="md-3">
                                            <label for="example-text-input" class="form-label">End Date</label>
                                            <div class=" form-group col-sm-10">
                                                <input name="end_date" class="form-control example-date-input" type="date"
                                                    id="end_date" placeholder="YY-MM-DD">
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="md-3">
                                            <label for="example-text-input" class="form-label" style="margin-top: 13px"> </label>
                                            <div class=" form-group col-sm-10">
                                                <button type="submit" class="btn btn-info">Search</button>
                                            </div>
                                        </div>
                                    </div>


                                </div> <!-- end row -->

                            </form>



                        </div>
                        <!--end cardbody -->

                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div>

    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    start_date: {
                        required: true,
                    },
                    end_date: {
                        required: true,
                    },

                },
                messages: {
                    start_date: {
                        required: 'Start Date is required',
                    },
                    end_date: {
                        required: 'End Date is required',
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



@endsection
