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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->time('morningtime')->nullable();
            $table->string('morningstatus')->default('Absent');
            $table->time('afternoontime')->nullable();
            $table->string('afternoonstatus')->default('Absent');
            $table->string('proof')->nullable();
            $table->unsignedBigInteger('date_id')->nullable(false);
            $table->foreign('date_id')->on('dates')->references('id');
            $table->morphs('attendanceable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
