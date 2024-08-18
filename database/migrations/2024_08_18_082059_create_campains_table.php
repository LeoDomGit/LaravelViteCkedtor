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
        Schema::create('campains', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->string('summary',255);
            $table->string('link',255);
            $table->string('image',255);
            $table->dateTime('start')->nullable();
            $table->dateTime('end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campains');
    }
};
