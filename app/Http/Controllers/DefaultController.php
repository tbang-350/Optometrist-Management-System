<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Service;
use Auth;
use Illuminate\Http\Request;

class DefaultController extends Controller
{

    public function GetCategory(Request $request)
    {

        $supplier_id = $request->supplier_id;
        // dd($supplier_id);

        $allCatagory = Product::with(['category'])->select('category_id')->where('supplier_id', $supplier_id)->groupBy('category_id')->get();

        return response()->json($allCatagory);

    } // End Method

    public function GetProduct(Request $request)
    {

        $category_id = $request->category_id;

        $allProduct = Product::where('category_id', $category_id)
            ->where('quantity', '>', 0) // Fetch products with quantity greater than zero
            ->get();

        return response()->json($allProduct);

    } // End Method

    public function GetStock(Request $request)
    {

        $product_id = $request->product_id;

        $stock = Product::where('id', $product_id)->first()->quantity;

        return response()->json($stock);

    } // End Method

    public function GetBuyingUnitPrice(Request $request)
    {
        $product_id = $request->product_id;

        $latestPurchase = Purchase::where('product_id', $product_id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($latestPurchase) {
            $unit_price = $latestPurchase->selling_unit_price;
            return response()->json($unit_price);
        } else {
            // Handle the case where there are no purchases for the specified product.
            // You can return a default value or an error response.
            return response()->json(['error' => 'No purchase found for this product.']);
        }
    } // End Method

    public function GetServicePrice(Request $request)
    {
        $service_id = $request->service_id;

        $latestService = Service::where('id', $service_id)
            ->orderBy('created_at', 'desc')
            ->first();

        // dd($latestService->service_price);

        if ($latestService) {
            $service_price = $latestService->service_price;
            return response()->json($service_price);
        } else {
            // Handle the case where there are no price for the specified service.
            // You can return a default value or an error response.
            return response()->json(['error' => 'No price found for this service.']);
        }
    } // End Method

    public function AutocompleteSuppliers(Request $request)
    {

        $currrent_location = Auth::user()->location_id;

        if ($currrent_location == 1) {

            $data = Product::select("supplier_name")
                ->where('supplier_name', 'LIKE', '%' . $request->get('query') . '%')
                ->get();

        } else {

            $data = Product::select("supplier_name")
                ->where('supplier_name', 'LIKE', '%' . $request->get('query') . '%')
                ->where('location_id', $currrent_location)
                ->get();

        }

        return response()->json($data);

    } // End Method

    public function AutocompleteCategories(Request $request)
    {
        $currrent_location = Auth::user()->location_id;

        if ($currrent_location == 1) {

            $data = Category::select("name")
                ->where('name', 'LIKE', '%' . $request->get('query') . '%')
                ->get();

        } else {

            $data = Category::select("name")
                ->where('name', 'LIKE', '%' . $request->get('query') . '%')
                ->where('location_id', $currrent_location)
                ->get();

        }

        return response()->json($data);
    } // End Method

    public function AutocompleteProducts(Request $request)
    {
        $currrent_location = Auth::user()->location_id;

        if ($currrent_location == 1) {

            $data = Product::select("name")
                ->where('name', 'LIKE', '%' . $request->get('query') . '%')
                ->get();

        } else {

            $data = Product::select("name")
                ->where('name', 'LIKE', '%' . $request->get('query') . '%')
                ->where('location_id', $currrent_location)
                ->get();

        }

        return response()->json($data);
    } // End Method

    public function GetCustomerDetails(Request $request)
    {
        $customer_id = $request->customer_id;

        // Fetch customer details from the database based on $customer_id
        $customer = Customer::find($customer_id);

        // Prepare the response data
        $data = [
            'name' => $customer->name,
            'age' => $customer->age,
            'sex' => $customer->sex,
            'address' => $customer->address,
            'phonenumber' => $customer->phonenumber,
        ];

        return response()->json($data);
    }

}
