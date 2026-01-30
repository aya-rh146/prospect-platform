@extends('layouts.admin')

@section('title', __('messages.dashboard.title'))

@section('content')
<div class="py-12">
    <h1 class="text-3xl font-bold mb-8">{{ __('messages.dashboard.title') }}</h1>

    <!-- Stats cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-300">{{ __('messages.dashboard.stats.total') }}</h3>
            <p class="text-4xl font-bold text-indigo-600">{{ $totalProspects ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-300">{{ __('messages.dashboard.stats.today') }}</h3>
            <p class="text-4xl font-bold text-emerald-600">{{ $newToday ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-300">{{ __('messages.dashboard.stats.top_city') }}</h3>
            <p class="text-2xl font-bold text-pink-600">{{ $topCity !== 'none' ? __('cities.' . $topCity) ?? ucfirst($topCity) : __('messages.dashboard.stats.none') }}</p>
        </div>
    </div>

    <!-- Derniers prospects -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold mb-4">{{ __('messages.dashboard.recent.title') }}</h2>
        @if ($lastProspects->isNotEmpty())
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b dark:border-gray-700">
                        <th class="pb-3 font-semibold">{{ __('messages.dashboard.recent.name') }}</th>
                        <th class="pb-3 font-semibold">{{ __('messages.dashboard.recent.phone') }}</th>
                        <th class="pb-3 font-semibold">{{ __('messages.dashboard.recent.city') }}</th>
                        <th class="pb-3 font-semibold">{{ __('messages.dashboard.recent.date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lastProspects as $prospect)
                        <tr class="border-b dark:border-gray-700">
                            <td class="py-3">{{ $prospect->full_name }}</td>
                            <td class="py-3">{{ $prospect->phone_number }}</td>
                            <td class="py-3">{{ __('cities.' . strtolower(trim($prospect->city))) ?? ucfirst(strtolower(trim($prospect->city))) }}</td>
                            <td class="py-3">{{ $prospect->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500 dark:text-gray-400">{{ __('messages.dashboard.recent.empty') }}</p>
        @endif
    </div>
</div>
@endsection