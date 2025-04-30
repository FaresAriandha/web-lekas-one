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
        Schema::create('shipments_pasjay', function (Blueprint $table) {
            $table->ulid('shpsj_ID')->primary(); // Primary Key ULID
            $table->foreignUlid('courier_ID')->constrained('couriers', 'courier_ID')->onDelete('cascade');
            $table->foreignUlid('shploc_ID')->constrained('shipment_pasjay_locations', 'shploc_ID')->onDelete('cascade');
            $table->unsignedInteger('rit');
            $table->string('roundtrip')->nullable();
            $table->string('image');
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments_pasjay');
    }
};
