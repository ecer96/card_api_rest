<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'birthday',
        'email',
        'phone',
        'password',

    ];

    public function accounts()
    {
        return $this->hasMany(Accounts::class,'user_id');
    }
}
