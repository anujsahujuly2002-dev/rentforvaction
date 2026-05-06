<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('added_by');
            $table->foreign('added_by')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string("property_name");
            $table->json('property_suitablity_id');
            $table->string('property_image');
            $table->decimal('square_feet');
            $table->unsignedBigInteger('property_types_id');
            $table->foreign('property_types_id')->references('id')->on('property_types')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('bedrooms');
            $table->float('sleeps',10,2);
            $table->float("avg_night",10,2);
            $table->string('rate_per_unit');
            $table->float('bathrooms',10,2);
            $table->text('description');
            $table->unsignedBigInteger('country_id'); 
            $table->foreign('country_id')->references('id')->on('countries')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger("state_id");
            $table->foreign('state_id')->references('id')->on('states')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('region_id');
            $table->foreign('region_id')->references('id')->on('regions')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('sub_city_id')->nullable();
            $table->string('extrnal_link')->nullable();
            $table->string('personal_website_link')->nullable();
            $table->string('address')->nullable();
            $table->string('iframe_link')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->decimal('admin_fees',10, 2)->nullable();
            $table->decimal('cleaning_fees',10, 2)->nullable();
            $table->float('refundable_damage_deposite',10,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
