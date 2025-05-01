<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'event_date',
        'event_type',
        'message',
        'status'
    ];

    protected $casts = [
        'event_date' => 'date'
    ];

    public static function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'event_date' => 'required|date|after:today',
            'event_type' => 'required|in:wedding,corporate,cultural,other',
            'message' => 'nullable|string|max:1000',
        ];
    }

    public static function messages()
    {
        return [
            'name.required' => 'Please enter your full name',
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'phone.required' => 'Please enter your phone number',
            'event_date.required' => 'Please select an event date',
            'event_date.after' => 'Event date must be in the future',
            'event_type.required' => 'Please select an event type',
            'event_type.in' => 'Please select a valid event type',
            'message.max' => 'Message cannot exceed 1000 characters',
        ];
    }
}
