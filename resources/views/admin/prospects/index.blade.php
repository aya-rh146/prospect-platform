@extends('layouts.admin') <!-- إلا عندك layout، ولا خليه html عادي -->

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Liste des Prospects ({{ $prospects->total() }})</h1>

    <!-- Form البحث والفلتر -->
    <div class="bg-white p-6 rounded-xl shadow-md mb-8">
        <form method="GET" action="{{ route('admin.prospects.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Recherche</label>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Nom, téléphone ou email..." 
                    class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Ville</label>
                <select name="city" class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500">
                    <option value="">Toutes les villes</option>
                    <option value="Tangier" {{ request('city') == 'Tangier' ? 'selected' : '' }}>Tangier</option>
                    <option value="Tetouan" {{ request('city') == 'Tetouan' ? 'selected' : '' }}>Tetouan</option>
                    <option value="Rabat" {{ request('city') == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                    <option value="Kenitra" {{ request('city') == 'Kenitra' ? 'selected' : '' }}>Kenitra</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg w-full">
                    Filtrer
                </button>
            </div>
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('admin.prospects.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg">
                    Ajouter un prospect
                </a>

                <a href="{{ route('admin.prospects.export') . '?' . $prospects->appends(request()->query())->query() }}" 
                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Exporter en Excel
                </a>
            </div>
        </form>
    </div>

    <!-- الجدول -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom Complet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ville</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($prospects as $prospect)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $prospect->full_name }}</td>
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
                            <td class="px-6 py-4 whitespace-nowrap">{{ $prospect->email ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                                    {{ $prospect->city }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $prospect->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.prospects.edit', $prospect) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Modifier</a>
                                <form action="{{ route('admin.prospects.destroy', $prospect) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr ?')" class="text-red-600 hover:text-red-900">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                Aucun prospect trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-4">
            {{ $prospects->links() }}
        </div>
    </div>
</div>
@endsection