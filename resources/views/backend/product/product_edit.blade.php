@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Edit Product </h4><br><br>





                            <form method="post" action="{{ route('product.update') }}" id="myForm">
                                @csrf

                                <input type="hidden" name="id" value="{{ $product->id }}">

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Product Name</label>
                                    <div class=" form-group col-sm-10">
                                        <input name="name" class="form-control" value="{{ $product->name }}"
                                            type="text">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Name</label>
                                    <div class=" form-group col-sm-10">
                                        <input name="supplier_name" class="form-control" type="text" value="{{ $product->supplier_name }}">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Quantity</label>
                                    <div class=" form-group col-sm-10">
                                        <input name="quantity" class="form-control" type="number" value="{{ $product->quantity }}" >
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Reorder Level</label>
                                    <div class=" form-group col-sm-10">
                                        <input name="reorder_level" class="form-control" type="number" value="{{ $product->reorder_level }}" >
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Category</label>
                                    <div class="col-sm-10">
                                        <select name="category_id" class="form-select" aria-label="Default select example">
                                            <option selected="">Open this select menu</option>

                                            @foreach ($category as $cat)
                                                <option
                                                    value="{{ $cat->id }}"{{ $cat->id == $product->category_id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <!-- end row -->










                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Edit Product">
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
                    supplier_id: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please Enter Product Name',
                    },
                    supplier_id: {
                        required: 'Please Select Supplier',
                    },
                    category_id: {
                        required: 'Please Select Category',
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
