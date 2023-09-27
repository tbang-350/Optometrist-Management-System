<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;

class DefaultController extends Controller
{

    public function GetCategory(Request $request)
    {

        $supplier_id = $request->supplier_id;
        // dd($supplier_id);

        $allCatagory = Product::with(['category'])->select('category_id')->where('supplier_id', $supplier_id)->groupBy('category_id')->get();

        return response()->json($allCatagory);

    }// End Method

    public function GetProduct(Request $request)
    {

        $category_id = $request->category_id;

        $allProduct = Product::where('category_id', $category_id)->get();

        return response()->json($allProduct);

    }// End Method


    public function GetStock(Request $request){

        $product_id = $request->product_id;

        $stock = Product::where('id', $product_id)->first()->quantity;

        return response()->json($stock);


    }// End Method


    public function GetBuyingUnitPrice(Request $request) {
        $product_id = $request->product_id;

        $latestPurchase = Purchase::where('product_id', $product_id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($latestPurchase) {
            $unit_price = $latestPurchase->unit_price;
            return response()->json($unit_price);
        } else {
            // Handle the case where there are no purchases for the specified product.
            // You can return a default value or an error response.
            return response()->json(['error' => 'No purchase found for this product.']);
        }
    }


}
