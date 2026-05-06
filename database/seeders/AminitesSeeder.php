<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aminities;

class AminitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Aminities::create([
            'name'=>'Essentials',
            'description'=>'The basics for a comfortable stay'
        ]);
        Aminities::create([
            'name'=>'General',
            'description'=>'Popular amenities like parking, travel crib and more'
        ]);
        Aminities::create([
            'name'=>'Kitchen and dining',
            'description'=>'What’s available for cooking and eating together'
        ]);
        Aminities::create([
            'name'=>'Entertainment',
            'description'=>'Games, music and television entertainment'
        ]);
        Aminities::create([
            'name'=>'Pool and spa facilities',
            'description'=>'Pool, hot tub, sauna and more'
        ]);
        Aminities::create([
            'name'=>'Office',
            'description'=>'Amenities for remote work'
        ]);
        Aminities::create([
            'name'=>'Outdoor features',
            'description'=>'Activities and equipment to enjoy the outdoors'
        ]);
        Aminities::create([
            'name'=>'On-site services',
            'description'=>'On-site services like breakfast, housekeeping and meal delivery'
        ]);
    }
}
