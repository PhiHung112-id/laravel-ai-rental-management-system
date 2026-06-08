<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // Chỉ định tên bảng trong database
    protected $table = 'customers';

    // Các cột có thể gán dữ liệu hàng loạt
    protected $fillable = ['name', 'email', 'contact', 'address', 'password'];

    // Quan hệ: Một khách hàng có thể có nhiều bình luận (đánh giá)
    public function reviews()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }
}