<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Officers extends Model
{
    protected $table = 'officers';
    protected $primaryKey = 'officer_id';
    protected $fillable = [
        'name',
        'position',
        'email',
        'phone',
        'address',
        'parent_id',
    ];
    public $timestamps = false; // Disable automatic timestamps
    public function media ()
    {
        return $this->hasOne(Media::class, 'officer_id');
    }
}
