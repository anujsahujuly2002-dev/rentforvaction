<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recommendation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'property_id',
        'is_recommended'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
