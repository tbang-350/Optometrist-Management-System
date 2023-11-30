<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\PurchasesImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PurchaseController extends Controller
{

    public function PurchaseAll()
    {

        $current_location = Auth::user()->location_id;

        if ($current_location == 1) {

            $allData = Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->get();

        } else {

            $allData = Purchase::where('location_id', $current_location)
                ->orderBy('date', 'desc')
                ->orderBy('id', 'desc')
                ->get();

        }

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

        // Get the current date
        $date = date('Y-m-d');

        return view('backend.purchase.purchase_add', compact('supplier', 'unit', 'category', 'purchase_no', 'date'));

    } // End Method

    public function PurchaseStore(Request $request)
    {

        $category = Category::firstOrCreate(
            ['name' => $request->category_name, 'location_id' => Auth::user()->location_id],
            ['created_by' => Auth::user()->id, 'created_at' => Carbon::now()]
        );

        $product = Product::firstOrCreate(
            ['name' => $request->product_name, 'supplier_name' => $request->supplier_name, 'category_id' => $category->id, 'location_id' => Auth::user()->location_id],
            ['created_by' => Auth::user()->id, 'created_at' => Carbon::now()]
        );

        // Update the quantity of the product
        $purchase_qty = ((float) $request->buying_qty) + ((float) $product->quantity);
        $product->quantity = $purchase_qty;
        $product->save();

        $purchase = new Purchase();
        $purchase->date = date('Y-m-d', strtotime($request->date));
        $purchase->category_id = $category->id;
        $purchase->product_id = $product->id;
        $purchase->purchase_no = $request->purchase_no;
        $purchase->supplier_name = $request->supplier_name;
        $purchase->buying_qty = $request->buying_qty;
        $purchase->buying_unit_price = $request->buying_unit_price;
        $purchase->selling_unit_price = $request->selling_unit_price;

        $total = $request->buying_qty * $request->buying_unit_price;

        $purchase->total_buying_amount = $total;

        $purchase->location_id = Auth::user()->location_id;
        $purchase->created_by = Auth::user()->id;
        $purchase->created_at = Carbon::now();

        $purchase->save();

        $notification = array(
            'message' => 'Purchase Added successfully',
            'alert-type' => 'success',
        );

        if ($request->has('submit_and_new')) {

            return redirect()->route('purchase.add')->with($notification);

        } else {

            return redirect()->route('purchase.all')->with($notification);

        }

        // dd([$purchase,$supplier,$category,$product]);
    }

    // End Method

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

        $current_location = Auth::user()->location_id;

        if ($current_location == 1) {

            $allData = Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->get();

        } else {

            $allData = Purchase::where('location_id', $current_location)
                ->orderBy('date', 'desc')
                ->orderBy('id', 'desc')
                ->get();

        }

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
        $current_location = Auth::user()->location_id;

        $sdate = date('Y-m-d', strtotime($request->start_date));
        $edate = date('Y-m-d', strtotime($request->end_date));

        if ($current_location == 1) {

            $allData = Purchase::whereBetween('date', [$sdate, $edate])->where('status', '1')->get();

        } else {

            $allData = Purchase::where('location_id', $current_location)
                ->whereBetween('date', [$sdate, $edate])
                ->where('status', '1')
                ->get();

        }

        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));

        return view('backend.pdf.daily_purchase_report_pdf', compact('allData', 'start_date', 'end_date'));
    }

    public function PurchaseUpload_old(Request $request)
    {

        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        Excel::import(new PurchasesImport, $request->file('file'));

        $notification = array(
            'message' => 'Purchase imported successfully',
            'alert-type' => 'success',
        );

        return back()->with($notification);

        dd($excel_data);

    }

    public function PurchaseUpload(Request $request)
    {

        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        ini_set('max_execution_time', 300);
        $data = uploadExcel();
        $status = checkKeysExists($data, ['supplier_name', 'category_name', 'product_name', 'date', 'buying_qty', 'buying_unit_price', 'selling_unit_price', 'status']);
        if ($status == 1) {
            $supplier_name = [];
            $category_name = [];
            $product_name = [];
            $date = [];
            $buying_qty = [];
            $buying_unit_price = [];
            $selling_unit_price = [];
            $status = [];

            foreach ($data as $row) {
                $supplier_name[] = $row['supplier_name'];
                $category_name[] = $row['category_name'];
                $product_name[] = $row['product_name'];
                $date[] = $row['date'];
                $buying_qty[] = $row['buying_qty'];
                $buying_unit_price[] = $row['buying_unit_price'];
                $selling_unit_price[] = $row['selling_unit_price'];
                $status[] = $row['status'];
            } //kama kuna validation yoyote kuhusiana na group ya data i mean each column basi hapa ndio unaweza kuweka coz each array inabeba data zote za column husika.

            //tuendelee na import ya data zetu sasa
            DB::beginTransaction();
            $i = 0;
            $j = 0;
            foreach ($data as $row) {

                $date = Date::excelToDateTimeObject($row['date']);
                $lastPurchase = Purchase::orderBy('id', 'desc')->first();
                $purchase_no = $lastPurchase ? $lastPurchase->purchase_no + 1 : 1;

                $category = Category::firstOrCreate(
                    ['name' => $row['category_name'], 'location_id' => Auth::user()->location_id],
                    ['created_by' => Auth::user()->id, 'created_at' => Carbon::now()]
                );
                $product = Product::firstOrCreate(
                    ['name' => $row['product_name'], 'supplier_name' => $row['supplier_name'], 'category_id' => $category->id, 'location_id' => Auth::user()->location_id],
                    ['created_by' => Auth::user()->id, 'created_at' => Carbon::now()]
                );
                $purchase_qty = ((float) $row['buying_qty']) + ((float) $product->quantity);
                $product->quantity = $purchase_qty;
                $product->save();
                //check if the purchase already exists in the database before inserting
                $purchase = Purchase::where('date', $date->format('Y-m-d'))
                    ->where('category_id', $category->id)
                    ->where('product_id', $product->id)
                    ->where('supplier_name', $row['supplier_name'])
                    ->where('location_id', Auth::user()->location_id)
                    ->first();
                if (!$purchase && !empty(trim($row['supplier_name'])) && !empty(trim($row['buying_qty'])) && !empty(trim($row['buying_unit_price'])) && !empty(trim($row['selling_unit_price'])) && !empty(trim($row['category_name'])) && !empty(trim($row['product_name']))) {
                    $i++;
                    $purchase = new Purchase();
                    $purchase->date = $date->format('Y-m-d');
                    $purchase->category_id = $category->id;
                    $purchase->product_id = $product->id;
                    $purchase->purchase_no = $purchase_no;
                    $purchase->supplier_name = $row['supplier_name'];
                    $purchase->buying_qty = (float) $row['buying_qty'];
                    $purchase->buying_unit_price = (float) $row['buying_unit_price'];
                    $purchase->selling_unit_price = (float) $row['selling_unit_price'];
                    $purchase->total_buying_amount = (float) $row['buying_qty'] * (float) $row['buying_unit_price'];
                    $purchase->location_id = Auth::user()->location_id;
                    $purchase->created_by = Auth::user()->id;
                    $purchase->created_at = Carbon::now();
                    $purchase->save();
                } else {
                    //update the purchase incase it exists ()
                    //update buying_qty by adding the new buying_qty to the existing buying_qty
                    //update total_buying_amount by adding the new total_buying_amount to the existing total_buying_amount
                    //update the updated_at column
                    if ($purchase) {
                        $j++;
                        $purchase->insert([
                            'date' => $date->format('Y-m-d'),
                            'supplier_name' => $row['supplier_name'],
                            'category_id' => $category->id,
                            'product_id' => $product->id,
                            'purchase_no' => $purchase_no,
                            'buying_qty' => (float) $row['buying_qty'],
                            'buying_unit_price' => (float) $row['buying_unit_price'],
                            'selling_unit_price' => (float) $row['selling_unit_price'],
                            'total_buying_amount' => (float) $row['buying_qty'] * (float) $row['buying_unit_price'],
                            'status' => (float) $row['status'],
                            'location_id' => Auth::user()->location_id,
                            'created_by' => Auth::user()->id,
                            'created_at' => Carbon::now(),

                        ]);
                    }

                }
            }
            DB::commit();
            $notification = array(
                'message' => $i . ' Purchase imported successfully' . ($j > 0 ? ' and ' . $j . ' Existing purchases updated' : ''),
                'alert-type' => 'success',
            );
            return back()->with($notification);

        } else {
            $notification = array(
                'message' => $status,
                'alert-type' => 'error',
            );
            return back()->with($notification);
        }

    }

}
