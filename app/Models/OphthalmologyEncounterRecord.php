<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LocationScoped;

class OphthalmologyEncounterRecord extends Model
{
    use HasFactory, LocationScoped;

    protected $guarded = [];

    /**
     * Get the customer (patient) associated with the record.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the user (doctor) who created the record.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the location where the record was created.
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
