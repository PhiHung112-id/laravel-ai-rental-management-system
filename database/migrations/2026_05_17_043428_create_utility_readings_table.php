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
        Schema::create('utility_readings', function (Blueprint $table) {
            $table->id();
            $table->integer('house_id'); // ID phòng/căn hộ
            $table->float('electric')->default(0); // Số điện (kWh)
            $table->float('water')->default(0); // Số nước (m3)
            $table->date('reading_date'); // Ngày chốt sổ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utility_readings');
    }
};
