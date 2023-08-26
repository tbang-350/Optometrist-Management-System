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

    public function CustomerAdd(){

        return view('backend.customer.customer_add');

    }


    public function CustomerStore(Request $request){

        Customer::insert([
            'name' => $request->name,
            'age' => $request->age,
            'sex' => $request->sex,
            'address' => $request->address,
            'phonenumber' => $request->phonenumber,
            'location_id' => Auth::user()->location_id,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Customer Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('customer.all')->with($notification);

    }


    public function CustomerEdit($id){

        $customer = Customer::findOrFail($id);

        return view('backend.customer.customer_edit',compact('customer'));

    }

    public function CustomerUpdate(Request $request)
    {

        $customer_id = $request->id;

        Customer::findOrFail($customer_id)->update([
            'name' => $request->name,
            'age' => $request->age,
            'sex' => $request->sex,
            'address' => $request->address,
            'phonenumber' => $request->phonenumber,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Customer Updated Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('customer.all')->with($notification);

    }

    public function CustomerDelete($id)
    {

        Customer::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    } // End Method


}
