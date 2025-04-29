<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $primaryKey = 'media_id';
    public $timestamps = false; // Disable automatic timestamps
    
    protected $fillable = [
        'file_data',    // Stores the file path or name
        'type',         // 'image' or 'video'
        'post_id',      // Foreign key reference to 'posts' table
        'uploaded_at',
        'performance_id',
        'event_id',     // Foreign key reference to 'events' table
        'officer_id',
        'slide_id'    // Foreign key reference to 'officers' table
    ];

    protected $casts = [
        'uploaded_at' => 'datetime' // Cast uploaded_at to datetime
    ];

// Automatically append the file_url attributel
    protected $appends = ['file_url'];

    /**
     * Define relationship with the Posts model.
     */

    public function performance(): BelongsTo
    {
        return $this->belongsTo(Performances::class, 'performance_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Posts::class, 'post_id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Events::class, 'event_id');
    }
    
    public function officer(): BelongsTo
    {
        return $this->belongsTo(Officers::class, 'officer_id');
    }

    public function slides(): BelongsTo
    {
        return $this->belongsTo(Slides::class, 'slide_id');
    }

    /**
     * Scope to filter only images.
     */
    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    /**
     * Scope to filter only videos.
     */
    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }


    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_data);
    }

    /**
     * Check if the file is an image.
     */
    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    /**
     * Check if the file is a video.
     */
    public function isVideo(): bool
    {
        return $this->type === 'video';
    }
}
