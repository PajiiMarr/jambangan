<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class General extends Model
{
    protected $table = 'general';
    protected $primaryKey = 'id';
    protected $fillable = [
        'site_title',
        'about_us',
        'contact_email',
        'contact_number',
        'logo_path'
    ];
    public $timestamps = false;

    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'general_id');
    }
}
