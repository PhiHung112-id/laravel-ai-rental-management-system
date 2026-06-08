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
        Schema::create('installment_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('request_id'); // Liên kết với bảng installment_requests
            $table->integer('month_no')->nullable(); // Trả góp tháng thứ mấy
            $table->double('amount')->nullable(); // Số tiền đã đóng
            $table->text('receipt_img')->nullable(); // Ảnh biên lai
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_payments');
    }
};
