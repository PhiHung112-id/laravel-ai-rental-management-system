<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id(); // Tương đương: `id` int(30) NOT NULL AUTO_INCREMENT
            
            $table->string('house_no', 50); // Số phòng (P.101, Kiot 01...)
            $table->text('location')->nullable(); // Vị trí
            $table->text('map_link')->nullable(); // Link Google Map
            
            // Các khóa ngoại liên kết với bảng categories và locations
            $table->integer('category_id'); 
            $table->integer('location_id')->nullable();
            
            $table->text('description'); // Mô tả chi tiết
            $table->double('price'); // Giá gốc
            $table->double('sale_price')->default(0); // Giá khuyến mãi
            $table->string('img_path', 255)->default('no-image.jpg'); // Hình ảnh đại diện
            
            // Laravel mặc định cần 2 cột created_at và updated_at để dễ quản lý thời gian
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};