<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('courier_assigns', function (Blueprint $table) {
            $table->ulid('cas_ID')->primary(); // Primary key ULID

            $table->foreignUlid('courier_ID') // Relasi ke tabel couriers
                ->constrained('couriers', 'courier_ID')
                ->onDelete('cascade');

            $table->enum('cas_type', ['pasjay', 'paxel']); // Tipe pengiriman
            $table->timestamp('cas_pickup_time'); // Waktu pickup barang
            $table->timestamp('cas_arrived_time')->nullable(); // Waktu tiba di lokasi pickup
            $table->timestamp('cas_start_time')->nullable(); // Waktu mulai siap mengantarkan barang
            $table->timestamp('cas_finish_time')->nullable(); // Waktu selesai mengantarkan barang
            $table->enum('cas_status', ['Ditugaskan', 'Siap Pickup', 'Dalam Tugas', 'Selesai'])->default("Ditugaskan"); // Status penugasan

            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes(); // Kolom deleted_at untuk soft deletes
        });
    }

    public function down()
    {
        Schema::dropIfExists('courier_assigns');
    }
};
