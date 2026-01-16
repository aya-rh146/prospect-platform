@extends('layouts.admin')

@section('title', 'Prospects - Gestion')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header avec actions bulk -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Gestion des Prospects
                </h2>
                <p class="text-gray-600 mt-2">Consultez, gérez et exportez tous vos prospects</p>
            </div>
            <div class="flex gap-3">
                <button onclick="exportFiltered()" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg">
                    Exporter filtré
                </button>
                <a href="{{ route('admin.prospects.export') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition shadow-lg">
                    Exporter tout
                </a>
            </div>
        </div>

        <!-- Formulaire recherche et filtres -->
        <div class="bg-white p-8 rounded-xl shadow-lg mb-8">
            <form method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher nom, téléphone, email..." class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    
                    <select name="city" class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Toutes les villes</option>
                        <option value="Tangier" {{ request('city') == 'Tangier' ? 'selected' : '' }}>Tangier</option>
                        <option value="Tetouan" {{ request('city') == 'Tetouan' ? 'selected' : '' }}>Tetouan</option>
                        <option value="Rabat" {{ request('city') == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                        <option value="Kenitra" {{ request('city') == 'Kenitra' ? 'selected' : '' }}>Kenitra</option>
                    </select>
                    
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
                <div class="flex justify-between items-center mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition shadow-lg">
                        Rechercher
                    </button>
                    <a href="{{ route('admin.prospects.index') }}" class="text-gray-600 hover:text-gray-900">
                        Réinitialiser filtres
                    </a>
                </div>
            </form>
        </div>

        <!-- Actions bulk -->
        @if($prospects->count() > 0)
        <div class="bg-white p-6 rounded-xl shadow-lg mb-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <input type="checkbox" id="selectAll" class="w-5 h-5 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
                <label for="selectAll" class="text-sm font-medium text-gray-700">Sélectionner tout</label>
                <span id="selectedCount" class="text-sm text-gray-500">0 sélectionné(s)</span>
            </div>
            
            <div class="flex gap-3">
                <button onclick="exportSelected()" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg disabled:opacity-50" id="exportSelectedBtn" disabled>
                    Exporter sélectionnés
                </button>
                <button onclick="deleteSelected()" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition shadow-lg disabled:opacity-50" id="deleteSelectedBtn" disabled>
                    Supprimer sélectionnés
                </button>
            </div>
        </div>
        @endif

        <!-- Tableau prospects -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b">
                <h3 class="text-2xl font-bold">Liste des Prospects</h3>
                <p class="text-gray-600 mt-1">{{ $prospects->count() }} prospect(s) trouvé(s)</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox" id="headerCheckbox" class="w-5 h-5 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable('id')">
                                ID <span class="text-gray-400">↕</span>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable('full_name')">
                                Nom <span class="text-gray-400">↕</span>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Téléphone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable('city')">
                                Ville <span class="text-gray-400">↕</span>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-100" onclick="sortTable('created_at')">
                                Date <span class="text-gray-400">↕</span>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($prospects as $prospect)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="prospect-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500" value="{{ $prospect->id }}">
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $prospect->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $prospect->full_name }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span class="mr-4">{{ $prospect->phone_number }}</span>
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
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
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
    </div>
</div>

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
// Gestion checkboxes bulk
const selectAll = document.getElementById('selectAll');
const headerCheckbox = document.getElementById('headerCheckbox');
const checkboxes = document.querySelectorAll('.prospect-checkbox');
const selectedCount = document.getElementById('selectedCount');
const exportSelectedBtn = document.getElementById('exportSelectedBtn');
const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

function updateSelectedCount() {
    const checked = document.querySelectorAll('.prospect-checkbox:checked');
    selectedCount.textContent = checked.length + ' sélectionné(s)';
    
    const hasSelection = checked.length > 0;
    exportSelectedBtn.disabled = !hasSelection;
    deleteSelectedBtn.disabled = !hasSelection;
}

// Sélectionner tout
selectAll.addEventListener('change', function() {
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateSelectedCount();
});

headerCheckbox.addEventListener('change', function() {
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateSelectedCount();
});

// Checkbox individuels
checkboxes.forEach(cb => {
    cb.addEventListener('change', updateSelectedCount);
});

// Exporter sélectionnés
function exportSelected() {
    const checked = document.querySelectorAll('.prospect-checkbox:checked');
    const ids = Array.from(checked).map(cb => cb.value);
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.prospects.export") }}';
    
    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);
    
    const idsInput = document.createElement('input');
    idsInput.type = 'hidden';
    idsInput.name = 'selected_ids';
    idsInput.value = ids.join(',');
    form.appendChild(idsInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Exporter filtré
function exportFiltered() {
    window.location.href = '{{ route("admin.prospects.export") }}?' + new URLSearchParams(window.location.search).toString();
}

// Supprimer sélectionnés
function deleteSelected() {
    const checked = document.querySelectorAll('.prospect-checkbox:checked');
    if (checked.length === 0) return;
    
    if (confirm(`Êtes-vous sûr de vouloir supprimer ${checked.length} prospect(s) ?`)) {
        const ids = Array.from(checked).map(cb => cb.value);
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.prospects.bulkDelete") }}';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        
        const idsInput = document.createElement('input');
        idsInput.type = 'hidden';
        idsInput.name = 'selected_ids';
        idsInput.value = ids.join(',');
        form.appendChild(idsInput);
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Modal suppression individuelle
function confirmDelete(id, name) {
    document.getElementById('deleteMessage').textContent = `Êtes-vous sûr de vouloir supprimer "${name}" ?`;
    document.getElementById('deleteForm').action = `{{ route('admin.prospects.destroy', ':id') }}`.replace(':id', id);
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Tri tableau
let sortOrder = {};
function sortTable(column) {
    sortOrder[column] = sortOrder[column] === 'asc' ? 'desc' : 'asc';
    
    const url = new URL(window.location);
    url.searchParams.set('sort', column);
    url.searchParams.set('order', sortOrder[column]);
    
    window.location.href = url.toString();
}

// Initialisation
updateSelectedCount();
</script>
@endsection