<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Visitor extends Model
{
    protected $fillable = [
        'visit_date',
        'visitor_count',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'visitor_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function incrementToday(): void
    {
        $today = now()->toDateString();
        
        self::updateOrCreate(
            ['visit_date' => $today],
            ['visitor_count' => DB::raw('visitor_count + 1')]
        );
    }
}
