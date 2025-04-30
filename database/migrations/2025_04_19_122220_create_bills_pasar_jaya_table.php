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
        Schema::create('pasjay_bills', function (Blueprint $table) {
            $table->ulid('pjb_ID')->primary(); // Primary Key ULID
            $table->foreignUlid('courier_ID')->constrained('couriers', 'courier_ID')->onDelete('cascade');
            $table->foreignUlid('shploc_ID')->constrained('shipment_pasjay_locations', 'shploc_ID')->onDelete('cascade');
            $table->unsignedInteger('rit');
            $table->unsignedInteger('total_location')->default(0);
            $table->unsignedInteger('total_bill_client')->default(0);
            $table->unsignedInteger('total_charge')->default(0);
            $table->unsignedInteger('paid_to_courier')->default(0);
            $table->boolean('roundtrip')->default(false);
            $table->text('keterangan')->nullable(); // Nullable
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasjay_bills');
    }
};
