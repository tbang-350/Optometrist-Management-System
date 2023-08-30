<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer()
    {

        return $this->belongsTo(Customer::class, 'customer_id', 'id');

    } // End Method


    public function prescription()
    {

        return $this->belongsTo(Prescription::class, 'prescription_id', 'id');

    } // End Method


}
