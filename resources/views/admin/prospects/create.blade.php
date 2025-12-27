@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ isset($prospect) ? 'Modifier' : 'Ajouter' }} Prospect</h1>

    <form action="{{ isset($prospect) ? route('prospects.update', $prospect->id) : route('prospects.store') }}" method="POST">
        @csrf
        @if(isset($prospect))
            @method('PUT')
        @endif

        <input type="text" name="full_name" value="{{ $prospect->full_name ?? '' }}" placeholder="Nom complet" class="border p-2 w-full mb-4" required>
        <input type="text" name="phone_number" value="{{ $prospect->phone_number ?? '' }}" placeholder="Téléphone" class="border p-2 w-full mb-4" required>
        <input type="email" name="email" value="{{ $prospect->email ?? '' }}" placeholder="Email" class="border p-2 w-full mb-4">
        <select name="city" class="border p-2 w-full mb-4" required>
            @foreach(['Tangier', 'Tetouan', 'Rabat', 'Kenitra'] as $city)
                <option value="{{ $city }}" {{ (isset($prospect) && $prospect->city == $city) ? 'selected' : '' }}>{{ $city }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
    </form>
</div>
@endsection
