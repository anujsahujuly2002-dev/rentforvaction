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
        Schema::create('property_amenites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('properties')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('amenites_id');
            $table->foreign('amenites_id')->references('id')->on('aminities')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('sub_amenites_id');
            $table->foreign('sub_amenites_id')->references('id')->on('sub_amenities')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('child_amenites_id')->nullable();
            $table->foreign('child_amenites_id')->references('id')->on('third_level_amenities')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_amenites');
    }
};
