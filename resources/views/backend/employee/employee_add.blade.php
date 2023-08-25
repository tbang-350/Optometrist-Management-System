@extends('admin.admin_master')
@section('admin')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add New Employee </h4><br><br>





                            <form method="post" action="{{ route('employee.store') }}" id="myForm"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Employee Name</label>
                                    <div class=" form-group col-sm-10">
                                        <input name="name" class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                                    <div class="form-group col-sm-10">
                                        <input name="email" class="form-control" type="Email">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">User Name</label>
                                    <div class=" form-group col-sm-10">
                                        <input name="username" class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Role</label>
                                    <div class=" form-group col-sm-10">
                                        <select name="role" class="form-select" aria-label="Default select example">
                                            <option selected="">Select a role</option>


                                            <option value="2">Receptionist</option>
                                            <option value="3">Doctor</option>

                                        </select>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Location</label>
                                    <div class="form-group col-sm-10">
                                        <select name="location_id" class="form-select" aria-label="Default select example">
                                            <option value="" selected>Select a location</option>
                                
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Password</label>
                                    <div class=" form-group col-sm-10">
                                        <input name="password" id="password" class="form-control" type="text" required>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class=" form-group col-sm-10">
                                        <input name="password_confirmation" id="password_confirmation" class="form-control"
                                            type="text" required>
                                    </div>
                                </div>
                                <!-- end row -->



                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Employee">
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
                        minlength: 8, // add minlength validation rule
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
                        minlength: 'Password must be at least 8 characters long', // add minlength validation message
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
@endsection
