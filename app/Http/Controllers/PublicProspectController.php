<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use Illuminate\Http\Request;

class PublicProspectController extends Controller
{
    /**
     * Display the public prospects page with dashboard style
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $city = $request->query('city');

        $query = Prospect::query();

        // Search by name, phone or email
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by city
        if ($city) {
            $query->where('city', $city);
        }

        $prospects = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('prospects', compact('prospects'));
    }
}
