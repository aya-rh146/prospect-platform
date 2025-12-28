<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Prospect;
use Illuminate\Http\Request;

class ProspectController extends Controller
{
    public function store(Request $request)
    {
        // Validation محسنة مع رسائل خطأ بالفرنسية (ولا العربية إلا بغيتي)
        $validated = $request->validate([
            'full_name'    => 'required|string|max:100|regex:/^[\pL\s\-]+$/u', // اسم كامل (حروف ومسافات فقط)
            'phone_number' => 'required|string|regex:/^[0-9+\-\s()]{10,20}$/', // رقم هاتف واقعي أكثر
            'email'        => 'nullable|email|max:100|unique:prospects,email', // email فريد فالجدول
            'city'         => 'required|in:Tangier,Tetouan,Rabat,Kenitra',
        ], [
            // رسائل خطأ مخصصة وواضحة بالفرنسية (كيما فالمشروع ديالك)
            'full_name.required'    => 'Le nom complet est obligatoire.',
            'full_name.regex'       => 'Le nom ne doit contenir que des lettres et des espaces.',
            'phone_number.required' => 'Le numéro de téléphone est obligatoire.',
            'phone_number.regex'    => 'Le format du numéro de téléphone n\'est pas valide.',
            'email.email'           => 'Veuillez entrer une adresse email valide.',
            'email.unique'          => 'Cet email est déjà enregistré.',
            'city.required'         => 'Veuillez sélectionner une ville.',
            'city.in'               => 'La ville sélectionnée n\'est pas valide.',
        ]);

        // إنشاء الـ prospect
        Prospect::create($validated);

        // رجوع للـ home مع رسالة نجاح
        return redirect()->route('home')->with('success', 'Merci ! Votre demande a été enregistrée avec succès.');
    }
}