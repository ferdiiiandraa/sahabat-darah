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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom 'status'
            $table->string('status')->default('pending')->after('password'); // Sesuaikan posisi jika perlu

            // Tambahkan kolom 'is_verified'
            $table->boolean('is_verified')->default(false)->after('status'); // Sesuaikan posisi jika perlu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom 'status'
            $table->dropColumn('status');

            // Hapus kolom 'is_verified'
            $table->dropColumn('is_verified');
        });
    }
};