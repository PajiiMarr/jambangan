<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Bookings extends Model
{
    protected $table = 'bookings';

    protected $primaryKey = 'id';

    protected $fillable = [
        'client_name',
        'contact_number',
        'email',
        'event_name',
        'event_date',
        'event_time',
        'event_location',
        'performance_id',
        'fee',
        'status'
    ];

    public function performance(): BelongsTo
    {
        return $this->belongsTo(Performances::class, 'performance_id');
    }

}
