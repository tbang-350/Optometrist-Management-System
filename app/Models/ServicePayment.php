<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer()
    {

        return $this->belongsTo(Customer::class, 'customer_id', 'id');

    } // End Method


    public function service_invoice()
    {

        return $this->belongsTo(ServiceInvoice::class, 'service_invoice_id', 'id');

    } // End Method
}
