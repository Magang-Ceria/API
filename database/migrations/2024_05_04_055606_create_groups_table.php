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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('institution')->nullable();
            $table->integer('quota')->default(5);
            $table->date('startperiode');
            $table->date('endperiode');
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('leader_id');
            $table->foreign('leader_id')->on('user')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
