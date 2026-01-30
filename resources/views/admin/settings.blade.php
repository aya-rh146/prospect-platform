@extends('layouts.admin')

@section('title', __('messages.settings.title'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('messages.settings.account_title') }}
            </h2>
            <p class="text-gray-600 mt-2">{{ __('messages.settings.account_description') }}</p>
        </div>

        <!-- Messages flash -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire settings -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b">
                <h3 class="text-2xl font-bold">{{ __('messages.settings.personal_info') }}</h3>
            </div>
            
            <form method="POST" action="{{ route('admin.settings.update') }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.settings.name') }}
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ auth()->user()->name }}" 
                               required
                               class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.settings.email') }}
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ auth()->user()->email }}" 
                               required
                               class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Changement mot de passe -->
                <div class="mt-8 pt-8 border-t">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">{{ __('messages.settings.password_change') }}</h4>
                    <p class="text-gray-600 mb-6">{{ __('messages.settings.password_note') }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Mot de passe actuel -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('messages.settings.current_password') }}
                            </label>
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password" 
                                   class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full">
                            @error('current_password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nouveau mot de passe -->
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('messages.settings.new_password') }}
                            </label>
                            <input type="password" 
                                   id="new_password" 
                                   name="new_password" 
                                   class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full">
                            @error('new_password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmation mot de passe -->
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('messages.settings.confirm_password') }}
                            </label>
                            <input type="password" 
                                   id="new_password_confirmation" 
                                   name="new_password_confirmation" 
                                   class="border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full">
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="mt-8 flex justify-end gap-4">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition">
                        {{ __('messages.common.cancel') }}
                    </a>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg">
                        {{ __('messages.settings.save_changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
