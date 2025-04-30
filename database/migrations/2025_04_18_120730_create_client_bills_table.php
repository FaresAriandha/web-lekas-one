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
        Schema::create('client_bills', function (Blueprint $table) {
            $table->ulid('cb_ID')->primary(); // Primary key ULID
            $table->enum('cb_type', ['pasjay', 'paxel']); // Enum tipe tagihan
            $table->unsignedInteger('total_bill_client'); // Total tagihan
            $table->unsignedInteger('total_paid_client')->default(0); // Total dibayar
            $table->string('keterangan')->nullable(); // Keterangan opsional
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_bills');
    }
};
