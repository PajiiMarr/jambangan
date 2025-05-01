<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TrackPageViews
{
    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();
        $date = Carbon::now();

        $record = DB::table('page_views')->where([
            'path' => $path,
            'year' => $date->year,
            'month' => $date->month,
            'day' => $date->day,
        ])->first();

        if ($record) {
            DB::table('page_views')
                ->where('id', $record->id)
                ->increment('views');
        } else {
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

        return $next($request);
    }
}
