<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = 'logs';
    protected $fillable = ['action',
        'navigation',  
        'user_id', 
        'performance_id',
        'post_id',
        'event_id',
        'slide_id',
        'general_id',
        'officer_id',
        'booking_id',
        'created_at',
        'updated_at',
    ];  
    protected $primaryKey = 'id';
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function performance()
    {
        return $this->belongsTo(Performances::class);
    }
    public function post()
    {
        return $this->belongsTo(Posts::class);
    }
    public function event()
    {
        return $this->belongsTo(Events::class);
    }
    public function slide()
    {
        return $this->belongsTo(Slides::class);
    }
    public function general()
    {
        return $this->belongsTo(General::class);
    }
}
