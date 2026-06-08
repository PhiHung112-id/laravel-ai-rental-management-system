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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->integer('tenant_id');
            $table->integer('house_id');
            $table->text('report')->comment('Nội dung sự cố');
            $table->tinyInteger('status')->default(0)->comment('0: Chờ xử lý, 1: Đang sửa, 2: Đã xong');
            $table->float('cost')->default(0)->comment('Chi phí sửa chữa');
            $table->text('img_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
