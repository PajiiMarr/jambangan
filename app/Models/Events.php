<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Events extends Model
{
    // Specify primary key since it's not the default 'id'
    protected $primaryKey = 'event_id';

    // Specify if the model has timestamps (your migration doesn't include them)
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'event_name',
        'start_date',
        'end_date',
        'location',
        'description',
        'user_id',
        'status',
    ];

    // Date casts
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // public function getStatusAttribute()
    // {
    //     $today = Carbon::now()->format('Y-m-d');

    //     if ($this->end_date < $today) {
    //         return 'Completed';
    //     } elseif ($this->start_date <= $today && $this->end_date >= $today) {
    //         return 'Ongoing';
    //     } else {
    //         return 'Upcoming';
    //     }
    // }

    // User relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
