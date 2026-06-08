<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'tenant_id',
        'amount',
        'invoice',
        'date_created'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class,'tenant_id');
    }
}