<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ThirdLevelAmenities;

class ThirdLevelAmenitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ThirdLevelAmenities::create([
            'amenities_id'=>8,
            'sub_amenities_id'=>45,
            'name'=>"Included in price",
            'description'=>"0"
        ]);
        ThirdLevelAmenities::create([
            'amenities_id'=>8,
            'sub_amenities_id'=>45,
            'name'=>"Booking possible",
            'description'=>"0"
        ]);
         ThirdLevelAmenities::create([
            'amenities_id'=>8,
            'sub_amenities_id'=>45,
            'name'=>"Not available",
            'description'=>"0"
        ]);

        ThirdLevelAmenities::create([
            'amenities_id'=>8,
            'sub_amenities_id'=>46,
            'name'=>"Housekeeping included",
            'description'=>"0"
        ]);
        ThirdLevelAmenities::create([
            'amenities_id'=>8,
            'sub_amenities_id'=>46,
            'name'=>"Housekeeper optional",
            'description'=>"0"
        ]);
        ThirdLevelAmenities::create([
            'amenities_id'=>8,
            'sub_amenities_id'=>46,
            'name'=>"Ask owner",
            'description'=>"0"
        ]);
        
        ThirdLevelAmenities::create([
            'amenities_id'=>8,
            'sub_amenities_id'=>47,
            'name'=>"Car available",
            'description'=>"0"
        ]);
        ThirdLevelAmenities::create([
            'amenities_id'=>8,
            'sub_amenities_id'=>47,
            'name'=>"Massage",
            'description'=>"0"
        ]);
        ThirdLevelAmenities::create([
            'amenities_id'=>8,
            'sub_amenities_id'=>47,
            'name'=>"Chauffeur",
            'description'=>"1"
        ]);

        ThirdLevelAmenities::create([
            'amenities_id'=>8,
            'sub_amenities_id'=>47,
            'name'=>"Meal delivery",
            'description'=>"0"
        ]);
        ThirdLevelAmenities::create([
            'amenities_id'=>8,
            'sub_amenities_id'=>47,
            'name'=>"Childcare",
            'description'=>"0"
        ]);
        ThirdLevelAmenities::create([
            'amenities_id'=>8,
            'sub_amenities_id'=>47,
            'name'=>"Private chef",
            'description'=>"0"
        ]);
        ThirdLevelAmenities::create([
            'amenities_id'=>8,
            'sub_amenities_id'=>47,
            'name'=>"Concierge",
            'description'=>"0"
        ]);
        
       
    }
}
