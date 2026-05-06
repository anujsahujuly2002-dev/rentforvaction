<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeaturedProperty extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =[
        'property_id'
    ];

    public function property(){
        return $this->belongsTo(Property::class,'property_id');
    }
}
