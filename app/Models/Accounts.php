<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_number',
        'balance',
        'availability',
        'expiration_date',
        'deposits',
        'withdrawals'
    ];

    public function user()
    {
        return $this->belongsTo(Users::class,'user_id');
    }

    public function getUserIdAttribute()
    {
        return $this->attributes['user_id'];
    }
}