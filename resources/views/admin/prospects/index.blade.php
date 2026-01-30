@extends('layouts.admin')

@section('title', __('messages.prospects.title'))

@section('content')
<div class="p-6 bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <!-- Header moderne -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold text-slate-800 mb-2">{{ __('messages.prospects.title') }}</h1>
                <p class="text-slate-600">{{ __('messages.prospects.description') }}</p>
            </div>
            <div class="flex gap-3">
                <button onclick="exportFiltered()" class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-6 py-3 rounded-xl hover:from-indigo-700 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    {{ __('messages.prospects.bulk.export_filtered') }}
                </button>
                <a href="{{ route('admin.prospects.export') }}" class="bg-gradient-to-r from-emerald-600 to-green-600 text-white px-6 py-3 rounded-xl hover:from-emerald-700 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    {{ __('messages.prospects.bulk.export_all') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Formulaire recherche et filtres modernes -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-8 mb-8">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-slate-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                {{ __('messages.prospects.search_filters') }}
            </h2>
        </div>
        <form method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.prospects.search_placeholder') }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                
                <select name="city" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    <option value="">{{ __('messages.prospects.filter_all') }}</option>
                    <option value="Tangier" {{ request('city') == 'Tangier' ? 'selected' : '' }}>Tangier</option>
                    <option value="Tetouan" {{ request('city') == 'Tetouan' ? 'selected' : '' }}>Tetouan</option>
                    <option value="Rabat" {{ request('city') == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                    <option value="Kenitra" {{ request('city') == 'Kenitra' ? 'selected' : '' }}>Kenitra</option>
                </select>
                
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
            </div>
            
            <div class="flex justify-between items-center mt-6">
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    {{ __('messages.common.search') }}
                </button>
                <a href="{{ route('admin.prospects.index') }}" class="text-slate-600 hover:text-slate-900 transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    {{ __('messages.prospects.reset_filters') }}
                </a>
            </div>
        </form>
    </div>

    <!-- Actions bulk -->
    @if($prospects->count() > 0)
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 mb-6 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <input type="checkbox" id="selectAll" class="w-5 h-5 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
            <label for="selectAll" class="text-sm font-medium text-slate-700">{{ __('messages.prospects.bulk.select_all') }}</label>
            <span id="selectedCount" class="text-sm text-slate-500">0 {{ __('messages.prospects.bulk.selected') }}</span>
        </div>
        
        <div class="flex gap-3">
            <button onclick="exportSelected()" class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-6 py-3 rounded-xl hover:from-indigo-700 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center disabled:opacity-50" id="exportSelectedBtn" disabled>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                {{ __('messages.prospects.bulk.export_selected') }}
            </button>
            <button onclick="deleteSelected()" class="bg-gradient-to-r from-red-600 to-pink-600 text-white px-6 py-3 rounded-xl hover:from-red-700 hover:to-pink-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center disabled:opacity-50" id="deleteSelectedBtn" disabled>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                {{ __('messages.prospects.bulk.delete') }}
            </button>
        </div>
    </div>
    @endif

    <!-- Tableau prospects moderne -->
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-8 py-6 border-b border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                {{ __('messages.prospects.list_title') }}
                <span class="ml-3 text-sm font-normal text-slate-600">({{ $prospects->count() }} {{ __('messages.prospects.results') }})</span>
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-8 py-4 text-left">
                            <input type="checkbox" id="headerCheckbox" class="w-5 h-5 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
                        </th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-slate-700 cursor-pointer hover:bg-slate-100 transition-colors" onclick="sortTable('id')">
                            ID <span class="text-slate-400">↕</span>
                        </th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-slate-700 cursor-pointer hover:bg-slate-100 transition-colors" onclick="sortTable('full_name')">
                            {{ __('messages.prospects.table.name') }} <span class="text-slate-400">↕</span>
                        </th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-slate-700">{{ __('messages.prospects.table.phone') }}</th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-slate-700">{{ __('messages.prospects.table.email') }}</th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-slate-700 cursor-pointer hover:bg-slate-100 transition-colors" onclick="sortTable('city')">
                            {{ __('messages.prospects.table.city') }} <span class="text-slate-400">↕</span>
                        </th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-slate-700 cursor-pointer hover:bg-slate-100 transition-colors" onclick="sortTable('created_at')">
                            {{ __('messages.prospects.table.date') }} <span class="text-slate-400">↕</span>
                        </th>
                        <th class="px-8 py-4 text-left text-sm font-semibold text-slate-700">{{ __('messages.prospects.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prospects as $prospect)
                        <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors duration-200">
                            <td class="px-8 py-4">
                                <input type="checkbox" class="prospect-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500" value="{{ $prospect->id }}">
                            </td>
                            <td class="px-8 py-4">
                                <span class="font-mono text-sm font-medium text-slate-700">#{{ $prospect->id }}</span>
                            </td>
                            <td class="px-8 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                                        <span class="text-white font-bold text-sm">{{ substr($prospect->full_name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-slate-800 block">{{ $prospect->full_name }}</span>
                                        <span class="text-xs text-slate-500">ID: {{ $prospect->id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="font-medium text-slate-700">{{ $prospect->phone_number }}</span>
                                    <a href="https://wa.me/212{{ ltrim($prospect->phone_number, '0') }}?text=Bonjour%20{{ urlencode($prospect->full_name) }}%2C%20je%20suis%20intéressé(e)%20par%20vos%20services%20de%20formation.%0A%0APouvez-vous%20me%20donner%20plus%20d'informations%20%3F" 
                                       target="_blank" 
                                       class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-xs font-medium rounded-full transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.297-.446.099-.148.099-.272.099-.372 0-.099-.446-.297-.644-.495-.198-.198-.446-.396-.595-.594-.149-.198-.298-.198-.447-.198h-.595c-.198 0-.446.099-.644.297-.198.198-.347.446-.347.744 0 .297.149.595.297.893.149.297.446.595.644.893.198.198.396.396.595.495.198.099.396.099.595.099.198 0 .396-.099.595-.198.198-.099.396-.198.495-.396.099-.198.198-.396.198-.595 0-.198-.099-.396-.198-.495zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                        </svg>
                                        WhatsApp
                                    </a>
                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <span class="text-slate-600">{{ $prospect->email ?? __('messages.prospects.no_email') }}</span>
                            </td>
                            <td class="px-8 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-pink-100 to-rose-100 text-pink-800 border border-pink-200">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ __('cities.' . strtolower(trim($prospect->city))) ?? ucfirst(strtolower(trim($prospect->city))) }}
                                </span>
                            </td>
                            <td class="px-8 py-4">
                                <div class="space-y-1">
                                    <span class="text-sm text-slate-600 block">{{ $prospect->created_at->format('d/m/Y') }}</span>
                                    <span class="text-xs text-slate-400">{{ $prospect->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.prospects.edit', $prospect->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-xs font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        {{ __('messages.common.edit') }}
                                    </a>
                                    <button onclick="confirmDelete({{ $prospect->id }}, '{{ $prospect->full_name }}')" 
                                            class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white text-xs font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        {{ __('messages.common.delete') }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="text-slate-500 text-lg font-medium">{{ __('messages.prospects.table.empty') }}</p>
                                    <p class="text-slate-400 text-sm mt-1">{{ __('messages.prospects.table.empty_help') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($prospects->hasPages())
    <div class="mt-8 flex justify-center">
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 px-6 py-3">
            {{ $prospects->appends(request()->query())->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Modal confirmation suppression -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl border border-slate-200">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-900">{{ __('messages.prospects.delete_confirm_title') }}</h3>
                <p class="text-slate-600 text-sm">{{ __('messages.prospects.delete_confirm_subtitle') }}</p>
            </div>
        </div>
        <p id="deleteMessage" class="text-slate-600 mb-6"></p>
        <div class="flex justify-end gap-3">
            <button onclick="closeDeleteModal()" class="px-6 py-3 text-slate-600 hover:text-slate-900 rounded-xl hover:bg-slate-100 transition-all duration-200 font-medium">
                {{ __('messages.common.cancel') }}
            </button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 font-medium">
                    {{ __('messages.common.delete') }}
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
    selectedCount.textContent = checked.length + ' {{ __('messages.prospects.bulk.selected') }}';
    
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
    
    if (confirm(`{{ __('messages.prospects.bulk_delete_confirm') }}`.replace(':count', checked.length))) {
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

// Modal suppression
function confirmDelete(id, name) {
    document.getElementById('deleteMessage').textContent = `{{ __('messages.prospects.delete_confirm_message') }}`.replace(':name', name);
    document.getElementById('deleteForm').action = '{{ route("admin.prospects.destroy", ":id") }}'.replace(':id', id);
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Tri tableau (simple)
function sortTable(column) {
    const url = new URL(window.location);
    url.searchParams.set('sort', column);
    url.searchParams.set('order', url.searchParams.get('order') === 'asc' ? 'desc' : 'asc');
    window.location.href = url.toString();
}
</script>
@endsection