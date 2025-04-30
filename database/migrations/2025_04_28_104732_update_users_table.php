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
        Schema::dropIfExists('users'); // pastikan drop dulu users lama supaya tidak bentrok

        Schema::create('users', function (Blueprint $table) {
            $table->ulid('user_ID')->primary(); // pakai ULID sebagai primary
            $table->foreignUlid('courier_ID')->nullable()->constrained('couriers', 'courier_ID')->nullOnDelete();
            $table->string('user_name');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('user_role', ['admin', 'korlap', 'kurir']);
            $table->string('user_img');
            $table->rememberToken(); // untuk remember me di Auth
            $table->timestamps();
            $table->softDeletes(); // supaya ada deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
