<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prospect;
use Illuminate\Http\Request;

class ProspectController extends Controller
{
    public function index(Request $request)
    {
        $query = Prospect::query();

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $prospects = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.prospects.index', compact('prospects'));
    }

    public function destroy(Prospect $prospect)
    {
        $prospect->delete();

        return back()->with('success', 'Prospect supprimé avec succès.');
    }
}
