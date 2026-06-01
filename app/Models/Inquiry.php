<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $table = 'property_inquiries';

    protected $fillable = [
        'property_id', 'property_name', 'first_name', 'last_name',
        'phone', 'email', 'checkin', 'checkout', 'adults', 'children',
        'message', 'source',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
