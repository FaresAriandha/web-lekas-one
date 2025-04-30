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
        Schema::create('fleets', function (Blueprint $table) {
            $table->ulid('fleet_ID')->primary();
            $table->string('fleet_nopol', 12)->unique()->min(4);
            $table->ulid('courier_ID')->nullable()->unique();
            $table->enum('fleet_type', ['Van', 'Pickup', 'CDE Box']);
            $table->string('fleet_merk', 100);
            $table->enum('fleet_status', ['DIGUNAKAN', 'TERSEDIA', 'PERBAIKAN']);
            $table->date('fleet_KIR_date');
            $table->string('fleet_img');
            $table->string('fleet_docs');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key ke tabel couriers tanpa onDelete cascade
            $table->foreign('courier_ID')->references('courier_ID')->on('couriers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fleets');
    }
};
