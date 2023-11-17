@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Invoice </h4><br><br>



                            <div class="row">


                                <div class="col-md-1">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Inv No</label>
                                        <div class=" form-group col-sm-10">
                                            <input name="invoice_no" class="form-control example-date-input" type="text"
                                                id="invoice_no" value="{{ $invoice_no }}" readonly
                                                style="background-color: #ddd">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-2">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Date</label>
                                        <div class=" form-group col-sm-10">
                                            <input name="date" class="form-control example-date-input" type="date"
                                                id="date" value={{ $date }}>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Category</label>
                                        <div class=" form-group col-sm-10">
                                            <select name="category_id" id="category_id" class="form-select select2"
                                                aria-label="Default select example">
                                                <option selected="">Open this select menu</option>

                                                @foreach ($category as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
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


                                <div class="col-md-1">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Stock(Pcs/KG)</label>
                                        <div class=" form-group col-sm-10">
                                            <input name="current_stock_qty" class="form-control example-date-input"
                                                type="text" id="current_stock_qty" readonly
                                                style="background-color: #ddd">
                                        </div>
                                    </div>
                                </div>

                                <div style="display: none">
                                    <div>
                                        <label for="example-text-input" class="form-label">Buying Unit Price</label>
                                        <div class=" form-group col-sm-10">
                                            <input name="buying_unit_price" class="form-control example-date-input"
                                                type="text" id="buying_unit_price" readonly
                                                style="background-color: #ddd">
                                        </div>
                                    </div>
                                </div>




                                <div class="col-md-2">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label" style="margin-top: 43px">
                                        </label>


                                        <i class="btn btn-secondary btn-rounded waves-effect waves-light fas fa-plus-circle addeventmore"
                                            id="addeventmore">
                                            Add More
                                        </i>
                                    </div>
                                </div>


                            </div> <!-- end row -->



                        </div>
                        <!--end cardbody -->


                        <div class="card-body">

                            <form action="{{ route('invoice.store') }}" method="post" id="myForm">

                                @csrf

                                <table class="table-sm table-bordered" width="100%" style="border-color: #ddd">


                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Product Name</th>
                                            <th width="7%">Unit(s)</th>
                                            <th width="10%">Unit Price</th>
                                            {{-- <th width="10%">Buying Unit Price</th> --}}
                                            <th width="15%">Total Price</th>
                                            <th width="7%">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="addRow" class="addRow">

                                    </tbody>

                                    <tbody>

                                        <tr>
                                            <td colspan="4">Discount</td>
                                            <td>
                                                <input type="text" name="discount_amount" id="discount_amount"
                                                    class="form-control estimated_amount" placeholder="Discount Amount">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="4">Grand Total</td>
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


                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <textarea name="description" id="description" class="form-control" placeholder="Write description here..."></textarea>
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="payment status">Payment Options</label>
                                        <select name="payment_option" id="payment_option" class="form-select">

                                            <option value="">Select Payment Option</option>
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="insurance">Insurance</option>
                                            <option value="selcom">Selcom</option>
                                        </select>

                                        <br>

                                        <div class="form-group" style="display: none">
                                            <label for="payment status">Payment Status</label>
                                            <select name="paid_status" id="paid_status" class="form-select">

                                                <option value="">Select Payment Status</option>
                                                <option value="full_paid">Fully Paid</option>
                                                <option value="partial_paid">Partially Paid</option>

                                            </select>

                                            <br>

                                            <input type="text" name="paid_amount" id="paid_amount"
                                                class="form-control paid_amount" placeholder="Enter Paid Amount..."
                                                style="display: none">



                                        </div>

                                        <br>

                                    </div>


                                    <div class="form-group col-md-9">
                                        <label>Customer Name</label>
                                        <select name="customer_id" id="customer_id" class="form-select">
                                            <option value="">Select Customer</option>

                                            @foreach ($customer as $cust)
                                                <option value="{{ $cust->id }}">
                                                    {{ $cust->name }}-{{ $cust->phonenumber }}</option>
                                            @endforeach

                                            <option value="0">New Customer</option>

                                        </select>
                                    </div>

                                </div> <!-- end row -->

                                {{-- Hidden New Customer Form --}}
                                <div class="row new_customer" style="display: none">

                                    <h6 class="card-title">Add New Customer</h6>

                                    <div class="row">



                                        <div class="form-group col-md-4">
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="Enter Customer Name">
                                        </div>



                                        <div class="form-group col-md-4">
                                            <input type="address" name="address" id="address" class="form-control"
                                                placeholder="Enter Customer address">
                                        </div>



                                        <div class="form-group col-md-4">
                                            <input type="age" name="age" id="age" class="form-control"
                                                placeholder="Enter Customer Age">
                                        </div>


                                    </div>


                                    <hr>


                                    <div class="row">

                                        <div class="form-group col-md-4 ">

                                            <select name="sex" class="form-select"
                                                aria-label="Default select example">
                                                <option value="" selected="">Select gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>

                                        </div>



                                        <div class="form-group col-md-3">
                                            <input type="text" name="phonenumber" id="phonenumber"
                                                class="form-control" placeholder="Enter Customer Phonenumber">
                                        </div>

                                    </div>



                                </div>
                                {{-- Hidden New Customer Form --}}

                                <br>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-info" id="storeButton">Save Invoice</button>
                                </div>

                            </form>

                        </div>


                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div>

    </div>






    <script type="text/x-handlebars-template" id="document-template">
        <tr class="delete_add_more_item" id="delete_add_more_item">
            <input type="hidden" name="date" value="@{{date}}">
            <input type="hidden" name="invoice_no" value="@{{invoice_no}}">

            <td>
                <input type="hidden" name="category_id[]" value="@{{category_id}}">
                @{{category_name}}
            </td>

            <td>
                <input type="hidden" name="product_id[]" value="@{{product_id}}">
                @{{product_name}}
            </td>

            <td>
                <input type="number" min="1" class="form-control selling_qty text-right" id="selling_qty" name="selling_qty[]" value="">
            </td>

            <td>
                <input type="number" class="form-control unit_price text-right" name="unit_price[]" id="unit_price" value="@{{buying_unit_price}}" readonly>
            </td>

            <!--
            <td>
                <input type="number" class="form-control buying_unit_price text-right" name="buying_unit_price" id="buying_unit_price" value="@{{buying_unit_price}}" readonly>
            </td>
            -->

            <td>
                <input type="number" class="form-control selling_price text-right" id="selling_price[]" name="selling_price[]" value="0" readonly>
            </td>

            <!--
             <td>
                <input type="number" class="form-control selling_price text-right" name="profit_loss" id="profit_loss" value="0" readonly>
            </td>
            -->

            <td>
                <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i>
            </td>

        </tr>
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#payment_option').change(function() {
                var selectedOption = $(this).val();
                var paidStatusField = $('#paid_status');

                if (selectedOption !== '') {
                    paidStatusField.closest('.form-group').show();
                } else {
                    paidStatusField.closest('.form-group').hide();
                }
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click", "#storeButton", function() {
                var buying_unit_price = $('#buying_unit_price').val();
                var selling_qty = $('#selling_qty').val();
                var unit_price = $('#unit_price').val();
                var selling_price = $('#selling_price').val();
                var customer_id = $('#customer_id').val();
                var paid_status = $('#paid_status').find('option:selected').text();
                var paid_amount = $('#paid_amount').val();

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

                if (selling_price == '') {
                    $.notify("Selling Price not set", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }

                if (customer_id == '') {
                    $.notify("Customer not set", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }

                if (paid_status == 'Select Payment Status') {
                    $.notify("Select a payment status", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }

                if (paid_status == 'Partially Paid' && paid_amount == '') {
                    $.notify("Enter paid amount for partial payment", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }

                // Check if selling_qty is larger than current_stock_qty
                if (parseFloat(selling_qty) > parseFloat(current_stock_qty)) {
                    $.notify("Stock is not enough to meet the order", {
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
                var invoice_no = $('#invoice_no').val();
                var category_id = $('#category_id').val();
                var category_name = $('#category_id').find('option:selected').text();
                var product_id = $('#product_id').val();
                var product_name = $('#product_id').find('option:selected').text();
                var buying_unit_price = $('#buying_unit_price').val();
                var selling_qty = $('#selling_qty').val(); // Get the selling_qty
                var current_stock_qty = $('#current_stock_qty').val(); // Get the current_stock_qty


                if (date == '') {
                    $.notify("Date not set", {
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

                if (product_name == '') {
                    $.notify("Product not set", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }

                // if (selling_qty === '') {
                //     $.notify("Selling quantity not set", {
                //         globalPosition: 'top-right',
                //         className: 'error'
                //     });
                //     return false;
                // }

                // Check if selling_qty is larger than current_stock_qty
                if (parseFloat(selling_qty) > parseFloat(current_stock_qty)) {
                    $.notify("Stock is not enough to meet the order", {
                        globalPosition: 'top-right',
                        className: 'error'
                    });
                    return false;
                }

                var source = $("#document-template").html();
                var template = Handlebars.compile(source);

                var data = {
                    date: date,
                    invoice_no: invoice_no,
                    category_id: category_id,
                    category_name: category_name,
                    product_id: product_id,
                    product_name: product_name,
                    buying_unit_price: buying_unit_price
                };

                var html = template(data);
                $("#addRow").append(html);

                totalAmountPrice();

            });

            $(document).on("click", ".removeeventmore", function(event) {
                $(this).closest(".delete_add_more_item").remove();
                totalAmountPrice();
            })

            // dynamically change selling_price on change of selling_qty and unit_price
            // $(document).on('keyup click', '.unit_price,.selling_price', function() {
            //     var unit_price = $(this).closest("tr").find("input.unit_price").val();
            //     var qty = $(this).closest("tr").find("input.selling_qty").val();
            //     var total = unit_price * qty;
            //     $(this).closest("tr").find("input.selling_price").val(total);
            //     $('#discount_amount').trigger('keyup')
            // });


            $(document).on('keyup click', '.selling_qty', function() {
                var unit = $(this).closest("tr").find("input.selling_qty").val();
                var total = unit * parseFloat($("#buying_unit_price").val()); // Use the buying_unit_price
                $(this).closest("tr").find("input.selling_price").val(total);
                $('#discount_amount').trigger('keyup');
            });






            $(document).on('keyup click', '#discount_amount', function() {
                totalAmountPrice();
            });

            //Written by AI , Chatgpt to be specific
            // $(document).on('keyup click', '.selling_qty,.unit_price', function() {
            //     var row = $(this).closest('tr');
            //     var selling_qty = row.find('.selling_qty').val();
            //     var unit_price = row.find('.unit_price').val();
            //     var selling_price = (selling_qty * unit_price).toFixed(2);
            //     row.find('.selling_price').val(selling_price);
            // });

            // $(document).on('keyup click', '.unit_price, #buying_unit_price', function() {
            //     var unit_price = parseFloat($(this).closest("tr").find("input.unit_price").val());
            //     var buying_unit_price = parseFloat($("#buying_unit_price").val());
            //     var diff = 0;
            //     if (unit_price > buying_unit_price) {
            //         diff = unit_price - buying_unit_price;
            //         $('#profit_loss').val(diff.toFixed(2));
            //     } else {
            //         diff = buying_unit_price - unit_price;
            //         $('#profit_loss').val('-' + diff.toFixed(2));
            //     }
            // });


            function totalAmountPrice() {
                var sum = 0;

                $(".selling_price").each(function() {
                    var value = $(this).val();
                    if (!isNaN(value) && value.length != 0) {
                        sum += parseFloat(value);
                    }
                });

                var discount_amount = parseFloat($('#discount_amount').val())
                if (!isNaN(discount_amount) && discount_amount.length != 0) {
                    sum -= parseFloat(discount_amount);
                }

                $('#estimated_amount').val(sum);
            }


        });
    </script>

    <script>
        $(document).ready(function() {
            // Add an event listener to the form submission
            $('#myForm').submit(function(event) {
                // Prevent the form from submitting
                event.preventDefault();

                // Check if any field is empty
                var inputs = $(this).find('input[required]');
                var emptyFields = inputs.filter(function() {
                    return $(this).val().trim() === '';
                });

                // If there are empty fields, display a Toastr notification
                if (emptyFields.length > 0) {
                    toastr.error('There are empty fields!');
                    return;
                }

                // All fields are filled, proceed with form submission
                event.target.submit();
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


    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#product_id', function() {
                var product_id = $(this).val();
                $.ajax({
                    url: "{{ route('check_product_stock') }}",
                    type: "GET",
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {

                        $('#current_stock_qty').val(data);
                    }
                });
            });
        });
    </script>


    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#product_id', function() {
                var product_id = $(this).val();
                $.ajax({
                    url: "{{ route('get_buying_unit_price') }}",
                    type: "GET",
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {

                        $('#buying_unit_price').val(data);
                    }
                });
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



        $(document).on('change', '#payment_option', function() {
            var payment_option = $(this).val();
            if (payment_option !== '') {
                $('.paid_status').show();
            } else {
                $('.paid_status').hide();
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    paid_amount: {
                        required: true,
                    },


                },
                messages: {
                    paid_amount: {
                        required: 'Please Enter Paid Amount',
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
