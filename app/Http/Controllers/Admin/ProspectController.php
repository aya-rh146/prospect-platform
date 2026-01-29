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
     * Afficher la page de tous les prospects avec recherche et filtrage par ville
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $city = $request->query('city');

        $query = Prospect::query();

        // Recherche par nom complet, téléphone ou email
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtrage par ville (les villes que vous avez spécifiées)
        if ($city && in_array($city, ['Tangier', 'Tetouan', 'Rabat', 'Kenitra'])) {
            $query->where('city', $city);
        }

        // Tri du plus récent au plus ancien + pagination
        $prospects = $query->latest()->paginate(20);

        // Pour conserver la recherche et le filtrage dans les liens de pagination
        $prospects->appends(['search' => $search, 'city' => $city]);

        return view('admin.prospects.index', compact('prospects', 'search', 'city'));
    }

    /**
     * Afficher la page de modification de prospect
     */
    public function edit($id)
    {
        $prospect = Prospect::findOrFail($id);
        return view('admin.prospects.edit', compact('prospect'));
    }

    /**
     * Mettre à jour les données du prospect
     */
    public function update(Request $request, $id)
    {
        $prospect = Prospect::findOrFail($id);
        
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'phone_number'  => 'required|string|max:20|unique:prospects,phone_number,' . $prospect->id,
            'email'         => 'nullable|email|max:255|unique:prospects,email,' . $prospect->id,
            'city'          => 'required|in:Tangier,Tetouan,Rabat,Kenitra',
            // Ajoutez les autres champs si vous en avez (message, source, etc.)
        ], [
            'full_name.required' => 'Le nom complet est obligatoire.',
            'phone_number.required' => 'Le numéro de téléphone est obligatoire.',
            'phone_number.unique' => 'Ce numéro de téléphone existe déjà.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cet email existe déjà.',
            'city.required' => 'La ville est obligatoire.',
            'city.in' => 'Veuillez sélectionner une ville valide.',
        ]);

        $prospect->update($request->all());

        return redirect()->route('admin.prospects.index')
                        ->with('success', 'Prospect mis à jour avec succès.');
    }

    /**
     * Supprimer un prospect
     */
    public function destroy(Prospect $prospect)
    {
        $prospect->delete();

        return back()->with('success', 'Prospect supprimé avec succès.');
    }

    /**
     * Exporter tous les prospects vers Excel
     */
    public function export(Request $request)
    {
        // Pour conserver le même filtrage et recherche dans l'export
        $filename = 'prospects_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        // On passe le request à la classe Export pour appliquer le même filtrage si souhaité (optionnel)
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

