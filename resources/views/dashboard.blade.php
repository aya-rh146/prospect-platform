@extends('layouts.admin')

@section('content')

<div class="p-6">
    <h1 class="text-3xl font-bold mb-8">Dashboard Admin</h1>

    <!-- Stats cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-300">Total Prospects</h3>
            <p class="text-4xl font-bold text-indigo-600">{{ $totalProspects ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-300">Nouveaux aujourd'hui</h3>
            <p class="text-4xl font-bold text-emerald-600">{{ $newToday ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-300">Top Ville</h3>
            <p class="text-2xl font-bold text-pink-600">{{ $topCity ?? 'Aucune' }}</p>
        </div>
    </div>

    <!-- Derniers prospects -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Derniers 5 prospects</h2>
        @if ($lastProspects->isNotEmpty())
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b dark:border-gray-700">
                        <th class="pb-3">Nom</th>
                        <th class="pb-3">Téléphone</th>
                        <th class="pb-3">Ville</th>
                        <th class="pb-3">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lastProspects as $prospect)
                        <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="py-3">{{ $prospect->full_name }}</td>
                            <td class="py-3">{{ $prospect->phone_number }}</td>
                            <td class="py-3">{{ $prospect->city }}</td>
                            <td class="py-3">{{ $prospect->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500 dark:text-gray-400">Aucun prospect pour le moment.</p>
        @endif
    </div>
</div>
@endsection