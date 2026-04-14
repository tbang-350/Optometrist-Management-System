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
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $allData = Invoice::where('status', '1')
                ->where('location_id', $current_location)
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
    public function InvoiceStore(\App\Http\Requests\StoreInvoiceRequest $request, \App\Services\InvoiceService $invoiceService)
    {
        if ($request->category_id === null) {
            $notification = array(
                'message' => 'Sorry, no item selected',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        if ($request->paid_amount > $request->estimated_amount) {
            $notification = array(
                'message' => 'Paid amount is greater than grand total',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }

        $invoiceService->createInvoice($request->validated());

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
    public function ApprovalStore(Request $request, $id, \App\Services\InvoiceService $invoiceService)
    {
        try {
            $invoiceService->approveInvoice($id, $request->selling_qty);
        } catch (\Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

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

        $sdate = date('Y-m-d', strtotime($request->start_date));
        $edate = date('Y-m-d', strtotime($request->end_date));

        $allData = Invoice::whereBetween('date', [$sdate, $edate])->where('status', '1')->get();

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
