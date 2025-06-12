<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            $table->enum('delivery_status', ['preparing', 'shipped', 'delivered'])->default('preparing')->after('status');
            $table->text('tracking_notes')->nullable()->after('delivery_status');
        });
    }

    public function down()
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            $table->dropColumn(['delivery_status', 'tracking_notes']);
        });
    }
};