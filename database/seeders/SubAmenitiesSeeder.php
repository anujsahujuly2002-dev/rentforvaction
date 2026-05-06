<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubAmenities;

class SubAmenitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubAmenities::create([
            'amenities_id'=>8,
            'name'=>"Breakfast",
            'description'=>"0",
            'status'=>1
        ]);
        SubAmenities::create([
            'amenities_id'=>8,
            'name'=>"Housekeeping",
            'description'=>"0",
            'status'=>1
        ]);
        SubAmenities::create([
            'amenities_id'=>8,
            'name'=>"Other services",
            'description'=>"0",
            'status'=>1 
        ]);
    //    SubAmenities::create([
    //         'amenities_id'=>6,
    //         'name'=>"Printer",
    //         'description'=>"0",
    //         'status'=>1
    //     ]);
         /* 
        SubAmenities::create([
            'amenities_id'=>2,
            'name'=>"Dining",
            'description'=>"1",
            'status'=>1
        ]); */
        /* SubAmenities::create([
            'amenities_id'=>2,
            'name'=>"fax",
            'description'=>"0",
            'status'=>1
        ]);
        SubAmenities::create([
            'amenities_id'=>2,
            'name'=>"safe",
            'description'=>"0",
            'status'=>1
        ]);
        SubAmenities::create([
            'amenities_id'=>2,
            'name'=>"shampoo",
            'description'=>"0",
            'status'=>1
        ]);
        SubAmenities::create([
            'amenities_id'=>2,
            'name'=>"telephone",
            'description'=>"1",
            'status'=>1
        ]);
        SubAmenities::create([
            'amenities_id'=>2,
            'name'=>"fireplace",
            'description'=>"1",
            'status'=>1
        ]);
        SubAmenities::create([
            'amenities_id'=>2,
            'name'=>"garage",
            'description'=>"1",
            'status'=>1
        ]);
        SubAmenities::create([
            'amenities_id'=>2,
            'name'=>"travel crib",
            'description'=>"0",
            'status'=>1
        ]);
        SubAmenities::create([
            'amenities_id'=>2,
            'name'=>"wood stove",
            'description'=>"1",
            'status'=>1
        ]);
        SubAmenities::create([
            'amenities_id'=>2,
            'name'=>"internet",
            'description'=>"1",
            'status'=>1
        ]);
        SubAmenities::create([
            'amenities_id'=>2,
            'name'=>"living room",
            'description'=>"1",
            'status'=>1
        ]); */
    }
}
