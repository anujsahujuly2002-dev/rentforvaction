<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyAmenites extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'id',
        'property_id', 
        'amenites_id',
        'sub_amenites_id',
        'child_amenites_id',
        'description',
    ];

    public function aminities(){
        return $this->belongsTo(Aminities::class,'amenites_id','id');
    }

    public function sub_amenities() {
        return $this->belongsTo(SubAmenities::class,'sub_amenites_id','id');
    }

    public function child_amenities() {
        return $this->belongsTo(ThirdLevelAmenities::class,'child_amenites_id','id') ;
    }
}
  