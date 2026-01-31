@extends('layouts.admin')

@section('title', 'Détail du Log')

@section('content')
<div class="p-6 bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.logs.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour
            </a>
            <h1 class="text-3xl font-bold text-slate-800">Détail du Log</h1>
        </div>
    </div>

    <!-- Log Details -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations générales -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Date et Heure</h3>
                        <p class="text-lg text-gray-900">{{ $log->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Action</h3>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                            @if($log->description == 'created') bg-green-100 text-green-800
                            @elseif($log->description == 'updated') bg-blue-100 text-blue-800
                            @elseif($log->description == 'deleted') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($log->description) }}
                        </span>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Utilisateur</h3>
                        <p class="text-lg text-gray-900">
                            {{ $log->causer ? $log->causer->name : 'System' }}
                            @if($log->causer)
                                <span class="text-sm text-gray-500">({{ $log->causer->email }})</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Adresse IP</h3>
                        <p class="text-lg text-gray-900">{{ $log->ip_address ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Détails du sujet -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Type de Sujet</h3>
                        <p class="text-lg text-gray-900">{{ $log->subject_type ? class_basename($log->subject_type) : 'N/A' }}</p>
                    </div>

                    @if($log->subject)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">ID du Sujet</h3>
                            <p class="text-lg text-gray-900">#{{ $log->subject->id }}</p>
                        </div>

                        @if($log->subject_type == 'App\Models\Prospect')
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Nom du Prospect</h3>
                                <p class="text-lg text-gray-900">{{ $log->subject->full_name }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Email</h3>
                                <p class="text-lg text-gray-900">{{ $log->subject->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Ville</h3>
                                <p class="text-lg text-gray-900">{{ $log->subject->city }}</p>
                            </div>
                        @elseif($log->subject_type == 'App\Models\Video')
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Titre de la Vidéo</h3>
                                <p class="text-lg text-gray-900">{{ $log->subject->title }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">URL</h3>
                                <p class="text-sm text-gray-600 break-all">{{ $log->subject->video_url }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Statut</h3>
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($log->subject->is_active) bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $log->subject->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Changements (si disponibles) -->
            @if($log->properties && isset($log->properties['attributes']))
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Changements Détailés</h3>
                    
                    @if(isset($log->properties['old']) && isset($log->properties['attributes']))
                        <div class="space-y-3">
                            @foreach($log->properties['attributes'] as $key => $newValue)
                                @if(isset($log->properties['old'][$key]))
                                    <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded">
                                        <span class="font-medium text-gray-700">{{ $key }}:</span>
                                        <div class="flex items-center space-x-3">
                                            <span class="text-red-600 line-through">{{ $log->properties['old'][$key] }}</span>
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                            <span class="text-green-600 font-medium">{{ $newValue }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center justify-between py-2 px-3 bg-green-50 rounded">
                                        <span class="font-medium text-gray-700">{{ $key }}:</span>
                                        <span class="text-green-600 font-medium">{{ $newValue }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="space-y-2">
                            @foreach($log->properties['attributes'] as $key => $value)
                                <div class="flex justify-between py-2 px-3 bg-gray-50 rounded">
                                    <span class="font-medium text-gray-700">{{ $key }}:</span>
                                    <span class="text-gray-900">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
