<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{

    public function ProductAll()
    {

        $current_location = Auth::user()->location_id;

        if ($current_location == 1) {

            $products = Product::latest()->get();

        } else {

            $products = Product::latest()->where("location_id", $current_location)->get();

        }


        return view('backend.product.product_all', compact('products'));

    } // End Method

    public function ProductAdd()
    {
        $supplier = Supplier::all();
        $category = Category::all();

        return view('backend.product.product_add', compact('supplier', 'category'));

    } // End Method

    public function ProductStore(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'supplier_name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        Product::insert([
            'name' => $request->name,
            'supplier_name' => $request->supplier_name,
            'category_id' => $request->category_id,
            'quantity' => '0',
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'location_id' => Auth::user()->location_id,
        ]);

        $notification = array(
            'message' => 'Product Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('product.all')->with($notification);
    } // End Method

    public function ProductEdit($id)
    {

        $supplier = Supplier::all();
        $category = Category::all();

        $product = Product::findOrFail($id);

        return view('backend.product.product_edit', compact('supplier', 'category', 'product'));

    } //End Method

    public function ProductUpdate(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'supplier_name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        $product_id = $request->id;

        Product::findOrFail($product_id)->update([
            'name' => $request->name,
            'supplier_name' => $request->supplier_name,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'reorder_level' => $request->reorder_level,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Product Updated Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('product.all')->with($notification);
    } // End Method


    public function ProductDelete($id)
    {

        // $product = Product::findOrFail($id);
        // $img = $product->product_image;
        // unlink($img);

        Product::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    } // End Method

}
