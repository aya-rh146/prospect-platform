<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prospects - Business Pro Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Glass effect خفيف ومزيان */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        /* Animation fade in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 min-h-screen text-white">

    <!-- Navbar -->
    <header class="container mx-auto px-6 py-8 flex justify-between items-center">
        <div class="shrink-0 flex items-center">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <img src="{{ asset('images/foto.png') }}" alt="Business Pro Academy" class="h-20 w-20">
            </a>
        </div> 
        <div class="flex items-center gap-4">
            <!-- Theme Switcher -->
            <button onclick="toggleTheme()" class="glass px-6 py-3 rounded-full font-semibold text-lg hover:scale-105 transition transform shadow-xl">
                <span id="themeIcon" class="text-2xl">🌙</span>
            </button>
            <!-- Language Switcher -->
            <button onclick="toggleLanguage()" class="glass px-6 py-3 rounded-full font-semibold text-lg hover:scale-105 transition transform shadow-xl">
                <span id="langIcon" class="text-2xl">🇫🇷</span>
            </button>
            <a href="{{ route('home') }}" class="glass px-8 py-4 rounded-full font-semibold text-lg hover:scale-105 transition transform shadow-xl">
                Accueil
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 animate-fade-in">
                Gestion des <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-400">Prospects</span>
            </h1>
            <p class="text-xl text-gray-200 animate-fade-in" style="animation-delay: 0.2s">
                Consultez et gérez tous vos prospects
            </p>
        </div>

        <!-- Cards Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-8 rounded-xl shadow-lg text-white animate-fade-in" style="animation-delay: 0.3s">
                <h3 class="text-2xl font-bold">Total Prospects</h3>
                <p class="text-5xl font-extrabold mt-4">{{ $prospects->count() }}</p>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 rounded-xl shadow-lg text-white animate-fade-in" style="animation-delay: 0.4s">
                <h3 class="text-2xl font-bold">Prospects Aujourd'hui</h3>
                <p class="text-5xl font-extrabold mt-4">{{ $prospects->where('created_at', '>=', now()->startOfDay())->count() }}</p>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-8 rounded-xl shadow-lg text-white animate-fade-in" style="animation-delay: 0.5s">
                <h3 class="text-2xl font-bold">Prospects ce Mois</h3>
                <p class="text-5xl font-extrabold mt-4">{{ $prospects->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
            </div>
        </div>

        <!-- Tableau prospects -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-fade-in" style="animation-delay: 0.6s">
            <div class="p-6 border-b">
                <h3 class="text-2xl font-bold text-gray-900">Liste des Prospects</h3>
                <p class="text-gray-600 mt-1">{{ $prospects->count() }} prospect(s) trouvé(s)</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Téléphone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ville</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($prospects as $prospect)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $prospect->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $prospect->full_name }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span class="mr-4 text-gray-900">{{ $prospect->phone_number }}</span>
                                    <a href="https://wa.me/212{{ ltrim($prospect->phone_number, '0') }}?text=Bonjour%20{{ urlencode($prospect->full_name) }}%2C%20je%20suis%20intéressé(e)%20par%20vos%20services%20de%20formation.%0A%0APouvez-vous%20me%20donner%20plus%20d'informations%20%3F" 
                                       target="_blank" 
                                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium text-sm rounded-full transition shadow-md">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.297-.446.099-.148.099-.272.099-.372 0-.099-.446-.297-.644-.495-.198-.198-.446-.396-.595-.594-.149-.198-.298-.198-.447-.198h-.595c-.198 0-.446.099-.644.297-.198.198-.347.446-.347.744 0 .297.149.595.297.893.149.297.446.595.644.893.198.198.396.396.595.495.198.099.396.099.595.099.198 0 .396-.099.595-.198.198-.099.396-.198.495-.396.099-.198.198-.396.198-.595 0-.198-.099-.396-.198-.495zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                        </svg>
                                        WhatsApp
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $prospect->email ?? 'Non renseigné' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-sm rounded-full bg-indigo-100 text-indigo-800">
                                    {{ $prospect->city }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $prospect->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.prospects.edit', $prospect->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 font-medium">
                                        Modifier
                                    </a>
                                    <button onclick="confirmDelete({{ $prospect->id }}, '{{ $prospect->full_name }}')" 
                                            class="text-red-600 hover:text-red-900 font-medium">
                                        Supprimer
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                Aucun prospect trouvé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($prospects->hasPages())
        <div class="mt-8">
            {{ $prospects->appends(request()->query())->links() }}
        </div>
        @endif
    </main>

    <!-- Modal confirmation suppression -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4 shadow-2xl">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Confirmation de suppression</h3>
            <p id="deleteMessage" class="text-gray-600 mb-6"></p>
            <div class="flex justify-end gap-3">
                <button onclick="closeDeleteModal()" class="px-6 py-3 text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition">
                    Annuler
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-lg">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    // Theme Toggle
    function toggleTheme() {
        const body = document.body;
        const themeIcon = document.getElementById('themeIcon');
        
        if (body.classList.contains('dark')) {
            body.classList.remove('dark');
            body.classList.add('light');
            body.style.background = 'linear-gradient(to bottom right, #312e81, #581c87, #831843)';
            themeIcon.textContent = '🌙';
            localStorage.setItem('theme', 'light');
        } else {
            body.classList.remove('light');
            body.classList.add('dark');
            body.style.background = 'linear-gradient(to bottom right, #1e1b4b, #312e81, #581c87)';
            themeIcon.textContent = '☀️';
            localStorage.setItem('theme', 'dark');
        }
    }

    // Language Toggle
    function toggleLanguage() {
        const langIcon = document.getElementById('langIcon');
        const title = document.querySelector('h1');
        const description = document.querySelector('p');
        
        if (langIcon.textContent === '🇫🇷') {
            langIcon.textContent = '🇫🇷';
            title.innerHTML = 'إدارة <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-400">العملاء المحتملين</span>';
            description.textContent = 'استشر وإدارة جميع عملائك المحتملين';
            localStorage.setItem('lang', 'ar');
        } else {
            langIcon.textContent = '🇫🇷';
            title.innerHTML = 'Gestion des <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-400">Prospects</span>';
            description.textContent = 'Consultez et gérez tous vos prospects';
            localStorage.setItem('lang', 'fr');
        }
    }

    // Initialize theme and language
    document.addEventListener('DOMContentLoaded', function() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        const savedLang = localStorage.getItem('lang') || 'fr';
        
        if (savedTheme === 'dark') {
            toggleTheme();
        }
        
        if (savedLang === 'ar') {
            toggleLanguage();
        }
    });

    // Modal suppression individuelle
    function confirmDelete(id, name) {
        document.getElementById('deleteMessage').textContent = `Êtes-vous sûr de vouloir supprimer "${name}" ?`;
        document.getElementById('deleteForm').action = `/admin/prospects/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    </script>
</body>
</html>
