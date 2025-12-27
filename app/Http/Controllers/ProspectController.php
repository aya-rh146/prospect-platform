<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Prospect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProspectController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'city' => 'required|in:Tangier,Tetouan,Rabat,Kenitra',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Prospect::create($validator->validated());

        return redirect()->route('home')->with('success', 'Merci ! Votre demande a été enregistrée avec succès.');
    }
}
