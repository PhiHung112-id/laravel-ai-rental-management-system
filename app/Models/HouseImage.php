<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseImage extends Model
{
    // Đảm bảo khớp với tên bảng trong database của bro
    protected $table = 'house_images';

    // Các cột có thể gán dữ liệu
    protected $fillable = ['house_id', 'img_path'];

    // Quan hệ: Nhiều ảnh thuộc về một phòng
    public function house()
    {
        return $this->belongsTo(House::class, 'house_id');
    }
}