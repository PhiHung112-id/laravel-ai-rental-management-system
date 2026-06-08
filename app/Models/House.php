<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model {
    protected $fillable = ['house_no', 'location', 'map_link', 'category_id', 'location_id', 'description', 'price', 'sale_price', 'img_path'];

    // Quan hệ: Một phòng thuộc về một khu vực
    public function locationDetail()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Quan hệ: Một căn phòng có thể có nhiều lịch sử thuê (tenants)
    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'house_id');
    }

    // Quan hệ: Một căn phòng có thể có nhiều yêu cầu mua trả góp
    public function installmentRequests()
    {
        return $this->hasMany(InstallmentRequest::class, 'house_id');
    }

    public function images()
    {
        return $this->hasMany(HouseImage::class, 'house_id');
    }
}