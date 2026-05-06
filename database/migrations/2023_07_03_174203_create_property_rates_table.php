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
        Schema::create('property_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("property_id");
            $table->foreign('property_id')->references('id')->on('properties')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('session_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->float('nightly_rate',10,2)->nullable();
            $table->float('weekly_rate',10,2)->nullable();
            $table->float('weekend_rate',10,2)->nullable();
            $table->integer('minimum_stay');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_rates');
    }
};
