@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Edit Company Detail </h4>

                            <form method="post" action="{{ route('store.company.detail') }}" id="myForm">
                                @csrf

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Company Name</label>
                                    <div class="col-sm-10">
                                        <input name="company_name" class="form-control" type="text"
                                            value="{{ $company->company_name }}" id="example-text-input">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Company Email</label>
                                    <div class="col-sm-10">
                                        <input name="company_email" class="form-control" type="text"
                                            value="{{ $company->company_email }}" id="example-text-input">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Company Address</label>
                                    <div class="col-sm-10">
                                        <input name="company_address" class="form-control" type="text"
                                            value="{{ $company->company_address }}" id="example-text-input">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Company Phone</label>
                                    <div class="col-sm-10">
                                        <input name="company_phone" class="form-control" type="text"
                                            value="{{ $company->company_phone }}" id="example-text-input">
                                    </div>
                                </div>
                                <!-- end row -->
                                

                                
                                <!-- end row -->
                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Company Details">
                            </form>



                        </div>
                    </div>
                </div> <!-- end col -->
            </div>



        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    company_name: {
                        required: true,
                    },
                    company_email: {
                        required: true,
                        email: true, // add email validation rule
                    },
                    company_address: {
                        required: true,
                    },
                    company_phone: {
                        required: true, 
                    },

                },
                messages: {
                    company_name: {
                        required: 'Please Enter Company Name',
                    },
                    company_email: {
                        required: 'Please Enter Company Email',
                        email: 'Please enter a valid email address.', // add email validation message
                    },
                    company_address: {
                        required: 'Please Enter Company Address',
                    },
                    Company_phone: {
                        required: 'Please Enter Company Phone',
                    },
                    
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-control').append(error);
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
