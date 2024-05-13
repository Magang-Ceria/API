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
        Schema::create('individual_interns', function (Blueprint $table) {
            $table->id();
            $table->string('address', 255);
            $table->string('institution')->nullable();
            $table->date('startperiode');
            $table->date('endperiode');
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->foreign("user_id")->on("user")->references("id");
            $table->timestamps();
        });
    }

/**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual_interns');
    }
};
