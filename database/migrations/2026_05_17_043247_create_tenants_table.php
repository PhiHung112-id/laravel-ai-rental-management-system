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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 100);
            $table->string('middlename', 100)->nullable();
            $table->string('lastname', 100);
            $table->string('email', 100);
            $table->string('contact', 50); // Số điện thoại liên hệ
            $table->integer('house_id'); // ID phòng đang thuê (Liên kết với bảng houses)
            $table->tinyInteger('status')->default(1); // 1: Đang ở, 0: Đã dời đi
            $table->date('date_in'); // Ngày bắt đầu thuê
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
