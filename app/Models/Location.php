<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {
    protected $fillable = ['location_name', 'description', 'img_path'];

    public function houses() {
        return $this->hasMany(House::class);
    }
}