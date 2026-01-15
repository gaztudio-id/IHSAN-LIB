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
    Schema::create('members', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('nis')->unique(); // Nomor Induk Santri (Login User)
        $table->string('password')->default(bcrypt('123456')); // Default Password
        $table->string('rfid_code')->unique()->nullable(); // Kunci RFID Kartu Santri
        $table->string('class_name')->nullable(); // Kelas
        $table->enum('role', ['santri', 'guru', 'staff'])->default('santri');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
