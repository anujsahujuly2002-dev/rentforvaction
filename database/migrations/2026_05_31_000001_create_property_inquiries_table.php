<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_inquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('property_name', 200)->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('phone', 20);
            $table->string('email', 150);
            $table->date('checkin')->nullable();
            $table->date('checkout')->nullable();
            $table->tinyInteger('adults')->default(0);
            $table->tinyInteger('children')->default(0);
            $table->text('message')->nullable();
            $table->string('source', 20)->default('frontend');
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_inquiries');
    }
};
