@extends('layouts.admin') <!-- Layout admin que tu peux créer séparément -->

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow">
            <h2>Total Visitors</h2>
            <p class="text-xl font-bold">{{ $totalVisitors }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2>Total Prospects</h2>
            <p class="text-xl font-bold">{{ $totalProspects }}</p>
        </div>
        @foreach($prospectsByCity as $city => $count)
            <div class="bg-white p-4 rounded shadow">
                <h2>{{ $city }}</h2>
                <p class="text-xl font-bold">{{ $count }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection

