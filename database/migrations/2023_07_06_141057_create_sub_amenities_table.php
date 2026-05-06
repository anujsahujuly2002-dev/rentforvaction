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
        Schema::create('sub_amenities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amenities_id');
            $table->foreign('amenities_id')->references('id')->on('aminities')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string("name");
            $table->enum('description',['0','1'])->comment('0=no,1=yes');
            $table->enum('status',['0','1'])->comment('0=Inactive,1=Active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_amenities');
    }
};
