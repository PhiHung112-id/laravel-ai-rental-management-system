<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    protected $fillable = [
        'tenant_id',
        'house_id',
        'report',
        'status',
        'cost',
        'img_path',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function house()
    {
        return $this->belongsTo(House::class, 'house_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR: STATUS TEXT
    |--------------------------------------------------------------------------
    */
    public function getStatusTextAttribute()
    {
        switch ($this->status) {

            case 0:
                return 'Chờ xử lý';

            case 1:
                return 'Đang xử lý';

            case 2:
                return 'Đã hoàn thành';

            default:
                return 'Không xác định';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR: STATUS COLOR
    |--------------------------------------------------------------------------
    */
    public function getStatusColorAttribute()
    {
        switch ($this->status) {

            case 0:
                return 'warning';

            case 1:
                return 'primary';

            case 2:
                return 'success';

            default:
                return 'secondary';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR: IMAGE URL
    |--------------------------------------------------------------------------
    */
    public function getImageUrlAttribute()
    {
        if (!empty($this->img_path)) {
            return asset('assets/uploads/' . $this->img_path);
        }

        return asset('assets/uploads/no-image.jpg');
    }
}