<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Cards Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-8 rounded-xl shadow-lg text-white">
                    <h3 class="text-2xl font-bold">Total Prospects</h3>
                    <p class="text-5xl font-extrabold mt-4">{{ $totalProspects }}</p>
                </div>

                <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 rounded-xl shadow-lg text-white">
                    <h3 class="text-2xl font-bold">Prospects Aujourd'hui</h3>
                    <p class="text-5xl font-extrabold mt-4">{{ $todayProspects }}</p>
                </div>

                <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-8 rounded-xl shadow-lg text-white">
                    <h3 class="text-2xl font-bold">Prospects ce Mois</h3>
                    <p class="text-5xl font-extrabold mt-4">{{ $monthProspects }}</p>
                </div>
            </div>

            <!-- Visitors Cards + Pie Chart -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <h3 class="text-2xl font-bold mb-6">Visiteurs</h3>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <p class="text-gray-600">Aujourd'hui</p>
                            <p class="text-4xl font-bold text-blue-600">{{ $visitorsToday }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Ce Mois</p>
                            <p class="text-4xl font-bold text-green-600">{{ $visitorsMonth }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Total</p>
                            <p class="text-4xl font-bold text-purple-600">{{ $visitorsTotal }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <h3 class="text-2xl font-bold mb-6">Répartition par Ville</h3>
                    <canvas id="cityChart" height="200"></canvas>
                </div>
            </div>

            <!-- Advanced Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <h3 class="text-2xl font-bold mb-6">Évolution des Prospects</h3>
                    <canvas id="evolutionChart" height="250"></canvas>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <h3 class="text-2xl font-bold mb-6">Taux de Conversion</h3>
                    <canvas id="conversionChart" height="250"></canvas>
                </div>
            </div>

            <!-- Derniers Prospects -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 border-b">
                    <h3 class="text-2xl font-bold">Derniers Prospects</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Téléphone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ville</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentProspects as $prospect)
                                <tr>
                                    <td class="px-6 py-4">{{ $prospect->full_name }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <span class="mr-4">{{ $prospect->phone_number }}</span>
                                            <a href="https://wa.me/212{{ ltrim($prospect->phone_number, '0') }}?text=السلام%20عليكم%20{{ urlencode($prospect->full_name) }}%0A%0Aمرحبا%20بيك%20بزاف،%20شكرا%20بزاف%20على%20اهتمامك%20بفورماسيون%20Network%20Marketing%20ديالنا!%%0A%0Aأنا%20آية%20الرواح%20،%20وأنا%20هنا%20باش%20نساعدك%20شخصياً%20ونمشيو%20معاك%20خطوة%20بخطوة.%0A%0Aأنا%20متواجدة%20دابا%20باش%20نجاوبك%20على%20كلشي%20خليلي%20غير%20%22مهتم%22%0A%0Aفي%20انتظار%20ردك%20بسرعة%20" 
                                                target="_blank"
                                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium text-sm rounded-full transition shadow-md">
                                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.297-.446.099-.148.099-.272.099-.372 0-.099-.446-.297-.644-.495-.198-.198-.446-.396-.595-.594-.149-.198-.298-.198-.447-.198h-.595c-.198 0-.446.099-.644.297-.198.198-.347.446-.347.744 0 .297.149.595.297.893.149.297.446.595.644.893.198.198.396.396.595.495.198.099.396.099.595.099.198 0 .396-.099.595-.198.198-.099.396-.198.495-.396.099-.198.198-.396.198-.595 0-.198-.099-.396-.198-.495zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                                    </svg>
                                                    WhatsApp
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-sm rounded-full bg-indigo-100 text-indigo-800">
                                            {{ $prospect->city }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $prospect->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        Aucun prospect pour le moment
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script>
        const cityData = @json($cityDistribution);
        const labels = Object.keys(cityData);
        const data = Object.values(cityData);

        const ctx = document.getElementById('cityChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        '#3b82f6', // blue
                        '#10b981', // green
                        '#f59e0b', // yellow
                        '#ef4444'  // red
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
        <!-- Notification Toast + Sound للـ Leads الجدد -->
    <audio id="newLeadSound" preload="auto">
    <source src="https://cdn.freesound.org/previews/321/321647_5627644-lq.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>

    <!-- Flash Notification pour nouveau prospect -->
    @if(session('new_prospect_notification'))
        <div id="flashNotification" class="fixed top-4 right-4 z-50 animate-pulse">
            <div class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4 rounded-lg shadow-2xl max-w-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">Nouveau prospect !</p>
                        <p class="text-xs mt-1">{{ session('new_prospect_notification')['name'] }} - {{ session('new_prospect_notification')['city'] }}</p>
                        <p class="text-xs">{{ session('new_prospect_notification')['created_at'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        let lastLeadId = {{ $lastLeadId ?? 0 }};

        function checkNewLeads() {
            fetch('{{ route("check.new.leads") }}?last_id=' + lastLeadId)
                .then(response => response.json())
                .then(data => {
                    if (data.new_leads.length > 0) {
                        data.new_leads.forEach(lead => {
                            Toastify({
                                text: "🔔 Lead جديد واعر! 🔥<br><strong>" + lead.name + "</strong><br>📞 " + lead.phone,
                                duration: 8000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                style: {
                                    background: "linear-gradient(135deg, #10b981, #059669)",
                                    fontSize: "15px",
                                    borderRadius: "12px",
                                    boxShadow: "0 10px 25px rgba(0,0,0,0.15)",
                                    padding: "16px"
                                }
                            }).showToast();

                            const sound = document.getElementById('newLeadSound');
                            sound.currentTime = 0;
                            sound.volume = 0.6;
                            sound.play();
                        });

                        lastLeadId = data.latest_id;
                    }
                })
                .catch(err => console.log('Polling error:', err));
        }

        setInterval(checkNewLeads, 5000);
        checkNewLeads();

        // Auto-hide flash notification après 5 secondes
        @if(session('new_prospect_notification'))
            setTimeout(() => {
                const flashNotif = document.getElementById('flashNotification');
                if (flashNotif) {
                    flashNotif.style.transition = 'opacity 0.5s';
                    flashNotif.style.opacity = '0';
                    setTimeout(() => flashNotif.remove(), 500);
                }
            }, 5000);
        @endif

        // Enhanced Charts
        // City Distribution Chart (Doughnut)
        const cityCtx = document.getElementById('cityChart').getContext('2d');
        new Chart(cityCtx, {
            type: 'doughnut',
            data: {
                labels: ['Tangier', 'Tetouan', 'Rabat', 'Kenitra'],
                datasets: [{
                    data: [{{ $cityStats['Tangier'] ?? 0 }}, {{ $cityStats['Tetouan'] ?? 0 }}, {{ $cityStats['Rabat'] ?? 0 }}, {{ $cityStats['Kenitra'] ?? 0 }}],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(251, 146, 60, 0.8)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(139, 92, 246, 1)',
                        'rgba(251, 146, 60, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: { size: 12 }
                        }
                    }
                }
            }
        });

        // Evolution Chart (Line)
        const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
        new Chart(evolutionCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Prospects',
                    data: [12, 19, 15, 25, 22, 30, 28, 35, 32, 40, 38, 45],
                    borderColor: 'rgba(99, 102, 241, 1)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // Conversion Chart (Bar)
        const conversionCtx = document.getElementById('conversionChart').getContext('2d');
        new Chart(conversionCtx, {
            type: 'bar',
            data: {
                labels: ['Tangier', 'Tetouan', 'Rabat', 'Kenitra'],
                datasets: [{
                    label: 'Taux de conversion (%)',
                    data: [65, 78, 52, 71],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(251, 146, 60, 0.8)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(139, 92, 246, 1)',
                        'rgba(251, 146, 60, 1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
</x-app-layout>