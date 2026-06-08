<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UtilityReading extends Model
{
    protected $table = 'utility_readings';

    protected $fillable = [
        'house_id',
        'electric',
        'water',
        'reading_date'
    ];

    public function house()
    {
        return $this->belongsTo(House::class,'house_id');
    }
}