@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-6">
                    <div class="card"><br><br>
                        

                        <div class="card-body">
                            <h4 class="card-title">Company Name : {{ $company->company_name }} </h4>
                            <hr>
                            <h4 class="card-title">Company Email : {{ $company->company_email }} </h4>
                            <hr>
                            <h4 class="card-title">Company Address : {{ $company->company_address }} </h4>
                            <hr>
                            <h4 class="card-title">Company Phone : {{ $company->company_phone }} </h4>
                            <hr>
                            <a href="{{ route('edit.company.detail') }}" class="btn btn-info btn-rounded waves-effect waves-light">
                                Edit Company Detail
                            </a>

                        </div>
                    </div>
                </div>


            </div>


        </div>
    </div>
@endsection
