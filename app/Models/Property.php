<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory,SoftDeletes;

    protected $casts = [
        'property_suitablity_id' => 'array'
    ];
    protected $fillable=[
        'id',
        'user_id',
        'added_by',
        'property_name',
        'property_suitablity_id',
        'property_image',
        'square_feet',
        'property_types_id',
        'bedrooms',
        'sleeps',
        'avg_night',
        'rate_per_unit',
        'bathrooms',
        'description',
        'country_id',
        'state_id',
        'region_id',
        'city_id',
        'sub_city_id',
        'extrnal_link',
        'personal_website_link',
        'address',
        'iframe_link',
        'latitude',
        'longitude',
        'admin_fees',
        'cleaning_fees',
        'refundable_damage_deposite',
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function(Property $property) {
            foreach ($property->property_amenites()->get() as $propertyAmenity) {
                $propertyAmenity->delete();
            }
        });
        static::deleting(function(Property $property) {
            foreach ($property->galleryImage()->get() as $galleryImage) {
                $galleryImage->delete();
            }
        });

        static::deleting(function(Property $property) {
            foreach ($property->propertyReviews()->get() as $propertyReview) {
                $propertyReview->delete();
            }
        });
        static::deleting(function(Property $property) {
            foreach ($property->propertyRates()->get() as $propertyRate) {
                $propertyRate->delete();
            }
        });
        static::deleting(function(Property $property) {
            foreach ($property->featuredProperty()->get() as $featureProperty) {
                $featureProperty->delete();
            }
        });
        static::deleting(function(Property $property) {
            foreach ($property->propertyBooking()->get() as $propertyBooking) {
                $propertyBooking->delete();
            }
        });
        static::deleting(function(Property $property) {
            foreach ($property->recommendation()->get() as $recommendation) {
                $recommendation->delete();
            }
        });


    }

    public function property_amenites() {
        return $this->hasMany(PropertyAmenites::class,'property_id','id');
    }

    public function galleryImage() {
        return $this->hasMany(PropertyGalleryImage::class,'property_id','id');
    }

    public function propertyReviews() {
        return $this->hasMany(PropertyReviews::class,'property_id','id');
    }

    public function propertyRates() {
        return $this->hasMany(PropertyRate::class,'property_id','id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function userInformation() {
        return $this->belongsTo(UserInformation::class,'user_id','user_id');
    }

    public function featuredProperty(){
        return $this->hasOne(FeaturedProperty::class,'property_id');
    }

    public function city(){
        return $this->BelongsTo(City::class,'city_id','id');
    }

    public function state() {
        return $this->belongsTo(State::class,'state_id','id');
    }

    public function propertyType() {
        return $this->belongsTo(PropertyTypes::class,'property_types_id','id');
    }

    public function aminities() {
        return $this->hasMany(PropertyAmenites::class,'property_id','id')->groupBy('amenites_id');
    }

    public function propertyBooking() {
        return $this->hasMany(PropertyBooking::class,'property_id','id');
    }

    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function region(){
        return $this->belongsTo(Region::class,'region_id','id');
    }

    public function subCity(){
        return $this->belongsTo(SubCity::class,'sub_city_id','id');
    }

    public function recommendation() {
        return $this->hasOne(Recommendation::class,'property_id');
    }

}

