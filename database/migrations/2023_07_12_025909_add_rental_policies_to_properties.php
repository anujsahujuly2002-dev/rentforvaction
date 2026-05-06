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
            $table->longText("rental_policies")->nullable()->after('rates_notes');
            $table->longText("cancel_polices")->nullable()->after('rental_policies');
            $table->string('upload_rental_policies')->nullable()->after('cancel_polices');
            $table->string('upload_cancel_policies')->nullable()->after('upload_rental_policies');
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
