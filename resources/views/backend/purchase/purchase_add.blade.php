@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Purchase </h4><br><br>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Date</label>
                                        <div class=" form-group col-sm-10">
                                            <input name="date" class="form-control example-date-input" type="date"
                                                id="date">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Purchase No</label>
                                        <div class=" form-group col-sm-10">
                                            <input name="purchase_no" class="form-control example-date-input" type="text"
                                                id="purchase_no" value="{{ $purchase_no }}" readonly
                                                style="background-color: #ddd">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Supplier Name</label>
                                        <div class=" form-group col-sm-10">
                                            <select name="supplier_id" id="supplier_id" class="form-select select2"
                                                aria-label="Default select example">
                                                <option selected="">Open this select menu</option>

                                                @foreach ($supplier as $supp)
                                                    <option value="{{ $supp->id }}">{{ $supp->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Category</label>
                                        <div class=" form-group col-sm-10">
                                            <select name="category_id" id="category_id" class="form-select select2"
                                                aria-label="Default select example">
                                                <option selected="">Open this select menu</option>



                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Product</label>
                                        <div class=" form-group col-sm-10">
                                            <select name="product_id" id="product_id" class="form-select select2"
                                                aria-label="Default select example">
                                                <option selected="">Open this select menu</option>



                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label" style="margin-top: 43px">
                                        </label>


                                        <i
                                            class="btn btn-secondary btn-rounded waves-effect waves-light fas fa-plus-circle addeventmore">
                                            Add
                                        </i>
                                    </div>
                                </div>


                            </div> <!-- end row -->



                        </div>
                        <!--end cardbody -->


                        <div class="card-body">

                            <form action="{{ route('purchase.store') }}" method="post">

                                @csrf

                                <table class="table-sm table-bordered" width="100%" style="border-color: #ddd">


                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Product Name</th>
                                            <th>Unit(s)</th>
                                            <th>Unit Price</th>
                                            <th>Description</th>
                                            <th>Total Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="addRow" class="addRow">

                                    </tbody>

                                    <tbody>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td>
                                                <input type="text" name="estimated_amount" value="0"
                                                    id="estimated_amount" class="form-control estimated_amount" readonly
                                                    style="background-color: #ddd">
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>

                                </table>

                                <br>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-info" id="storeButton">Purchase Store</button>
                                </div>

                            </form>

                        </div>


                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div>

    </div>






    <<script type="text/x-handlebars-template" id="document-template">
        <tr class="delete_add_more_item" id="delete_add_more_item">
            <input type="hidden" name="date[]" value="@{{date}}">
            <input type="hidden" name="purchase_no[]" value="@{{purchase_no}}">
            <input type="hidden" name="supplier_id[]" value="@{{supplier_id}}">
            <td>
                <input type="hidden" name="category_id[]" value="@{{category_id}}">
                @{{category_name}}
            </td>
            <td>
                <input type="hidden" name="product_id[]" value="@{{product_id}}">
                @{{product_name}}
            </td>
            <td>
                <input type="number" min="1" class="form-control buying_qty text-right" id="buying_qty" name="buying_qty[]" value="">
            </td>
            <td>
                <input type="number" class="form-control unit_price text-right" id="unit_price" name="unit_price[]" value="">
            </td>
            <td>
                <input type="text" class="form-control" name="description[]" value="">
            </td>
            <td>
                <input type="number" class="form-control buying_price text-right" id="buying_price" name="buying_price[]" value="0" readonly>
            </td>
            <td>
                <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i>
            </td>
        </tr>
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click","#storeButton" , function() {
                var buying_price = $('#buying_price').val();
                var buying_qty = $('#selling_qty').val();
                var unit_price = $('#unit_price').val();


                if (selling_qty == '') {
                    $.notify("Selling quantity not set", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }

                if (unit_price == '') {
                    $.notify("Unit Price not set", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }

                if (buying_price == '') {
                    $.notify("Buying Price not set", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }



            });
        });
    </script>



    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click", ".addeventmore", function() {

                var date = $('#date').val();
                var purchase_no = $('#purchase_no').val();
                var supplier_id = $('#supplier_id').val();
                var category_id = $('#category_id').val();
                var category_name = $('#category_id').find('option:selected').text();
                var product_id = $('#product_id').val();
                var product_name = $('#product_id').find('option:selected').text();

                if (date == '') {
                    $.notify("Date not set", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }

                if (purchase_no == '') {
                    $.notify("Purchase_no  not set", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }

                if (supplier_id == '') {
                    $.notify("Supplier not set", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }

                if (category_id == '') {
                    $.notify("Category not set", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }

                if (product_id == '') {
                    $.notify("Product not set", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }

                var source = $("#document-template").html();
                var template = Handlebars.compile(source);

                var data = {
                    date: date,
                    purchase_no: purchase_no,
                    supplier_id: supplier_id,
                    category_id: category_id,
                    category_name: category_name,
                    product_id: product_id,
                    product_name: product_name,
                };

                var html = template(data);
                $("#addRow").append(html);

            });

            $(document).on("click", ".removeeventmore", function(event) {
                $(this).closest(".delete_add_more_item").remove();
                totalAmountPrice();
            })

            // dynamically change buying_price on change of buying_qty and unit_price
            $(document).on('keyup click', '.unit_price,.buying_price', function() {
                var unit_price = $(this).closest("tr").find("input.unit_price").val();
                var qty = $(this).closest("tr").find("input.buying_qty").val();
                var total = unit_price * qty;
                $(this).closest("tr").find("input.buying_price").val(total);
                totalAmountPrice();
            });

            //Written by AI , Chatgpt to be specific
            // $(document).on('keyup click', '.buying_qty,.unit_price', function() {
            //     var row = $(this).closest('tr');
            //     var buying_qty = row.find('.buying_qty').val();
            //     var unit_price = row.find('.unit_price').val();
            //     var buying_price = (buying_qty * unit_price).toFixed(2);
            //     row.find('.buying_price').val(buying_price);
            // });


            function totalAmountPrice() {
                var sum = 0;

                $(".buying_price").each(function() {
                    var value = $(this).val();
                    if (!isNaN(value) && value.length != 0) {
                        sum += parseFloat(value);
                    }
                });
                $('#estimated_amount').val(sum);
            }


        });
    </script>





    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#supplier_id', function() {
                var supplier_id = $(this).val();
                $.ajax({
                    url: "{{ route('get-category') }}",
                    type: "GET",
                    data: {
                        supplier_id: supplier_id
                    },
                    success: function(data) {
                        var html = '<option value="">Select Category</option>';
                        $.each(data, function(key, v) {
                            html += '<option value=" ' + v.category_id + ' "> ' + v
                                .category.name + '</option>';
                        });
                        $('#category_id').html(html);
                    }
                })
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#category_id', function() {
                var category_id = $(this).val();
                $.ajax({
                    url: "{{ route('get-product') }}",
                    type: "GET",
                    data: {
                        category_id: category_id
                    },
                    success: function(data) {
                        var html = '<option value="">Select Product</option>';
                        $.each(data, function(key, v) {
                            html += '<option value=" ' + v.id + ' "> ' + v.name +
                                '</option>';
                        });
                        $('#product_id').html(html);
                    }
                })
            });
        });
    </script>

@endsection
