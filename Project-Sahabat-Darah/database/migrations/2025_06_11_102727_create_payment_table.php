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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->unique();
            $table->foreign('invoice_id')->references('transaction_id')->on('invoice')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->enum('payment_method', ['transfer_bank', 'qris', 'ewallet', 'cash', 'credit'])->nullable();
            $table->decimal('price')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
