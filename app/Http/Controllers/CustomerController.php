<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\PaymentDetails;
use App\Models\ServicePayment;
use App\Models\ServicePaymentDetail;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CustomerController extends Controller
{
    public function CustomerAll()
    {

        $customer = Customer::latest()->get();

        return view('backend.customer.customer_all', compact('customer'));

    }

    public function CustomerAdd()
    {

        return view('backend.customer.customer_add');

    }

    public function CustomerStore(Request $request)
    {

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

    public function CustomerEdit($id)
    {

        $customer = Customer::findOrFail($id);

        return view('backend.customer.customer_edit', compact('customer'));

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

    public function CreditCustomer()
    {

        $allData = Payment::whereIn('paid_status', ['partial_paid'])->get();

        return view('backend.customer.customer_credit', compact('allData'));

    } // End Method

    public function CreditServiceCustomer()
    {

        $allServiceData = ServicePayment::whereIn('paid_status', ['partial_paid'])->get();

        return view('backend.customer.customer_service_credit', compact('allServiceData'));

    } // End Method

    public function CreditCustomerPrintPdf()
    {

        $allData = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();

        return view('backend.pdf.customer_credit_pdf', compact('allData'));

    } // End Method

    public function ServiceCreditCustomerPrintPdf()
    {

        $allData = ServicePayment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();

        return view('backend.pdf.service_customer_credit_pdf', compact('allData'));

    } // End Method

    public function CustomerEditInvoice($invoice_id)
    {

        $payment = Payment::where('invoice_id', $invoice_id)->first();

        return view('backend.customer.edit_customer_invoice', compact('payment'));

    } // End Method

    public function CustomerUpdateInvoice(Request $request, $invoice_id)
    {

        if ($request->paid_amount > $request->new_paid_amount) {
            $notification = array(
                'message' => 'Sorry , you paid maximum value',
                'alert-type' => 'error',
            );

            return redirect()->back()->with($notification);
        } else {

            $payment = Payment::where('invoice_id', $invoice_id)->first();

            $payment_details = new PaymentDetail();

            $payment->paid_status = $request->paid_status;

            if ($request->paid_status == 'full_paid') {

                $payment->paid_amount = Payment::where('invoice_id', $invoice_id)->first()['paid_amount'] + $request->new_paid_amount;

                $payment->due_amount = '0';

                // $payment->paid_status = 'full_paid';

                $payment_details->current_paid_amount = $request->new_paid_amount;

            } elseif ($request->paid_status == 'partial_paid') {

                $payment->paid_amount = Payment::where('invoice_id', $invoice_id)->first()['paid_amount'] + $request->paid_amount;

                $payment->due_amount = Payment::where('invoice_id', $invoice_id)->first()['due_amount'] - $request->paid_amount;

                $payment_details->current_paid_amount = $request->paid_amount;

            }

            $payment->save();

            $payment_details->invoice_id = $invoice_id;
            $payment_details->date = date('Y-m-d', strtotime($request->date));
            $payment_details->updated_by = Auth::user()->id;
            $payment_details->save();

            $notification = array(
                'message' => 'Invoice Updated Succesfully',
                'alert-type' => 'success',
            );

            return redirect()->route('credit.service.customer')->with($notification);

        }

    } // End Method

    public function CustomerEditServiceInvoice($service_invoice_id)
    {

        $service_payment = ServicePayment::where('service_invoice_id', $service_invoice_id)->first();

        return view('backend.customer.edit_customer_service_invoice', compact('service_payment'));

    } // End Method

    public function CustomerUpdateServiceInvoice(Request $request, $service_invoice_id)
    {

        if ($request->paid_amount > $request->new_paid_amount) {
            $notification = array(
                'message' => 'Sorry , you paid maximum value',
                'alert-type' => 'error',
            );

            return redirect()->back()->with($notification);
        } else {

            $payment = ServicePayment::where('service_invoice_id', $service_invoice_id)->first();

            $payment_details = new ServicePaymentDetail();

            $payment->paid_status = $request->paid_status;

            if ($request->paid_status == 'full_paid') {

                $payment->paid_amount = ServicePayment::where('service_invoice_id', $service_invoice_id)->first()['paid_amount'] + $request->new_paid_amount;

                $payment->due_amount = '0';

                // $payment->paid_status = 'full_paid';

                $payment_details->current_paid_amount = $request->new_paid_amount;

            } elseif ($request->paid_status == 'partial_paid') {

                $payment->paid_amount = ServicePayment::where('service_invoice_id', $service_invoice_id)->first()['paid_amount'] + $request->paid_amount;

                $payment->due_amount = ServicePayment::where('service_invoice_id', $service_invoice_id)->first()['due_amount'] - $request->paid_amount;

                $payment_details->current_paid_amount = $request->paid_amount;

            }

            $payment->save();

            $payment_details->service_invoice_id = $service_invoice_id;
            $payment_details->date = date('Y-m-d', strtotime($request->date));
            $payment_details->updated_by = Auth::user()->id;
            $payment_details->save();

            $notification = array(
                'message' => 'Invoice Updated Succesfully',
                'alert-type' => 'success',
            );

            return redirect()->route('credit.customer')->with($notification);

        }

    } // End Method

    public function CustomerInvoiceDetails($invoice_id)
    {

        $payment = Payment::where('invoice_id', $invoice_id)->first();

        return view('backend.pdf.invoice_details_pdf', compact('payment'));

    } // End Method


    public function CustomerServiceInvoiceDetails($service_invoice_id)
    {

        $service_payment = ServicePayment::where('service_invoice_id', $service_invoice_id)->first();

        return view('backend.pdf.service_invoice_details_pdf', compact('service_payment'));

    } // End Method

    public function PaidCustomer()
    {

        $allData = Payment::whereIn('paid_status', ['partial_paid', 'full_paid'])->get();

        return view('backend.customer.customer_paid', compact('allData'));

    } //End Method

    public function PaidCustomerPrintPdf()
    {

        $allData = Payment::whereIn('paid_status', ['partial_paid', 'full_paid'])->get();

        return view('backend.pdf.customer_paid_pdf', compact('allData'));

    } // End Method

    public function CustomerWiseReport()
    {

        $customers = Customer::all();

        return view('backend.customer.customer_wise_report', compact('customers'));

    } // End Method

    public function CustomerWiseCreditReport(Request $request)
    {

        $allData = Payment::where('customer_id', $request->customer_id)->whereIn('paid_status', ['partial_paid'])->get();

        return view('backend.pdf.customer_wise_credit_pdf', compact('allData'));

    } // End Method

    public function CustomerWisePaidReport(Request $request)
    {

        $allData = Payment::where('customer_id', $request->customer_id)->whereIn('paid_status', ['partial_paid', 'full_paid'])->get();

        return view('backend.pdf.customer_wise_paid_pdf', compact('allData'));

    } // End Method

}
