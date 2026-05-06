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
        Schema::table('user_information', function (Blueprint $table) {
            $table->enum('term_conditions',[0,1])->after('about_you')->comment("0=No,1=Yes")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_information', function (Blueprint $table) {
            //
        });
    }
};
