<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prospect;
use App\Models\Visitor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVisitors = Visitor::sum('visitor_count');
        $totalProspects = Prospect::count();
        
        $prospectsByCity = Prospect::selectRaw('city, COUNT(*) as count')
            ->groupBy('city')
            ->pluck('count', 'city')
            ->toArray();

        $cities = ['Tangier', 'Tetouan', 'Rabat', 'Kenitra'];
        foreach ($cities as $city) {
            if (!isset($prospectsByCity[$city])) {
                $prospectsByCity[$city] = 0;
            }
        }

        return view('admin.dashboard', compact('totalVisitors', 'totalProspects', 'prospectsByCity'));
    }
}
