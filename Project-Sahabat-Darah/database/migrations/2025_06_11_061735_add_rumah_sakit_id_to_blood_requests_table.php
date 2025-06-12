<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            $table->integer('quantity')->after('rhesus')->default(1);
            $table->unsignedBigInteger('rumah_sakit_id')->after('hospital_address')->nullable();
            $table->foreign('rumah_sakit_id')->references('id')->on('users')->onDelete('set null'); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            $table->dropForeign(['rumah_sakit_id']);
            $table->dropColumn('rumah_sakit_id');
            $table->dropColumn('quantity');
        });
    }
};
