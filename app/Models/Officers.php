<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Officers extends Model
{
    protected $fillable = [
        'name',
        'position',
        'email',
        'phone',
        'address',
        'user_id'
    ];

}
