<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInformation extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
        'id',
        'user_id',
        'secondary_email',
        'phone',
        'alternate_phone',
        'address',
        'city',
        'state',
        'year_purchased',
        'about_you',
        'term_conditions',
    ];
}
