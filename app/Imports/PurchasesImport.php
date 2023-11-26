<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PurchasesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Log::info($row);

        if (in_array(null, $row) || in_array(' ', $row)) {
            return null;
        }

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

       // Update the quantity of the product
       $purchase_qty = ((float) $row['buying_qty']) + ((float) $product->quantity);
       $product->quantity = $purchase_qty;
       $product->save();

       return new Purchase([
           'date' => $date->format('Y-m-d'),
           'supplier_name' => $row['supplier_name'],
           'category_id' => $category->id,
           'product_id' => $product->id,
           'purchase_no' => $purchase_no,
           'buying_qty' => $row['buying_qty'],
           'buying_unit_price' => $row['buying_unit_price'],
           'selling_unit_price' => $row['selling_unit_price'],
           'total_buying_amount' => $row['buying_qty'] * $row['buying_unit_price'],
           'status' => $row['status'],
           'location_id' => Auth::user()->location_id,
           'created_by' => Auth::user()->id,
           'created_at' => Carbon::now(),
       ]);
    }
}
