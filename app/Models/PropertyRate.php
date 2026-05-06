<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyRate extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'property_id',
        'session_name', 
        'start_date',
        'end_date',
        'nightly_rate', 
        'weekly_rate',
        'weekend_rate',
        'monthly_rate',
        'minimum_stay'
    ];
}
