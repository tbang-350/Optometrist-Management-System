@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add New Customer </h4><br><br>





                            <form method="post" action="{{ route('customer.store') }}" id="myForm" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Customer Name</label>
                                    <div class=" form-group col-sm-10">
                                        <input name="name" class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Age</label>
                                    <div class="form-group col-sm-10">
                                        <input name="age" class="form-control" type="number">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Sex</label>
                                    <div class=" form-group col-sm-10">
                                        <select name="sex" class="form-select" aria-label="Default select example">
                                            <option value="" selected="">Select gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- end row -->



                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Address</label>
                                    <div class=" form-group col-sm-10">
                                        <input name="address" class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Phone Number</label>
                                    <div class=" form-group col-sm-10">
                                        <input name="phonenumber" class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->

                            

                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Customer">
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
                    age: {
                        required: true,
                    },
                    sex: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    phonenumber: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please Enter Customer Name',
                    },
                    age: {
                        required: 'Please Enter Customer Age',
                    },
                    sex: {
                        required: 'Please Enter Customer Gender',
                    },
                    address: {
                        required: 'Please Enter Customer Address',
                    },
                    phonenumber: {
                        required: 'Please Enter Customer Phone number',
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
@endsection
