<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyExportIcal extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'property_id',
        'ical_file_name'
    ];
}
