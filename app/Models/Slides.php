<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Slides extends Model
{
    protected $table = 'slides';
    protected $primaryKey = 'slide_id';
    protected $fillable = [
        'title', // Stores the file path or name
        'subtitle',      // 'image' or 'video'
    ];
    public $timestamps = false; // Disable automatic timestamps

    public function media(): HasOne
    {
        return $this->hasOne(Media::class, 'slide_id');
    }

}
