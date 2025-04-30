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
        Schema::create('shipment_price_lists', function (Blueprint $table) {
            $table->ulid('spl_ID')->primary(); // ULID sebagai Primary Key

            $table->string('spl_name', 100)->unique(); // Nama, max 100 karakter, unik
            $table->enum('spl_type', ['pasjay', 'paxel']); // Tipe enum

            $table->unsignedInteger('spl_baseprice'); // Harga dasar internal
            $table->unsignedInteger('spl_baseprice_client'); // Harga dasar untuk client

            $table->unsignedInteger('spl_multidrop'); // Biaya multidrop internal
            $table->unsignedInteger('spl_multidrop_client'); // Biaya multidrop client

            $table->unsignedInteger('spl_roundtrip'); // Biaya roundtrip internal
            $table->unsignedInteger('spl_roundtrip_client'); // Biaya roundtrip client

            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_price_lists');
    }
};
