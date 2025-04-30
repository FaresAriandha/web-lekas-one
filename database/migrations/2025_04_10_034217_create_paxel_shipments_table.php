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
        Schema::create('shipments_paxel', function (Blueprint $table) {
            $table->ulid('shpxl_ID')->primary(); // ULID primary key

            $table->foreignUlid('courier_ID') // Relasi ke tabel couriers
                ->constrained('couriers', 'courier_ID')
                ->onDelete('cascade');

            $table->string('awb_number')->unique();

            $table->enum('awb_slot', ['Pagi', 'Siang']);
            $table->enum('awb_status', ['Siap Antar', 'Selesai', 'Dikembalikan', "Dibatalkan"])->default("Siap Antar");
            $table->enum('awb_hub', ['HALIM', 'MANGGA DUA']);
            $table->timestamp('awb_finish_time')->nullable();
            $table->string('awb_pod')->nullable(); // Path gambar

            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments_paxel');
    }
};
