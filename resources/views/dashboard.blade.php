@extends('layouts.admin')

@section('title', __('messages.dashboard.title'))

@section('content')
<div class="py-12">
    <h1 class="text-3xl font-bold mb-8">{{ __('messages.dashboard.title') }}</h1>

    <!-- Stats cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
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
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
            <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-300">{{ __('messages.dashboard.stats.unique_visitors') }}</h3>
            <p class="text-4xl font-bold text-purple-600">{{ $uniqueVisitors ?? 0 }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $uniqueVisitorsToday ?? 0 }} {{ __('messages.dashboard.stats.today') }}</p>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10" wire:ignore>
        <!-- Pie Chart - Répartition par ville -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-bold mb-4">{{ app()->getLocale() === 'ar' ? 'توزيع حسب المدن' : 'Répartition par ville' }}</h3>
            <div class="relative h-64">
                <div id="cityChart"></div>
            </div>
        </div>

        <!-- Line Chart - Tendance mensuelle -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-bold mb-4">{{ app()->getLocale() === 'ar' ? 'الاتجاه الشهري' : 'Tendance mensuelle' }}</h3>
            <div class="relative h-64">
                <div id="trendChart"></div>
            </div>
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

<script>
let cityChart = null, trendChart = null;

// Debug - Vérifier les données
console.log('City data:', @json($cityData));
console.log('Monthly data:', @json($monthlyData));
console.log('ApexCharts disponible:', typeof ApexCharts);

// Vérifier si Livewire est disponible
if (typeof Livewire !== 'undefined') {
    console.log('Livewire détecté');
    
    // Attendre que Livewire soit chargé
    document.addEventListener('livewire:init', function() {
        console.log('Livewire initialisé');
        initCharts();
        
        // Hook pour les updates
        Livewire.hook('commit', ({ succeed }) => {
            succeed(() => {
                initCharts();
            });
        });
    });
} else {
    console.log('Livewire non détecté, initialisation directe');
    // Fallback si pas de Livewire
    initCharts();
}

function initCharts() {
    const cityData = @json($cityData);
    const monthlyData = @json($monthlyData);
    
    console.log('Dans initCharts - cityData:', cityData);
    console.log('Dans initCharts - monthlyData:', monthlyData);
    
    // Vérifier que les containers existent
    const cityContainer = document.querySelector("#cityChart");
    const trendContainer = document.querySelector("#trendChart");
    
    console.log('City container trouvé:', !!cityContainer);
    console.log('Trend container trouvé:', !!trendContainer);
    
    if (!cityData || !cityData.values || cityData.values.length === 0) {
        console.log('Pas de données pour city chart');
        return;
    }
    
    // City Chart - Bar
    if (!cityChart && cityContainer) {
        console.log('Création city chart...');
        cityChart = new ApexCharts(cityContainer, {
            series: [{ name: 'Prospects', data: cityData.values }],
            chart: { type: 'bar', height: 250 },
            xaxis: { categories: cityData.categories },
            colors: ['#3B82F6']
        });
        cityChart.render();
        console.log('City chart créé');
    } else if (cityChart) {
        console.log('Update city chart...');
        cityChart.updateSeries([cityData.values]);
        cityChart.updateOptions({ xaxis: { categories: cityData.categories } });
    }
    
    if (!monthlyData || !monthlyData.values || monthlyData.values.length === 0) {
        console.log('Pas de données pour trend chart');
        return;
    }
    
    // Trend Chart - Line
    if (!trendChart && trendContainer) {
        console.log('Création trend chart...');
        trendChart = new ApexCharts(trendContainer, {
            series: [{ name: 'Prospects', data: monthlyData.values }],
            chart: { type: 'line', height: 250 },
            xaxis: { categories: monthlyData.categories },
            colors: ['#10B981']
        });
        trendChart.render();
        console.log('Trend chart créé');
    } else if (trendChart) {
        console.log('Update trend chart...');
        trendChart.updateSeries([monthlyData.values]);
        trendChart.updateOptions({ xaxis: { categories: monthlyData.categories } });
    }
}
</script>
@endsection