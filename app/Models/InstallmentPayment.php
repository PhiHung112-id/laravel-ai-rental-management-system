<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentPayment extends Model
{
    protected $table = 'installment_payments';

    protected $fillable = [
        'request_id',
        'month_no',
        'amount',
        'proof_image',
        'status',
    ];

    public function request()
    {
        return $this->belongsTo(InstallmentRequest::class,'request_id');
    }
}