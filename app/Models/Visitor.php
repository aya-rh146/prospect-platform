<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Visitor extends Model
{
    protected $fillable = ['visit_date', 'visitor_count'];

    protected $casts = [
        'visit_date' => 'date',
        'visitor_count' => 'integer',
    ];

    public static function incrementToday(): void
    {
        $today = Carbon::today()->toDateString();

        $visitor = self::firstOrCreate(['visit_date' => $today]);

        $visitor->increment('visitor_count');
    }

    public static function getTodayCount(): int
    {
        return self::whereDate('visit_date', Carbon::today())
                   ->value('visitor_count') ?? 0;
    }

    public static function getThisMonthCount(): int
    {
        return self::whereMonth('visit_date', Carbon::now()->month)
                   ->whereYear('visit_date', Carbon::now()->year)
                   ->sum('visitor_count');
    }

    public static function getTotalCount(): int
    {
        return self::sum('visitor_count');
    }
}