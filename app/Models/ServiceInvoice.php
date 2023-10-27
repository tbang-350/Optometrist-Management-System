<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceInvoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function service_payment()
    {

        return $this->belongsTo(ServicePayment::class, 'id', 'service_invoice_id');

    }


    public function service_invoice_details()
    {

        return $this->hasMany(ServiceInvoiceDetails::class, 'service_invoice_id', 'id');

    }
}
