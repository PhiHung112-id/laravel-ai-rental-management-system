<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    
    // Đã xóa 'date_created' vì trong database của bro dùng 'created_at' và 'updated_at' chuẩn của Laravel
    protected $fillable = ['house_id', 'customer_id', 'rating', 'comment', 'admin_reply'];

    // Mặc định Laravel sẽ tự động quản lý 'created_at' và 'updated_at' cho bro, không cần khai báo thêm.

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}