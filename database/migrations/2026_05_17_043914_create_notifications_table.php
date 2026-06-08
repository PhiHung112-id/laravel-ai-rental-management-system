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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('content');
            $table->integer('customer_id'); // Gửi cho ai (0 nếu gửi toàn hệ thống)
            $table->text('message')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0: Chưa đọc, 1: Đã đọc');
            $table->tinyInteger('is_pinned')->default(0); // Có ghim lên đầu không
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
