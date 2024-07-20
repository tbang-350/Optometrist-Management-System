<?php

namespace App\Http\Controllers;

use App\Charts\DailySalesChart;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Product;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InvoiceController extends Controller
{

    /**
     * Display a listing of all invoices.
     *
     * @return \Illuminate\View\View
     */
    public function InvoiceAll(DailySalesChart $dailySalesChart)
    {
        // Retrieve all invoices sorted by date and ID in descending order
        // where the status is '1' (approved)

        $chart = $dailySalesChart->build();

        $current_location = Auth::user()->location_id;

        if ($current_location == 1) {

            $allData = Invoice::where('status', '1')->orderBy('date', 'desc')->orderBy('id', 'desc')->get();

        } else {

            $allData = Invoice::where('location_id', $current_location)
                ->where('status', '1')
                ->orderBy('date', 'desc')
                ->orderBy('id', 'desc')
                ->get();

        }

        // Return the view with the invoice data
        return view('backend.invoice.invoice_all', compact('allData', 'chart'));

    } // End Method

    /**
     * Show the form for creating a new invoice.
     *$current_location = Auth::user()->location_id;
     * @return \Illuminate\View\View
     */
    public function InvoiceAdd()
    {
        $current_location = Auth::user()->location_id;

        // Retrieve all categories and customers

        if ($current_location == 1) {

            $category = Category::all();
            $customer = Customer::all();

        } else {

            $category = Category::where('location_id', $current_location)->get();
            $customer = Customer::where('location_id', $current_location)->get();

        }

        // Get the last invoice number and increment it by 1
        $invoice_data = Invoice::orderBy('id', 'desc')->first();
        $invoice_no = $invoice_data ? $invoice_data->invoice_no + 1 : 1;

        // Get the current date
        $date = date('Y-m-d');

        // Return the view with the necessary data
        return view('backend.invoice.invoice_add', compact('invoice_no', 'category', 'date', 'customer'));

    } // End Method

    /**
     * InvoiceStore function is responsible for handling the creation of a new invoice in the system.
     * It takes a Request object as its input parameter, which contains the necessary data for creating the invoice.
     *
     * @param Request $request The request object containing the data for the new invoice
     * @return \Illuminate\Http\RedirectResponse Redirects to the pending invoice list page with a success or error notification
     */
    public function InvoiceStore(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'invoice_no' => 'required|integer',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'category_id' => 'required|array',
            'category_id.*' => 'integer|exists:categories,id',
            'product_id' => 'required|array',
            'product_id.*' => 'integer|exists:products,id',
            'selling_qty' => 'required|array',
            'selling_qty.*' => 'numeric|min:1',
            'unit_price' => 'required|array',
            'unit_price.*' => 'numeric|min:0',
            'selling_price' => 'required|array',
            'selling_price.*' => 'numeric|min:0',
            'customer_id' => 'required|integer|exists:customers,id',
            'paid_amount' => 'required|numeric|min:0',
            'estimated_amount' => 'required|numeric|min:0',
            'paid_status' => 'required|string|in:full_paid,partial_paid',
            'payment_option' => 'required|string',
            'discount_amount' => 'nullable|numeric|min:0',
            'markup_amount' => 'nullable|numeric|min:0',
        ]);

        if ($request->category_id === null) {
            $notification = array(
                'message' => 'Sorry, no item selected',
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
                $invoice = new Invoice();
                $invoice->invoice_no = $request->invoice_no;
                $invoice->date = date('Y-m-d', strtotime($request->date));
                $invoice->description = $request->description;
                $invoice->status = '0';
                $invoice->created_by = Auth::user()->id;
                $invoice->created_at = Carbon::now();
                $invoice->location_id = Auth::user()->location_id;

                DB::transaction(function () use ($request, $invoice) {
                    if ($invoice->save()) {
                        $count_category = count($request->category_id);

                        for ($i = 0; $i < $count_category; $i++) {
                            $invoice_detail = new InvoiceDetail();
                            $invoice_detail->date = date('Y-m-d', strtotime($request->date));
                            $invoice_detail->invoice_id = $invoice->id;
                            $invoice_detail->category_id = $request->category_id[$i];
                            $invoice_detail->product_id = $request->product_id[$i];
                            $invoice_detail->selling_qty = $request->selling_qty[$i];
                            $invoice_detail->unit_price = $request->unit_price[$i];
                            $invoice_detail->selling_price = $request->selling_price[$i];
                            $invoice_detail->status = '0';
                            $invoice_detail->created_at = Carbon::now();
                            $invoice_detail->save();
                        }

                        if ($request->customer_id == '0') {
                            $customer = new Customer();
                            $customer->name = $request->name;
                            $customer->phonenumber = $request->phonenumber;
                            $customer->address = $request->address;
                            $customer->age = $request->age;
                            $customer->sex = $request->sex;
                            $customer->location_id = Auth::user()->location_id;
                            $customer->created_by = Auth::user()->id;
                            $customer->created_at = Carbon::now();
                            $customer->save();

                            $customer_id = $customer->id;
                        } else {
                            $customer_id = $request->customer_id;
                        }

                        $payment = new Payment();
                        $payment_details = new PaymentDetail();

                        $payment->invoice_id = $invoice->id;
                        $payment->customer_id = $customer_id;
                        $payment->paid_status = $request->paid_status;
                        $payment->payment_option = $request->payment_option;
                        $payment->discount_amount = $request->discount_amount;
                        $payment->markup_amount = $request->markup_amount;
                        $payment->total_amount = $request->estimated_amount;
                        $payment->created_at = Carbon::now();
                        $payment->created_by = Auth::user()->id;
                        $payment->location_id = Auth::user()->location_id;

                        if ($request->paid_status == 'full_paid') {
                            $payment->paid_amount = $request->estimated_amount;
                            $payment->due_amount = '0';
                            $payment_details->current_paid_amount = $request->estimated_amount;
                        } elseif ($request->paid_status == 'full_paid') {
                            $payment->paid_amount = '0';
                            $payment->due_amount = $request->estimated_amount;
                            $payment_details->current_paid_amount = '0';
                        } elseif ($request->paid_status == 'partial_paid') {
                            $payment->paid_amount = $request->paid_amount;
                            $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                            $payment_details->current_paid_amount = $request->paid_amount;
                        }

                        $payment->save();

                        $payment_details->invoice_id = $invoice->id;
                        $payment_details->date = date('Y-m-d', strtotime($request->date));
                        $payment_details->location_id = Auth::user()->location_id;
                        $payment_details->save();
                    }
                });
            }
        }

        $notification = array(
            'message' => 'Invoice Created Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('invoice.pending.list')->with($notification);
    } // End Method

    /**
     * Display a listing of pending invoices.
     *
     * @return \Illuminate\View\View
     */
    public function PendingList()
    {
        // Retrieve all pending invoices sorted by date and ID in descending order
        // where the status is '0' (pending)

        $current_location = Auth::user()->location_id;

        if ($current_location == 1) {

            $allData = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '0')->get();

        } else {

            $allData = Invoice::where('location_id', $current_location)->orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '0')->get();

        }

        $allData = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '0')->get();

        // Return the view with the pending invoice data
        return view('backend.invoice.invoice_pending_list', compact('allData'));

    } // End Method

    /**
     * Remove the specified invoice from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function InvoiceDelete($id)
    {
        // Find the invoice by ID and delete it
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        // Delete related invoice details, payments, and payment details
        InvoiceDetail::where('invoice_id', $invoice->id)->delete();
        Payment::where('invoice_id', $invoice->id)->delete();
        PaymentDetail::where('invoice_id', $invoice->id)->delete();

        // Return a success notification and redirect back
        $notification = array(
            'message' => 'Invoice Deleted successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    } // End Method

    public function InvoiceApprove($id)
    {

        $invoice = Invoice::with('invoice_details')->findOrFail($id);

        return view('backend.invoice.invoice_approve', compact('invoice'));

    } // End Method

    /**
     * Approve an invoice and update product quantities.
     *
     * This function approves an invoice with the given ID and updates the product
     * quantities based on the approved invoice. It performs the following steps:
     *
     * 1. Check if the product's quantity is less than the requested selling quantity.
     *    If it is, display a notification and return to the previous page.
     * 2. Retrieve the invoice with the given ID and set its status to '1' (approved).
     * 3. Use a DB::transaction block to ensure that the following operations are
     *    executed atomically (i.e., all or nothing):
     *    a. Iterate through the selling_qty array and update the product quantities.
     *    b. Save the updated product record to the database.
     *    c. Save the updated invoice record to the database.
     * 4. Display a notification to inform the user of the result and redirect to the
     *    list of pending invoices.
     *
     * @param  Request $request The request object containing the selling quantities.
     * @param  int $id The ID of the invoice to be approved.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ApprovalStore(Request $request, $id)
    {

        // Iterate through the selling_qty array and check if the product's quantity is less than the requested selling quantity
        foreach ($request->selling_qty as $key => $val) {

            $invoice_details = InvoiceDetail::where('id', $key)->first();
            $product = Product::where('id', $invoice_details->product_id)->first();

            // If the product's quantity is less than the requested selling quantity, display a notification and return to the previous page
            if ($product->quantity < $request->selling_qty[$key]) {

                $notification = array(
                    'message' => 'Sorry, you approve maximum value',
                    'alert-type' => 'error',
                );

                return redirect()->back()->with($notification);

            }

        } // End foreach

        // Retrieve the invoice with the given ID and set its updated_by attribute and status
        $invoice = Invoice::findOrFail($id);
        $invoice->updated_by = Auth::user()->id;
        $invoice->status = '1';

        // Use a DB::transaction block to ensure that the following operations are executed atomically
        DB::transaction(function () use ($request, $invoice, $id) {

            // Iterate through the selling_qty array and update the product quantities
            foreach ($request->selling_qty as $key => $val) {

                $invoice_details = InvoiceDetail::where('id', $key)->first();

                $invoice_details->status = '1';
                $invoice_details->save();

                $product = Product::where('id', $invoice_details->product_id)->first();

                // Subtract the requested selling quantity from the product's current quantity
                $product->quantity = ((float) $product->quantity) - ((float) $request->selling_qty[$key]);

                // Save the updated product record to the database
                $product->save();

            } // End foreach

            // Save the updated invoice record to the database
            $invoice->save();

        });

        // Display a notification to inform the user of the result and redirect to the list of pending invoices
        $notification = array(
            'message' => 'Invoice Approved Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('invoice.pending.list')->with($notification);

    } // End Method

    /**
     * Display a listing of invoices for printing.
     *
     * @return \Illuminate\View\View
     */
    public function PrintInvoiceList()
    {
        // Retrieve all approved invoices sorted by date and ID in descending order
        $allData = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '1')->get();

        // Return the view with the invoice data
        return view('backend.invoice.print_invoice_list', compact('allData'));

    } // End Method

    /**
     * Generate a PDF for the specified invoice.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function PrintInvoice($id)
    {

        // Find the invoice by ID with its related invoice details
        $invoice = Invoice::with('invoice_details')->findOrFail($id);

        // Return the view with the invoice data for generating the PDF
        return view('backend.pdf.invoice_pdf', compact('invoice'));

    } // End Method

    public function DailyInvoiceReport()
    {

        return view('backend.invoice.daily_invoice_report');

    } // End Method

    public function DailyInvoicePdf(Request $request)
    {

        $current_location = Auth::user()->location_id;

        $sdate = date('Y-m-d', strtotime($request->start_date));
        $edate = date('Y-m-d', strtotime($request->end_date));

        if ($current_location == 1) {

            $allData = Invoice::whereBetween('date', [$sdate, $edate])->where('status', '1')->get();

        } else {

            $allData = PaymentDetail::where('location_id', $current_location)
                ->whereBetween('date', [$sdate, $edate])
                ->where('status', '1')
                ->get();

        }

        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));

        return view('backend.pdf.daily_invoice_report_pdf', compact('allData', 'start_date', 'end_date'));

    } // End Method

    public function SalesChart(DailySalesChart $dailySalesChart)
    {

        $chart = $dailySalesChart->build();

        return view('backend.invoice.invoice_chart', compact('chart'));

    }

    // public function SalesChartIndex(DailySalesChart $dailySalesChart) {

    //     $chart = $dailySalesChart->build();

    //     return view('backend.invoice.invoice_all', compact('chart'));

    // }

    // public function PriceComparison(PriceComparison $priceComparison) {

    //     $chart2 = $priceComparison->build();

    //     return view('backend.invoice.invoice_all', compact('chart2'));

    // }

}
