<?php 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

function track_page_view($path)
{
    $date = Carbon::now();

    $existing = DB::table('page_views')->where([
        'path' => $path,
        'year' => $date->year,
        'month' => $date->month,
        'day' => $date->day,
    ])->first();

    if ($existing) {
        // If record exists, increment views
        DB::table('page_views')->where('id', $existing->id)->increment('views');
    } else {
        // Insert new record
        DB::table('page_views')->insert([
            'path' => $path,
            'year' => $date->year,
            'month' => $date->month,
            'day' => $date->day,
            'views' => 1,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }
}
