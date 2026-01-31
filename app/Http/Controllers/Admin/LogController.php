<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer')->latest();

        // Filtrer par sujet
        if ($request->filled('subject_type')) {
            $query->where('subject_type', 'like', '%' . $request->subject_type . '%');
        }

        // Filtrer par action
        if ($request->filled('action')) {
            $query->where('description', 'like', '%' . $request->action . '%');
        }

        // Filtrer par utilisateur
        if ($request->filled('user_id')) {
            $query->where('causer_id', $request->user_id);
        }

        // Filtrer par date
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(50);

        // Statistiques
        $stats = [
            'total' => Activity::count(),
            'today' => Activity::whereDate('created_at', today())->count(),
            'prospects' => Activity::where('subject_type', 'like', '%Prospect%')->count(),
            'videos' => Activity::where('subject_type', 'like', '%Video%')->count(),
        ];

        return view('admin.logs.index', compact('logs', 'stats'));
    }

    public function show(Activity $log)
    {
        $log->load('causer', 'subject');
        return view('admin.logs.show', compact('log'));
    }
}
