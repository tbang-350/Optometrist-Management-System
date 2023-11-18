<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Service;
use App\Models\ServiceInvoice;
use App\Models\ServiceInvoiceDetails;
use App\Models\ServicePayment;
use App\Models\ServicePaymentDetail;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ServiceInvoiceController extends Controller
{
    public function ServiceInvoiceAll()
    {

        $current_location = Auth::user()->location_id;

        if ($current_location == 1) {

            $allData = ServiceInvoice::orderBy('date', 'desc')->orderBy('id', 'desc')->get();

        } else {

            $allData = ServiceInvoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('location_id',$current_location)->get();

        }

        return view('backend.service_invoice.service_invoice_all', compact('allData'));

    }

    public function ServiceInvoiceAdd()
    {

        $current_location = Auth::user()->location_id;

        //Retrieve all categories and customers
        $service = Service::all();
        $customer = Customer::all();

        if ($current_location == 1) {

            $customer = Customer::all();

        } else {

            $customer = Customer::where('location_id', $current_location)->get();

        }

        // Get the last prescription number and increment it by 1
        $service_invoice_data = ServiceInvoice::orderBy('id', 'desc')->first();
        $service_invoice_no = $service_invoice_data ? $service_invoice_data->service_invoice_no + 1 : 1;

        // Get the current date
        $date = date('Y-m-d');

        // Return the view with the necessary data
        return view('backend.service_invoice.service_invoice_add', compact('service_invoice_no', 'service', 'date', 'customer'));

    }

    public function ServiceInvoiceStore(Request $request)
    {

        if ($request->service_id === null) {
            $notification = array(
                'message' => 'Sorry , no item selected',
                'alert-type' => 'error',
            );

            return redirect()->back()->with($notification);
        } else {

            if ($request->paid_amount > $request->estimated_amount) {

                $notification = array(
                    'message' => 'Paid amount is greater than grand total',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);

            } else {
                $service_invoice = new ServiceInvoice();
                $service_invoice->service_invoice_no = $request->service_invoice_no;
                $service_invoice->date = date('Y-m-d', strtotime($request->date));
                $service_invoice->description = $request->description;
                $service_invoice->status = '0';
                $service_invoice->created_by = Auth::user()->id;
                $service_invoice->created_at = Carbon::now();
                $service_invoice->location_id = Auth::user()->location_id;
                // $prescription->save();

                //  dd($service_invoice);

                DB::transaction(function () use ($request, $service_invoice) {

                    if ($service_invoice->save()) {

                        $count_service = count($request->service_id);

                        for ($i = 0; $i < $count_service; $i++) {

                            $service_invoice_details = new ServiceInvoiceDetails();
                            $service_invoice_details->date = date('Y-m-d', strtotime($request->date));
                            $service_invoice_details->service_invoice_id = $service_invoice->id;
                            $service_invoice_details->service_id = $request->service_id[$i];
                            $service_invoice_details->service_price = $request->service_price[$i];
                            $service_invoice_details->service_selling_price = $request->service_selling_price[$i];
                            $service_invoice_details->status = '0';
                            $service_invoice_details->created_at = Carbon::now();
                            $service_invoice_details->save();

                        }

                        if ($request->customer_id == '0') {

                            $customer = new Customer();
                            $customer->name = $request->name;
                            $customer->phonenumber = $request->phonenumber;
                            $customer->address = $request->address;
                            $customer->age = $request->age;
                            $customer->sex = $request->sex;
                            $customer->location_id = Auth::user()->location_id;
                            $customer->save();

                            $customer_id = $customer->id;

                        } else {

                            $customer_id = $request->customer_id;

                        }

                        $service_payment = new ServicePayment();
                        $service_payment_detail = new ServicePaymentDetail();

                        $service_payment->service_invoice_id = $service_invoice->id;
                        $service_payment->customer_id = $customer_id;
                        $service_payment->paid_status = $request->paid_status;
                        $service_payment->payment_option = $request->payment_option;
                        $service_payment->discount_amount = $request->discount_amount;
                        $service_payment->total_amount = $request->estimated_amount;
                        $service_payment->created_at = Carbon::now();
                        $service_payment->created_by = Auth::user()->id;

                        if ($request->paid_status == 'full_paid') {

                            $service_payment->paid_amount = $request->estimated_amount;
                            $service_payment->due_amount = '0';
                            $service_payment_detail->current_paid_amount = $request->estimated_amount;

                        } elseif ($request->paid_status == 'full_paid') {

                            $service_payment->paid_amount = '0';
                            $service_payment->due_amount = $request->estimated_amount;
                            $service_payment_detail->current_paid_amount = '0';

                        } elseif ($request->paid_status == 'partial_paid') {

                            $service_payment->paid_amount = $request->paid_amount;
                            $service_payment->due_amount = $request->estimated_amount - $request->paid_amount;
                            $service_payment_detail->current_paid_amount = $request->paid_amount;

                        }

                        $service_payment->save();

                        $service_payment_detail->service_invoice_id = $service_invoice->id;
                        $service_payment_detail->date = date('Y-m-d', strtotime($request->date));
                        $service_payment_detail->location_id = Auth::user()->location_id;
                        $service_payment_detail->save();

                    }

                });

            }

        }

        $notification = array(
            'message' => 'Prescription Created Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('service.invoice.all')->with($notification);

    }

    public function PrintServiceInvoice($id)
    {

        // Find the prescription by ID with its related prescription details
        $service_invoice = ServiceInvoice::with('service_invoice_details')->findOrFail($id);

        // dd($prescription);

        // Return the view with the prescription data for generating the PDF
        return view('backend.pdf.service_invoice_pdf', compact('service_invoice'));

    }

    public function DailyServiceInvoiceReport()
    {

        return view('backend.service_invoice.daily_service_invoice_report');

    } // End Method

    public function DailyServiceInvoicePdf(Request $request)
    {

        $current_location = Auth::user()->location_id;

        $sdate = date('Y-m-d', strtotime($request->start_date));
        $edate = date('Y-m-d', strtotime($request->end_date));

        if ($current_location == 1) {

            $allData = ServiceInvoice::whereBetween('date', [$sdate, $edate])->get();

        } else {

            $allData = ServiceInvoice::whereBetween('date', [$sdate, $edate])->where('location_id', $current_location)->get();

        }

        // dd($sdate,$edate);

        // dd($allData);

        return view('backend.pdf.service_invoice_report_pdf', compact('allData', 'start_date', 'end_date'));

    } // End Method

    public function ServiceInvoicePaymentReport()
    {

        return view('backend.service_invoice.service_invoice_payment_report');

    }

    public function ServicePaymentOptionReport(Request $request)
    {
        $current_location = Auth::user()->location_id;

        $payment_option = $request->payment_option;

        if ($current_location == 1) {

            $allData = ServicePayment::where('payment_option', $payment_option)->get();

        } else {

            $allData = ServicePayment::where('payment_option', $payment_option)->where('location_id', $current_location)->get();

        }

        // dd($allData);

        return view('backend.pdf.service_payment_option_report_pdf', compact('allData', 'payment_option'));

    }

}
