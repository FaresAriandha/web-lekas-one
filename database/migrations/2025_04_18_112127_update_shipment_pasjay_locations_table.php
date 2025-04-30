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
        Schema::table('shipment_pasjay_locations', function (Blueprint $table) {
            // Hapus kolom enum shploc_city
            $table->dropColumn('shploc_city');

            // Tambahkan kolom spl_ID dan jadikan foreign key
            $table->ulid('spl_ID')->after('shploc_address'); // letakkan setelah alamat
            $table->foreign('spl_ID')->references('spl_ID')->on('shipment_price_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipment_pasjay_locations', function (Blueprint $table) {
            // Rollback: hapus foreign key & kolom spl_ID
            $table->dropForeign(['spl_ID']);
            $table->dropColumn('spl_ID');

            // Kembalikan kolom enum shploc_city
            $table->enum('shploc_city', ['Jakarta Utara', 'Jakarta Pusat', 'Jakarta Barat', 'Jakarta Timur', 'Jakarta Selatan'])->after('shploc_address');
        });
    }
};
