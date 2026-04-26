<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Product;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function createInvoice(array $data)
    {
        return DB::transaction(function () use ($data) {
            $invoice = new Invoice();
            $invoice->invoice_no = $data['invoice_no'];
            $invoice->date = date('Y-m-d', strtotime($data['date']));
            $invoice->description = $data['description'] ?? null;
            $invoice->status = '0';
            $invoice->created_by = Auth::user()->id;
            $invoice->created_at = Carbon::now();
            $invoice->location_id = Auth::user()->location_id;
            $invoice->save();

            $count_category = count($data['category_id']);
            for ($i = 0; $i < $count_category; $i++) {
                $invoice_detail = new InvoiceDetail();
                $invoice_detail->date = date('Y-m-d', strtotime($data['date']));
                $invoice_detail->invoice_id = $invoice->id;
                $invoice_detail->category_id = $data['category_id'][$i];
                $productId = $data['product_id'][$i] ?? null;
                $invoice_detail->product_id = $productId !== '' ? $productId : null;
                $invoice_detail->product_name = $data['product_name'][$i] ?? null;
                $invoice_detail->selling_qty = $data['selling_qty'][$i];
                $invoice_detail->unit_price = $data['unit_price'][$i];
                $invoice_detail->selling_price = $data['selling_price'][$i];
                $invoice_detail->status = '0';
                $invoice_detail->created_at = Carbon::now();
                $invoice_detail->save();
            }

            $customer_id = $data['customer_id'];
            if ($customer_id == '0') {
                $customer = new Customer();
                $customer->name = $data['name'];
                $customer->phonenumber = $data['phonenumber'];
                $customer->address = $data['address'];
                $customer->age = $data['age'] ?? 0;
                $customer->sex = $data['sex'];
                $customer->location_id = Auth::user()->location_id;
                $customer->created_by = Auth::user()->id;
                $customer->created_at = Carbon::now();
                $customer->save();
                $customer_id = $customer->id;
            }

            $payment = new Payment();
            $payment_details = new PaymentDetail();

            $payment->invoice_id = $invoice->id;
            $payment->customer_id = $customer_id;
            $payment->paid_status = $data['paid_status'];
            $payment->payment_option = $data['payment_option'];
            $payment->discount_amount = $data['discount_amount'] ?? 0;
            $payment->markup_amount = $data['markup_amount'] ?? 0;
            $payment->total_amount = $data['estimated_amount'];
            $payment->created_at = Carbon::now();
            $payment->created_by = Auth::user()->id;
            $payment->location_id = Auth::user()->location_id;

            if ($data['paid_status'] == 'full_paid') {
                $payment->paid_amount = $data['estimated_amount'];
                $payment->due_amount = '0';
                $payment_details->current_paid_amount = $data['estimated_amount'];
            } elseif ($data['paid_status'] == 'partial_paid') {
                $payment->paid_amount = $data['paid_amount'] ?? 0;
                $payment->due_amount = $data['estimated_amount'] - ($data['paid_amount'] ?? 0);
                $payment_details->current_paid_amount = $data['paid_amount'] ?? 0;
            }

            $payment->save();

            $payment_details->invoice_id = $invoice->id;
            $payment_details->date = date('Y-m-d', strtotime($data['date']));
            $payment_details->location_id = Auth::user()->location_id;
            $payment_details->save();

            return $invoice;
        });
    }

    public function approveInvoice($id, array $sellingQuantities)
    {
        $invoiceDetailsIds = array_keys($sellingQuantities);
        $invoiceDetails = InvoiceDetail::whereIn('id', $invoiceDetailsIds)->get();
        if ($invoiceDetails->isEmpty()) {
            throw new Exception('Invalid invoice details.');
        }

        $productInvoiceDetails = $invoiceDetails->whereNotNull('product_id');
        $productIds = $productInvoiceDetails->pluck('product_id')->unique()->toArray();
        $products = $productIds ? Product::whereIn('id', $productIds)->get()->keyBy('id') : collect();

        foreach ($productInvoiceDetails as $detail) {
            $requestedQty = $sellingQuantities[$detail->id];
            $product = $products->get($detail->product_id);
            if (! $product || $product->quantity < $requestedQty) {
                throw new Exception("Insufficient stock: Product quantity is less than requested {$requestedQty}.");
            }
        }

        DB::transaction(function () use ($id, $sellingQuantities, $invoiceDetails, $products) {
            $invoice = Invoice::findOrFail($id);
            $invoice->updated_by = Auth::user()->id;
            $invoice->status = '1';
            $invoice->save();

            foreach ($invoiceDetails as $detail) {
                $detail->status = '1';
                $detail->save();

                if ($detail->product_id !== null) {
                    $product = $products->get($detail->product_id);
                    if ($product) {
                        $product->quantity = ((float) $product->quantity) - ((float) $sellingQuantities[$detail->id]);
                        $product->save();
                    }
                }
            }
        });

        return true;
    }
}
