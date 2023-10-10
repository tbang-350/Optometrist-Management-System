@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>



    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 --}}




    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Purchase </h4><br><br>

                            <form action="#" method="get">

                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="date" class="form-label">Date</label>
                                        <input name="date" class="form-control example-date-input" type="date"
                                            id="date">
                                    </div>

                                    <div class=" form-group col-md-6">
                                        <label for="example-text-input" class="form-label">Purchase No</label>

                                        <input name="purchase_no" class="form-control example-date-input" type="text"
                                            id="purchase_no" value="{{ $purchase_no }}" readonly
                                            style="background-color: #ddd">
                                    </div>

                                    <hr>


                                    <div class="row mb-3 ">
                                        <div class=" form-group col-md-6">
                                            <label for="example-text-input" class="form-label">Supplier</label>
                                            <input name="supplier_name" id="supplier_name" class="form-control"
                                                type="text" autocomplete="off">
                                        </div>

                                        <div class=" form-group col-md-6">
                                            <label for="example-text-input" class="form-label">Category</label>
                                            <input name="category_name" id="category_name" class="form-control"
                                                type="text" autocomplete="off">
                                        </div>

                                    </div>



                                    <div class="row mb-3 ">
                                        <div class=" form-group col-md-6">
                                            <label for="example-text-input" class="form-label">Product Name</label>
                                            <input name="product_name" id="product_name" class="form-control" type="text"
                                                autocomplete="off">
                                        </div>

                                        <div class=" form-group col-md-6">
                                            <label for="example-text-input" class="form-label">Units</label>
                                            <input name="name" class="form-control" type="number">
                                        </div>

                                    </div>



                                    <div class="row mb-3 ">
                                        <div class=" form-group col-md-6">
                                            <label for="example-text-input" class="form-label">Buying Unit Price</label>
                                            <input name="name" class="form-control" type="text">
                                        </div>

                                        <div class=" form-group col-md-6">
                                            <label for="example-text-input" class="form-label">Selling Unit Price</label>
                                            <input name="name" class="form-control" type="number">
                                        </div>

                                    </div>



                                    <div class="row mb-3 ">
                                        <div class=" form-group col-md-4">
                                            <label for="example-text-input" class="form-label">Reorder Level</label>
                                            <input name="name" class="form-control" type="text">
                                        </div>

                                    </div>


                                    <br>
                                    <br>

                                    <div class="row mb-3 ">
                                        <div class=" form-group col-md-2">
                                            <input type="submit" class="btn btn-info waves-effect waves-light"
                                                value="Add Prescription">
                                        </div>

                                    </div>



                                </div>

                            </form>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        var path = "{{ route('autocomplete.suppliers') }}";

        $('#supplier_name').typeahead({
            source: function(query, process) {
                return $.get(path, {
                    query: query
                }, function(data) {
                    return process(data);
                });
            }
        });
    </script>

    <script type="text/javascript">
        var path2 = "{{ route('autocomplete.categories') }}";

        $('#category_name').typeahead({
            source: function(query, process) {
                return $.get(path2, {
                    query: query
                }, function(data) {
                    return process(data);
                });
            }
        });
    </script>


    <script type="text/javascript">
        var path3 = "{{ route('autocomplete.products') }}";

        $('#product_name').typeahead({
            source: function(query, process) {
                return $.get(path3, {
                    query: query
                }, function(data) {
                    return process(data);
                });
            }
        });
    </script>
@endsection
