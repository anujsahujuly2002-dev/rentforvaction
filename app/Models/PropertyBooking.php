<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyBooking extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'id',
        'property_id',
        'start_date',
        'end_date',
        'events',
        'booking_time_stamps',
    ];
}
