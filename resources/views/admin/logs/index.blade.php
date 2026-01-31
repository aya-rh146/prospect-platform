@extends('layouts.admin')

@section('title', __('messages.logs.title'))

@section('content')
<div class="p-6 bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold text-slate-800 mb-2">{{ __('messages.logs.title') }}</h1>
                <p class="text-slate-600">{{ __('messages.logs.description') }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">{{ __('messages.dashboard.stats.total') }}</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">{{ __('messages.dashboard.stats.today') }}</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['today'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Prospects</h3>
            <p class="text-3xl font-bold text-purple-600">{{ $stats['prospects'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Vidéos</h3>
            <p class="text-3xl font-bold text-orange-600">{{ $stats['videos'] }}</p>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <select name="subject_type" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">{{ __('messages.common.all') }} Types</option>
                <option value="Prospect" {{ request('subject_type') == 'Prospect' ? 'selected' : '' }}>Prospects</option>
                <option value="Video" {{ request('subject_type') == 'Video' ? 'selected' : '' }}>Vidéos</option>
            </select>

            <select name="action" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">{{ __('messages.common.all') }} Actions</option>
                <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Créé</option>
                <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Modifié</option>
                <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Supprimé</option>
            </select>

            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                   class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Date début">

            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                   class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Date fin">

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    {{ __('messages.common.search') }}
                </button>
                <a href="{{ route('admin.logs.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    {{ __('messages.common.cancel') }}
                </a>
            </div>
        </form>
    </div>

    <!-- Tableau des logs -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-slate-800">Historique des activités</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('messages.logs.table.date') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('messages.logs.table.user') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('messages.logs.table.action') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('messages.logs.table.subject') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $log->causer ? $log->causer->name : 'System' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($log->description == 'created') bg-green-100 text-green-800
                                    @elseif($log->description == 'updated') bg-blue-100 text-blue-800
                                    @elseif($log->description == 'deleted') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($log->description) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($log->subject)
                                    {{ class_basename($log->subject) }} #{{ $log->subject->id ?? '' }}
                                    @if($log->subject_type == 'App\Models\Prospect')
                                        <br><span class="text-xs text-gray-500">{{ $log->subject->full_name ?? '' }}</span>
                                    @elseif($log->subject_type == 'App\Models\Video')
                                        <br><span class="text-xs text-gray-500">{{ $log->subject->title ?? '' }}</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.logs.show', $log) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    {{ __('messages.logs.actions.view') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-2">{{ __('messages.logs.table.empty') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                {{ $logs->links() }}
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Affichage de <span class="font-medium">{{ $logs->firstItem() }}</span> à 
                        <span class="font-medium">{{ $logs->lastItem() }}</span> sur 
                        <span class="font-medium">{{ $logs->total() }}</span> résultats
                    </p>
                </div>
                <div>
                    {{ $logs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
