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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('tenant_id'); // ID của người thuê
            $table->float('amount'); // Tổng tiền thanh toán
            $table->string('invoice', 50); // Mã hóa đơn (VD: HD-100001)
            $table->float('cost_electric')->default(0); // Tiền điện
            $table->float('cost_water')->default(0); // Tiền nước
            $table->timestamps(); // Sẽ tự động thay thế cho cột date_created của bạn
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
