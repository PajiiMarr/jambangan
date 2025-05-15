<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'post_id';

    protected $fillable = [
        'title',
        'content',
        'event_id',
        'performance_id',
        'user_id',
        'spp_status'
    ];

    public function events(): BelongsTo
    {
        return $this->belongsTo(Events::class, 'event_id');
    }

    public function performances(): BelongsTo
    {
        return $this->belongsTo(Performances::class, 'performance_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'post_id');
    }
}
