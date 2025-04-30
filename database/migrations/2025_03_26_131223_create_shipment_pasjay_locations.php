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
        Schema::create('shipment_pasjay_locations', function (Blueprint $table) {
            $table->ulid('shploc_ID')->primary(); // Menggunakan ULID sebagai Primary Key
            $table->string('shploc_name', 100)->unique(); // Nama lokasi (VARCHAR 100) dan unik
            $table->text('shploc_address'); // Alamat lokasi (TEXT)
            $table->enum('shploc_city', ['Jakarta Utara', 'Jakarta Pusat', 'Jakarta Barat', 'Jakarta Timur', 'Jakarta Selatan']); // Kota (enum)
            $table->text('shploc_url_maps'); // URL Maps (TEXT)
            $table->timestamps(); // created_at & updated_at otomatis
            $table->softDeletes(); // deleted_at untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_pasjay_locations');
    }
};
