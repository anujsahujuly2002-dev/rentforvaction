<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAmenities extends Model
{
    use HasFactory;

    public function child_amienites(){
        return $this->hasMany(ThirdLevelAmenities::class,'sub_amenities_id','id');
    }
}
