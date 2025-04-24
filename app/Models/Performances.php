<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Performances extends Model
{
    protected $table = 'performances';
    protected $primaryKey = 'performance_id';
    protected $fillable = [
        'title',
        'description',
        'created_at',
        // 'admin_id'
    ];
    public $timestamps = false;

    public function media(): HasOne
    {
        return $this->hasOne(Media::class, 'performance_id');
    }
    
    public function bookings(): HasMany
    {
        return $this->hasMany(Bookings::class, 'performance_id');
    }
}
