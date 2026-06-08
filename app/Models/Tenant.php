<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table = 'tenants';

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'contact',
        'email',
        'house_id',
        'date_in',
        'status'
    ];

    public function house()
    {
        return $this->belongsTo(House::class,'house_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class,'tenant_id');
    }

    public function getFullNameAttribute()
    {
        return trim(
            $this->lastname.', '.
            $this->firstname.' '.
            $this->middlename
        );
    }
}