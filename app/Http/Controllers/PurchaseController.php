<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Unit;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PurchaseController extends Controller
{

    public function PurchaseAll()
    {

        $allData = Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->get();

        return view('backend.purchase.purchase_all', compact('allData'));

    } // End Method

    public function PurchaseAdd()
    {

        $supplier = Supplier::all();
        $unit = Unit::all();
        $category = Category::all();

        // get the last purchase_no and increment it by 1
        $purchase_data = Purchase::orderBy('id', 'desc')->first();
        $purchase_no = $purchase_data ? $purchase_data->purchase_no + 1 : 1;

        return view('backend.purchase.purchase_add', compact('supplier', 'unit', 'category', 'purchase_no'));

    } // End Method

    public function PurchaseStore(Request $request)
    {

        if ($request->category_id === null) {

            $notification = array(
                'message' => 'Sorry , no item selected',
                'alert-type' => 'warning',
            );

            return redirect()->back()->with($notification);

        } else {

            $count_category = count($request->category_id);

            for ($i = 0; $i < $count_category; $i++) {
                $purchase = new Purchase();
                $purchase->date = date('Y-m-d', strtotime($request->date[$i]));
                $purchase->purchase_no = $request->purchase_no[$i];
                $purchase->supplier_id = $request->supplier_id[$i];
                $purchase->purchase_no = $request->purchase_no[$i];
                $purchase->category_id = $request->category_id[$i];
                $purchase->product_id = $request->product_id[$i];

                $purchase->buying_qty = $request->buying_qty[$i];
                $purchase->unit_price = $request->unit_price[$i];
                $purchase->buying_price = $request->buying_price[$i];
                $purchase->description = $request->description[$i];

                $purchase->created_by = Auth::user()->id;
                $purchase->created_at = Carbon::now();
                $purchase->status = '1';

                $purchase->save();

                $product = Product::findOrFail($request->product_id[$i]);
                $purchase_qty = ((float) $request->buying_qty[$i]) + ((float) $product->quantity);
                $product->quantity = $purchase_qty;
                $product->save();

            }

        }

        $notification = array(
            'message' => 'Data Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('purchase.all')->with($notification);

    } // End Method

    public function PurchaseDelete($id)
    {

        Purchase::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Purchase Deleted successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    } //  End Method

    public function PurchasePending()
    {

        $allData = Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '0')->get();

        return view('backend.purchase.purchase_pending', compact('allData'));

    } // End Method

    // public function PurchaseApprove($id)
    // {

    //     $purchase = Purchase::findOrFail($id);
    //     $product = Product::where('id', $purchase->product_id)->first();
    //     $purchase_qty = ((float) ($purchase->buying_qty)) + ((float) ($product->quantity));
    //     $product->quantity = $purchase_qty;

    //     if ($product->save()) {

    //         Purchase::findOrFail($id)->update([
    //             'status' => '1',
    //         ]);

    //         $notification = array(
    //             'message' => 'Status Approved successfully',
    //             'alert-type' => 'success',
    //         );

    //         return redirect()->route('purchase.pending')->with($notification);

    //     }
    // } // End Method

    public function DailyPurchaseReport()
    {

        return view('backend.purchase.daily_purchase_report');

    } // End Method

    public function DailyPurchasePdf(Request $request)
    {

        $sdate = date('Y-m-d', strtotime($request->start_date));
        $edate = date('Y-m-d', strtotime($request->end_date));

        $allData = Purchase::whereBetween('date', [$sdate, $edate])->where('status', '1')->get();

        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));

        return view('backend.pdf.daily_purchase_report_pdf', compact('allData', 'start_date', 'end_date'));

    } // End Method

}
