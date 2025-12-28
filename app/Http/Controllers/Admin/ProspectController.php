<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prospect;
use Illuminate\Http\Request;
use App\Exports\ProspectsExport;
use Maatwebsite\Excel\Facades\Excel;


class ProspectController extends Controller
{
    public function index(Request $request)
    {
        // جيب الـ query parameters
        $search = $request->query('search');
        $city = $request->query('city');

        // بدا الـ query
        $query = Prospect::query();

        // إلا كان بحث
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // إلا كان فلتر بالمدينة
        if ($city && in_array($city, ['Tangier', 'Tetouan', 'Rabat', 'Kenitra'])) {
            $query->where('city', $city);
        }

        // ترتيب حسب التاريخ الجديد أولاً + pagination
        $prospects = $query->latest()->paginate(20);

        // زد الـ query parameters للـ pagination links
        $prospects->appends(['search' => $search, 'city' => $city]);

        return view('admin.prospects.index', compact('prospects', 'search', 'city'));
    }

    public function destroy(Prospect $prospect)
    {
        $prospect->delete();

        return back()->with('success', 'Prospect supprimé avec succès.');
    }
    public function export(Request $request)
    {
        $filename = 'prospects_' . now()->format('Y-m-d_H-i') . '.xlsx';

        return Excel::download(new ProspectsExport($request), $filename);
    }
}
