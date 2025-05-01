<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Performances extends Model
{
    use SoftDeletes;

    protected $table = 'performances';
    protected $primaryKey = 'performance_id';
    protected $fillable = [
        'title',
        'description',
        'created_at',
        'status'
    ];
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function media(): HasOne
    {
        return $this->hasOne(Media::class, 'performance_id');
    }
    
    public function bookings(): HasMany
    {
        return $this->hasMany(Bookings::class, 'performance_id');
    }
}
