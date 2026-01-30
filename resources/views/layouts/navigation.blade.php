<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <img src="{{ asset('images/foto.png') }}" alt="Business Pro Academy" class="h-20 w-20">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('messages.nav.dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.prospects.index')" :active="request()->routeIs('admin.prospects.*')">
                        {{ __('messages.nav.prospects') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.videos.index')" :active="request()->routeIs('admin.videos.*')">
                        {{ __('messages.nav.videos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings')">
                        {{ __('messages.nav.settings') }}
                    </x-nav-link>
                </div>
                
                <!-- Language Selector -->
                <div class="ms-3">
                    <select onchange="window.location.href='{{ request()->url() }}?locale='+this.value" 
                            class="bg-gray-700 text-white text-sm rounded-lg px-3 py-2 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="fr" {{ app()->getLocale() === 'fr' ? 'selected' : '' }}>
                            🇫🇷 {{ __('messages.language.french') }}
                        </option>
                        <option value="ar" {{ app()->getLocale() === 'ar' ? 'selected' : '' }}>
                            🇸🇦 {{ __('messages.language.arabic') }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- Notification Bell Dropdown + User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Notification Bell Dropdown -->
                <x-dropdown align="right" width="md">
                    <x-slot name="trigger">
                        <button class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none transition">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>

                            <!-- Badge nombre des leads nouveaux aujourd'hui + non lus -->
                            @php
                                $newLeadsToday = App\Models\Prospect::whereDate('created_at', today())->count();
                                $unreadLeadsCount = session('new_prospect_notification') ? $newLeadsToday + 1 : $newLeadsToday;
                            @endphp
                            @if($unreadLeadsCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full transform translate-x-1/2 -translate-y-1/2 animate-pulse">
                                    {{ $unreadLeadsCount }}
                                </span>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Titre des notifications -->
                        <div class="block px-4 py-3 text-sm font-semibold text-gray-700 border-b border-gray-200">
                            Notifications des nouveaux leads aujourd'hui
                        </div>

                        <!-- Liste des nouveaux leads -->
                        @php
                            $recentNewLeads = App\Models\Prospect::whereDate('created_at', today())
                                                ->latest()
                                                ->take(8)
                                                ->get();
                        @endphp

                        @if($recentNewLeads->isEmpty())
                            <div class="px-4 py-8 text-center text-gray-500 text-sm">
                                Aucune nouvelle notification aujourd'hui 😊
                            </div>
                        @else
                            @foreach($recentNewLeads as $lead)
                                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition">
                                    <div class="flex-1 pr-4">
                                        <div class="font-semibold text-gray-900">{{ $lead->full_name }}</div>
                                        <div class="text-sm text-gray-600">📞 {{ $lead->phone_number }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $lead->created_at->diffForHumans() }}</div>
                                    </div>
                                    <a href="https://wa.me/212{{ ltrim($lead->phone_number, '0') }}?text=Bonjour%20{{ urlencode($lead->full_name) }}%0A%0AMerci%20beaucoup%20pour%20votre%20intérêt%20pour%20notre%20formation%20Network%20Marketing.%0A%0AJe%20suis%20Aya%20Rouah%20et%20je%20suis%20là%20pour%20vous%20aider%20personnellement%20et%20avancer%20avec%20vous%20pas%20à%20pas.%0A%0ALaissez%20juste%20%22intéressé(e)%22%20pour%20commencer%20immédiatement%20!%0A%0AEn%20attendant%20votre%20réponse%20rapide%20🚀" 
                                       target="_blank"
                                       class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-full shadow transition">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.297-.446.099-.148.099-.272.099-.372 0-.099-.446-.297-.644-.495-.198-.198-.446-.396-.595-.594-.149-.198-.298-.198-.447-.198h-.595c-.198 0-.446.099-.644.297-.198.198-.347.446-.347.744 0 .297.149.595.297.893.149.297.446.595.644.893.198.198.396.396.595.495.198.099.396.099.595.099.198 0 .396-.099.595-.198.198-.099.396-.198.495-.396.099-.198.198-.396.198-.595 0-.198-.099-.396-.198-.495zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                        </svg>
                                        WhatsApp
                                    </a>
                                </div>
                            @endforeach
                        @endif

                        <!-- Voir tout -->
                        <div class="px-4 py-3 text-center border-t border-gray-200">
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                Voir tous les prospects →
                            </a>
                        </div>
                    </x-slot>
                </x-dropdown>

                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none transition">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Modifier mes informations') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.prospects.index')" :active="request()->routeIs('admin.prospects.*')">
                {{ __('Prospects') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.videos.index')" :active="request()->routeIs('admin.videos.*')">
                {{ __('Gestion des vidéos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings')">
                {{ __('Settings') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Modifier mes informations') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>