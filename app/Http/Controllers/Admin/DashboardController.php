<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prospect;
use App\Models\Visitor;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProspects = Prospect::count();

        $todayProspects = Prospect::whereDate('created_at', Carbon::today())->count();

        $monthProspects = Prospect::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $cityDistribution = Prospect::selectRaw('city, count(*) as count')
            ->groupBy('city')
            ->pluck('count', 'city');

        $cityStats = [
            'Tangier' => $cityDistribution['Tangier'] ?? 0,
            'Tetouan' => $cityDistribution['Tetouan'] ?? 0,
            'Rabat' => $cityDistribution['Rabat'] ?? 0,
            'Kenitra' => $cityDistribution['Kenitra'] ?? 0
        ];

        $visitorsToday = Visitor::getTodayCount() ?? 0;
        $visitorsMonth = Visitor::getThisMonthCount() ?? 0;
        $visitorsTotal = Visitor::getTotalCount() ?? 0;

        $recentProspects = Prospect::latest()->take(10)->get();

        // Variables manquantes pour la vue dashboard.blade.php
        $newToday = Prospect::whereDate('created_at', Carbon::today())->count();
        
        $topCity = $cityDistribution->isNotEmpty() 
            ? $cityDistribution->keys()->first() 
            : 'Aucune';
            
        $lastProspects = Prospect::latest()->take(5)->get();

        // Ajout de cette ligne pour connaître le dernier lead ID
        $lastLeadId = Prospect::max('id') ?? 0;
        

        return view('dashboard', compact(
            'totalProspects', 
            'todayProspects', 
            'monthProspects', 
            'cityStats',
            'visitorsToday', 
            'visitorsMonth', 
            'visitorsTotal', 
            'recentProspects',
            'newToday',
            'topCity',
            'lastProspects',
            'lastLeadId'
        ));
    }
}
