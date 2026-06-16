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
    Schema::create('rooms', function (Blueprint $table) {
        $table->id();
        $table->string('room_number');
        $table->enum('room_type', ['single', 'double', 'suite']);
        $table->decimal('price', 10, 2);
        $table->text('description')->nullable();
        $table->string('image')->nullable();
        $table->enum('status', ['available', 'booked'])->default('available');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
