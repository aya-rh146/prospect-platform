<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Prospect;
use Illuminate\Http\Request;

class ProspectController extends Controller
{
    /**
     * Store a newly created prospect in storage.
     */
    public function store(Request $request)
    {
        // Rate limiting: max 5 submissions per IP per hour
        $validated = $request->validate([
            'full_name'    => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'phone_number' => 'required|string|regex:/^[0-9+\-\s()]{10,20}$/|unique:prospects,phone_number',
            'email'        => 'nullable|email|max:100|unique:prospects,email',
            'city'         => 'required|in:Tangier,Tetouan,Rabat,Kenitra',
            // 'g-recaptcha-response' => 'required|captcha' // Temporairement désactivé
        ], [
            'full_name.required'    => 'Le nom complet est obligatoire.',
            'full_name.regex'       => 'Le nom ne doit contenir que des lettres et des espaces.',
            'phone_number.required' => 'Le numéro de téléphone est obligatoire.',
            'phone_number.regex'    => 'Le format du numéro de téléphone n\'est pas valide.',
            'phone_number.unique'    => 'Ce numéro de téléphone est déjà enregistré.',
            'email.email'           => 'Veuillez entrer une adresse email valide.',
            'email.unique'          => 'Cet email est déjà enregistré.',
            'city.required'         => 'Veuillez sélectionner une ville.',
            'city.in'               => 'La ville sélectionnée n\'est pas valide.',
            // 'g-recaptcha-response.required' => 'Veuillez valider le CAPTCHA.',
            // 'g-recaptcha-response.captcha' => 'CAPTCHA invalide, veuillez réessayer.'
        ]);

        // Create prospect
        $prospect = Prospect::create($validated);

        // Notification admin en temps réel
        session()->flash('new_prospect_notification', [
            'id' => $prospect->id,
            'name' => $prospect->full_name,
            'phone' => $prospect->phone_number,
            'city' => $prospect->city,
            'created_at' => $prospect->created_at->format('H:i')
        ]);

        return redirect()->route('home')
                     ->with('success', 'Merci ! Votre demande a été enregistrée avec succès. Nous vous contacterons rapidement.');
    }
}