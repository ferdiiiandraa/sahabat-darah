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
        Schema::table('blood_requests', function (Blueprint $table) {
            // Add pmi_id column
            // Ensure it's an unsignedBigInteger as it will likely be a foreign key
            // to your PMIs or Users table ID.
            $table->unsignedBigInteger('pmi_id')->nullable()->after('id');

            // Add a foreign key constraint (recommended for data integrity)
            // Assuming your 'users' table or 'pmis' table has an 'id' column
            // If PMI data is in the 'users' table and 'pmi_id' refers to the user's ID
            $table->foreign('pmi_id')->references('id')->on('users')->onDelete('set null'); // Use set null if a request might exist without an associated PMI

            // OR if you have a separate 'pmis' table
            // $table->foreign('pmi_id')->references('id')->on('pmis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['pmi_id']);
            // Then drop the column
            $table->dropColumn('pmi_id');
        });
    }
};