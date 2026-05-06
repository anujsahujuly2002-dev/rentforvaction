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
        Schema::table('properties', function (Blueprint $table) {
            $table->enum('pet_allowed',[0,1])->nullable()->comment('0=No,1=Yes')->default(0)->after('tax_rates');
            $table->enum('smoking_allowed',[0,1])->nullable()->comment('0=No,1=Yes')->default(0)->after('pet_allowed');
            $table->enum('property_approved',[0,1])->nullable()->comment('0=inactive,1=active')->default(0)->after('ical_link');
            $table->date('subscription_date')->nullable()->after('property_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            //
        });
    }
};
