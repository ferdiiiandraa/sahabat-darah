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
        Schema::create('rumah_sakits', function (Blueprint $table) {
            $table->id();
            $table->string('namainstitusi');
            $table->string('email')->unique();
            $table->string('password'); // Atau biarkan di tabel users saja jika relasi one-to-one
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('dokumen')->nullable(); // Path dokumen
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
            // Tambahkan foreign key ke tabel users jika relasi one-to-one atau one-to-many
            // $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah_sakits');
    }
};
