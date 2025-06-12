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
        if (Schema::hasTable('invoice')) {
            DB::unprepared('
                CREATE TRIGGER set_invoice_transaction_id BEFORE INSERT ON invoice FOR EACH ROW
                BEGIN
                    DECLARE next_id INT;
                    -- Menghitung jumlah baris yang sudah ada untuk mendapatkan ID berikutnya
                    SELECT COUNT(*) INTO next_id FROM invoice;
                    -- Mengatur transaction_id dengan format INV diikuti angka 3 digit
                    SET NEW.transaction_id = CONCAT("INV", LPAD(next_id, 3, "0"));
                END;
            ');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS set_invoice_transaction_id');
    }
};
