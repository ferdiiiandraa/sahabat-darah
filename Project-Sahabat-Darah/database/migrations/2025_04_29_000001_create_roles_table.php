<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Insert default roles
        DB::table('roles')->insert([
            ['name' => 'Super Admin', 'slug' => 'super-admin'],
            ['name' => 'Admin Rumah Sakit', 'slug' => 'admin-rs'],
            ['name' => 'Admin PMI', 'slug' => 'admin-pmi'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
