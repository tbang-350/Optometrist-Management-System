<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Auth;
use Illuminate\Http\Request;

class StockController extends Controller
{

    public function StockReport()
    {

        $current_location = Auth::user()->location_id;

        if ($current_location == 1) {

            $allData = Product::orderBy('category_id', 'asc')->get();

        } else {

            $allData = Product::orderBy('category_id', 'asc')->where('location_id', $current_location)->get();

        }

        return view('backend.stock.stock_report', compact('allData'));

    } // End Method

    public function StockReportPdf()
    {
        
        $current_location = Auth::user()->location_id;

        if ($current_location == 1) {

            $allData = Product::orderBy('category_id', 'asc')->get();

        } else {

            $allData = Product::orderBy('category_id', 'asc')->where('location_id', $current_location)->get();

        }

        return view('backend.pdf.stock_report_pdf', compact('allData'));

    } // End Method

    public function StockSupplierWise()
    {

        $suppliers = Supplier::all();
        $category = Category::all();

        return view('backend.stock.supplier_product_wise_report', compact('suppliers', 'category'));

    } // End Method

    public function SupplierWisePdf(Request $request)
    {

        $allData = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->where('supplier_id', $request->supplier_id)->get();

        return view('backend.pdf.supplier_wise_report_pdf', compact('allData'));

    } // End Method

    public function ProductWisePdf(Request $request)
    {

        $product = Product::where('category_id', $request->category_id)->where('id', $request->product_id)->first();

        return view('backend.pdf.product_wise_report_pdf', compact('product'));

    } // End Method

}
