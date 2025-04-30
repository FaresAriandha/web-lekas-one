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
        Schema::create('paxel_bills', function (Blueprint $table) {
            $table->ulid('pxb_ID')->primary(); // Primary key ULID

            $table->foreignUlid('courier_ID') // Relasi ke tabel couriers
                ->constrained('couriers', 'courier_ID')
                ->onDelete('cascade');

            $table->unsignedInteger('awb_total'); // Maks. 5 digit
            $table->enum('awb_slot', ['Pagi', 'Siang']); // Slot
            $table->unsignedInteger('total_bill_client'); // Maks. 10 digit
            $table->unsignedInteger('total_paid_client')->default(0); // Default 0
            $table->unsignedInteger('paid_to_courier')->default(0); // Default 0
            $table->text('keterangan')->nullable(); // Nullable

            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paxel_bills');
    }
};
