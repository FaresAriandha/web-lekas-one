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
        Schema::create('couriers', function (Blueprint $table) {
            $table->ulid('courier_ID')->primary(); // ULID sebagai primary key
            $table->string('courier_name', 100);
            $table->string('courier_NIK', 16)->unique();
            $table->string('courier_birthplace', 100);
            $table->date('courier_birthdate');
            $table->string('courier_telp', 14);
            $table->string('courier_telp_darurat', 14);
            $table->enum('courier_gender', ['male', 'female']);
            $table->string('courier_address', 255);
            $table->string('courier_nama_rekening', 100);
            $table->string('courier_no_rekening', 10);
            $table->string('courier_img'); // Path gambar
            $table->string('courier_docs'); // Path dokumen PDF
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at untuk soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
