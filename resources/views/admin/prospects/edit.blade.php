@extends('layouts.admin')

@section('title', 'Modifier Prospect')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Modifier Prospect</h1>

    <form action="{{ route('admin.prospects.update', $prospect->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Nom complet</label>
            <input type="text" name="full_name" value="{{ old('full_name', $prospect->full_name) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Téléphone</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $prospect->phone_number) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email', $prospect->email) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">Ville</label>
            <select name="city" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">Sélectionner une ville</option>
                <option value="Tangier" {{ old('city', $prospect->city) == 'Tangier' ? 'selected' : '' }}>Tangier</option>
                <option value="Tetouan" {{ old('city', $prospect->city) == 'Tetouan' ? 'selected' : '' }}>Tetouan</option>
                <option value="Rabat" {{ old('city', $prospect->city) == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                <option value="Kenitra" {{ old('city', $prospect->city) == 'Kenitra' ? 'selected' : '' }}>Kenitra</option>
            </select>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">Enregistrer</button>
            <a href="{{ route('admin.prospects.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition">Annuler</a>
        </div>
    </form>
</div>
@endsection
