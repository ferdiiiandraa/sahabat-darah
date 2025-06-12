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
        Schema::table('blood_inventories', function (Blueprint $table) {
            $table->unsignedBigInteger('pmi_id')->after('id')->nullable(); // Menambahkan kolom
            $table->foreign('pmi_id')->references('id')->on('users')->onDelete('cascade'); // Menambahkan foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blood_inventories', function (Blueprint $table) {
            $table->dropForeign(['pmi_id']); // Menghapus foreign key
            $table->dropColumn('pmi_id'); // Menghapus kolom
        });
    }
};