<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payment()
    {

        return $this->belongsTo(Payment::class, 'id', 'prescription_id');

    }


    public function prescription_details()
    {

        return $this->hasMany(PrescriptionDetails::class, 'prescription_id', 'id');

    }

}
