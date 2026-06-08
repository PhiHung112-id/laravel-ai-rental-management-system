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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('email', 200)->unique();
            $table->string('password', 200);
            $table->string('google_id', 255)->nullable(); // Phục vụ tính năng đăng nhập bằng Google
            $table->string('phone', 20);
            $table->text('address');
            $table->text('avatar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
