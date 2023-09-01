<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\PaymentDetails;
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

    public function CreditCustomer(){

        $allData = Payment::whereIn('paid_status',['partial_paid'])->get();

        return view('backend.customer.customer_credit',compact('allData'));

    } // End Method


    public function CreditCustomerPrintPdf(){

        $allData = Payment::whereIn('paid_status',['full_due','partial_paid'])->get();

        return view('backend.pdf.customer_credit_pdf',compact('allData'));

    } // End Method

    public function CustomerEditPrescription($prescription_id){

        $payment = Payment::where('Prescription_id',$prescription_id)->first();

        return view('backend.customer.edit_customer_prescription',compact('payment'));

    } // End Method


    public function CustomerUpdatePrescription(Request $request, $prescription_id){

        if ($request->paid_amount > $request->new_paid_amount) {
            $notification = array(
                'message' => 'Sorry , you paid maximum value',
                'alert-type' => 'error',
            );
    
            return redirect()->back()->with($notification);
        } else {

            $payment = Payment::where('prescription_id',$prescription_id)->first();

            $payment_details = new PaymentDetails();

            $payment->paid_status = $request->paid_status;

            if ($request->paid_status == 'full_paid') {

                $payment->paid_amount = Payment::where('prescription_id',$prescription_id)->first()['paid_amount'] + $request->new_paid_amount;

                $payment->due_amount = '0';

                // $payment->paid_status = 'full_paid';

                $payment_details->current_paid_amount = $request->new_paid_amount;
                
            } elseif ($request->paid_status == 'partial_paid') {

                $payment->paid_amount = Payment::where('prescription_id',$prescription_id)->first()['paid_amount'] + $request->paid_amount;

                $payment->due_amount = Payment::where('prescription_id',$prescription_id)->first()['due_amount'] - $request->paid_amount;

                $payment_details->current_paid_amount = $request->paid_amount; 
                
            }

            $payment->save();

            $payment_details->prescription_id = $prescription_id;
            $payment_details->date = date('Y-m-d',strtotime($request->date));
            $payment_details->updated_by = Auth::user()->id;
            $payment_details->save();

            $notification = array(
                'message' => 'Prescription Updated Succesfully',
                'alert-type' => 'success',
            );
    
            return redirect()->route('credit.customer')->with($notification);
            
        }

    } // End Method


    public function CustomerPrescriptionDetails($prescription_id){

        $payment = Payment::where('prescription_id',$prescription_id)->first();

        return view('backend.pdf.prescription_details_pdf',compact('payment'));

    } // End Method

    public function PaidCustomer(){

        $allData = Payment::whereIn('paid_status',['partial_paid','full_paid'])->get();

        return view('backend.customer.customer_paid',compact('allData'));

    } //End Method


    public function PaidCustomerPrintPdf(){

        $allData = Payment::whereIn('paid_status',['partial_paid','full_paid'])->get();

        return view('backend.pdf.customer_paid_pdf',compact('allData'));

    } // End Method


    public function CustomerWiseReport(){

        $customers = Customer::all();

        return view('backend.customer.customer_wise_report',compact('customers'));

    } // End Method


    public function CustomerWiseCreditReport(Request $request){

        $allData = Payment::where('customer_id',$request->customer_id)->whereIn('paid_status',['partial_paid'])->get();

        return view('backend.pdf.customer_wise_credit_pdf',compact('allData'));

    } // End Method


    public function CustomerWisePaidReport(Request $request){

        $allData = Payment::where('customer_id',$request->customer_id)->whereIn('paid_status',['partial_paid','full_paid'])->get();

        return view('backend.pdf.customer_wise_paid_pdf',compact('allData'));

    } // End Method

}
