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
            $table->float("danage_waiver",10,2)->nullable()->after('refundable_damage_deposite');
            $table->float("pet_fee",10,2)->nullable()->after('danage_waiver');
            $table->string("pet_rate_per_unit")->nullable()->after('pet_fee');
            $table->float("extra_person_fee",10,2)->nullable()->after('pet_rate_per_unit');
            $table->integer("after_guest")->nullable()->after('extra_person_fee');
            $table->float("poolheating_fee",10,2)->nullable()->after('after_guest');
            $table->string("pool_heating_fees_perday")->nullable()->after('poolheating_fee');
            $table->time("check_in")->nullable()->after('pool_heating_fees_perday');
            $table->time("check_out")->nullable()->after('check_in');
            $table->float("tax_rates",10,2)->nullable()->after('check_out');
            $table->string("change_over")->nullable()->after('tax_rates');
            $table->unsignedBigInteger('currency_id')->nullable()->after('change_over');
            $table->foreign('currency_id')->references('id')->on('currencies')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->text('rates_notes')->nullable()->after('currency_id');
            $table->softDeletes();
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
