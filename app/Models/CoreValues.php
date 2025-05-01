<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoreValues extends Model
{
    protected $table = 'core_values';
    protected $primaryKey = 'id';
    protected $fillable = ['core_value_title', 'core_value_description'];
    public $timestamps = false; 
}
