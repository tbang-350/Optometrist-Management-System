<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Auth;
use Illuminate\Support\Carbon;

class CustomerController extends Controller
{
    public function CustomerAll()
    {

        $customer = Customer::latest()->get();

        return view('backend.customer.customer_all', compact('customer'));

    }
}
