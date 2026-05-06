<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PropertySuitablity;

class PropertySuitablitySeedr extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PropertySuitablity::create([
            'name'=>"Romantic Vacation Rentals",
        ]);
        PropertySuitablity::create([
            'name'=>"Beach Vacation Rentals",
        ]);
        PropertySuitablity::create([
            'name'=>"Honeymoon Vacation Rentals",
        ]);
        PropertySuitablity::create([
            'name'=>"Fishing Vacation Rentals",
        ]);
        PropertySuitablity::create([
            'name'=>"Snowbird / Longterm Vacation Rentals",
        ]);
        PropertySuitablity::create([
            'name'=>"Wedding Vacation Rentals",
        ]);
        PropertySuitablity::create([
            'name'=>"Golf Vacation Rentals",
        ]);
        PropertySuitablity::create([
            'name'=>"Ski Vacation Rentals",
        ]);
        PropertySuitablity::create([
            'name'=>"Hiking Vacation Rentals",
        ]);
        PropertySuitablity::create([
            'name'=>"Campground Vacation Rentals",
        ]);
        PropertySuitablity::create([
            'name'=>"RV Vacation Rentals",
        ]);
        PropertySuitablity::create([
            'name'=>"Pet Friendly Vacation Rentals",
        ]);
        PropertySuitablity::create([
            'name'=>"Luxury Vacation Rentals",
        ]);
        PropertySuitablity::create([
            'name'=>"Budget Friendly Vacation Rentals",
        ]);
    }
}
