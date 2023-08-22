@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Edit Employee </h4><br><br>




                            <form method="post" action="{{ route('employee.update') }}" id="myForm">
                                @csrf

                                <input type="hidden" name="id" value="{{ $user->id }}">

                                <input type="hidden" name="status" id="status_hidden" value="{{ $user->status ? 1 : 0 }}">


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Employee Name</label>
                                    <div class=" form-group col-sm-10">
                                        <input name="name" class="form-control" type="text"
                                            value="{{ $user->name }}">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                                    <div class="form-group col-sm-10">
                                        <input name="email" class="form-control" type="Email"
                                            value="{{ $user->email }}">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">UserName</label>
                                    <div class=" form-group col-sm-10">
                                        <input name="username" class="form-control" type="text"
                                            value="{{ $user->username }}">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Status</label>
                                    <div class="form-group col-sm-10" style="border: 1px">
                                        <div class="form-group">

                                            <input type="checkbox" name="status" id="status_toggle" data-toggle="toggle"
                                                data-on="Active" data-off="Inactive" {{ $user->status ? 'checked' : '' }}>

                                        </div>

                                    </div>

                                </div>




                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Edit Employee">
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
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true, // add email validation rule
                    },
                    username: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },

                },
                messages: {
                    name: {
                        required: 'Please Enter Employee Name',
                    },
                    email: {
                        required: 'Please Enter Email',
                        email: 'Please enter a valid email address.', // add email validation message
                    },
                    username: {
                        required: 'Please Enter Username',
                    },
                    password: {
                        required: 'Please Enter Password',
                    },
                    password_confirmation: {
                        required: 'Please Enter Confirmation Password',
                        equalTo: 'Passwords do not match'
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
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    {{-- ? Ai wrote this --}}}
    <script>
        $(function() {
            $('#status_toggle').change(function() {
                var value = $(this).prop('checked') ? 1 : 0;
                $('#status_hidden').val(value);
            });
        });
    </script>

@endsection
