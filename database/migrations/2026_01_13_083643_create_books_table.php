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
    Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('author');
        $table->string('publisher')->nullable();
        $table->year('year')->nullable();
        $table->string('category')->default('Umum');
        $table->string('rfid_code')->unique()->nullable(); // Kunci RFID Buku
        $table->integer('stock')->default(0);
        $table->string('shelf_location')->nullable(); // Lokasi Rak
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
