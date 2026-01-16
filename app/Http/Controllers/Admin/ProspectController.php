<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prospect;
use Illuminate\Http\Request;
use App\Exports\ProspectsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProspectController extends Controller
{
    /**
     * عرض صفحة جميع الـ Prospects مع بحث وفلترة بالمدينة
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $city = $request->query('city');

        $query = Prospect::query();

        // البحث بالاسم الكامل أو الهاتف أو الإيميل
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // فلترة بالمدينة (المدن اللي حددتيهم)
        if ($city && in_array($city, ['Tangier', 'Tetouan', 'Rabat', 'Kenitra'])) {
            $query->where('city', $city);
        }

        // ترتيب من الأحدث إلى الأقدم + pagination
        $prospects = $query->latest()->paginate(20);

        // باش يبقى البحث والفلترة فالـ pagination links
        $prospects->appends(['search' => $search, 'city' => $city]);

        return view('admin.prospects.index', compact('prospects', 'search', 'city'));
    }

    /**
     * عرض صفحة تعديل Prospect
     */
    public function edit(Prospect $prospect)
    {
        return view('admin.prospects.edit', compact('prospect'));
    }

    /**
     * تحديث بيانات Prospect
     */
    public function update(Request $request, Prospect $prospect)
    {
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'phone_number'  => 'required|string|max:20|unique:prospects,phone_number,' . $prospect->id,
            'email'         => 'nullable|email|max:255|unique:prospects,email,' . $prospect->id,
            'city'          => 'required|in:Tangier,Tetouan,Rabat,Kenitra',
            // زد باقي الحقول إلا كانو عندك (message, source, etc.)
        ]);

        $prospect->update($request->all());

        return redirect()->route('admin.prospects.index')
                         ->with('success', 'تم تعديل الـ Prospect بنجاح.');
    }

    /**
     * حذف Prospect
     */
    public function destroy(Prospect $prospect)
    {
        $prospect->delete();

        return back()->with('success', 'تم حذف الـ Prospect بنجاح.');
    }

    /**
     * تصدير جميع الـ Prospects إلى Excel
     */
    public function export(Request $request)
    {
        // باش نحافظ على نفس الفلترة والبحث فالـ export
        $filename = 'prospects_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        // نمرر الـ request للـ Export class باش يطبق نفس الفلترة إلا بغيتي (اختياري)
        return Excel::download(new ProspectsExport($request), $filename);
    }

    /**
     * Suppression multiple de prospects (bulk delete)
     */
    public function bulkDelete(Request $request)
    {
        $selectedIds = $request->input('selected_ids');
        
        if (empty($selectedIds)) {
            return back()->with('error', 'Aucun prospect sélectionné.');
        }

        // Convertir en array si c'est une chaîne
        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
        }

        // Supprimer les prospects sélectionnés
        $deletedCount = Prospect::whereIn('id', $selectedIds)->delete();

        return back()->with('success', "{$deletedCount} prospect(s) supprimé(s) avec succès.");
    }
}

