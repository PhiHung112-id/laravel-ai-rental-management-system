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
        Schema::create('installment_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('house_id')->nullable();
            $table->string('room_info', 255);
            $table->double('total_price');
            $table->integer('months'); // Số tháng trả góp
            $table->string('monthly_pay', 100); // Số tiền trả mỗi tháng
            $table->tinyInteger('status')->default(0)->comment('0: Chờ tư vấn, 1: Đã liên hệ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_requests');
    }
};
