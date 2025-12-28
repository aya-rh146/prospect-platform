<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prospect Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- Navbar مع Button Espace Admin -->
    <header class="container mx-auto px-6 py-8 flex justify-between items-center">
        <div class="shrink-0 flex items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/foto.png') }}" alt="Business Pro Academy" class="h-20 w-20">                    </a>
        </div> 
       <button onclick="document.getElementById('loginModal').classList.remove('hidden')"
                class="glass px-8 py-4 rounded-full font-semibold text-lg hover:scale-105 transition transform shadow-xl">
            Espace Admin
        </button>
    </header>

    <!-- Hero Section -->
    <section class="container mx-auto px-6 py-16 text-center">
        <h2 class="text-5xl md:text-7xl font-extrabold mb-6 animate-fade-in">
            Capturez vos leads <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-400">facilement</span>
        </h2>
        <p class="text-xl md:text-2xl text-white/80 mb-12 max-w-4xl mx-auto animate-fade-in opacity-0 animation-delay-300">
            Une plateforme moderne pour collecter, gérer et convertir vos prospects en clients.
        </p>

        <!-- Messages Success / Error -->
        @if(session('success'))
            <div class="glass max-w-2xl mx-auto p-6 rounded-2xl mb-8 animate-fade-in">
                <p class="text-green-300 text-lg font-semibold">{{ session('success') }}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="glass max-w-2xl mx-auto p-6 rounded-2xl mb-8 animate-fade-in">
                <ul class="text-red-300 space-y-2">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Prospect -->
        <div class="glass max-w-3xl mx-auto p-10 rounded-3xl shadow-2xl animate-fade-in">
            <form action="{{ route('prospects.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Nom Complet *" required
                           class="glass px-6 py-4 rounded-xl focus:outline-none focus:ring-4 focus:ring-pink-500/50 text-lg">
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="Téléphone *" required
                           class="glass px-6 py-4 rounded-xl focus:outline-none focus:ring-4 focus:ring-pink-500/50 text-lg">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email (optionnel)"
                           class="glass px-6 py-4 rounded-xl focus:outline-none focus:ring-4 focus:ring-pink-500/50 text-lg">
                    <select name="city" required
                            class="glass px-6 py-4 rounded-xl focus:outline-none focus:ring-4 focus:ring-pink-500/50 text-lg">
                        <option value="">Ville *</option>
                        <option value="Tangier" {{ old('city') == 'Tangier' ? 'selected' : '' }}>Tangier</option>
                        <option value="Tetouan" {{ old('city') == 'Tetouan' ? 'selected' : '' }}>Tetouan</option>
                        <option value="Rabat" {{ old('city') == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                        <option value="Kenitra" {{ old('city') == 'Kenitra' ? 'selected' : '' }}>Kenitra</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-pink-600 to-yellow-500 py-5 rounded-xl text-xl font-bold hover:scale-105 transition transform shadow-2xl">
                    Envoyer ma demande
                </button>
            </form>
        </div>
    </section>

    <!-- Videos Section -->
    <section class="container mx-auto px-6 py-16">
        <h2 class="text-4xl font-bold text-center mb-12">Vidéos Highlights</h2>
        @if($videos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($videos as $video)
                    <div class="glass rounded-2xl overflow-hidden shadow-2xl hover:scale-105 transition transform">
                        <video controls class="w-full h-64 object-cover">
                            <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                            Votre navigateur ne supporte pas la vidéo.
                        </video>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-center">{{ $video->title }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-white/70 text-xl">Aucune vidéo disponible pour le moment.</p>
        @endif
    </section>

    <!-- Login Modal (مخفي حتى تضغط على الـ button) -->
    <div id="loginModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70 px-4">
        <div class="glass max-w-md w-full p-10 rounded-3xl shadow-2xl">
            <h2 class="text-4xl font-bold text-center mb-10">Connexion Admin</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="Email" required autofocus
                    class="w-full glass mb-6 px-6 py-4 rounded-xl focus:ring-4 focus:ring-pink-500/50 text-lg">
                <input type="password" name="password" placeholder="Mot de passe" required
                    class="w-full glass mb-10 px-6 py-4 rounded-xl focus:ring-4 focus:ring-pink-500/50 text-lg">
                <button type="submit" class="w-full bg-gradient-to-r from-pink-600 to-purple-600 py-5 rounded-xl text-xl font-bold hover:scale-105 transition shadow-xl">
                    Se connecter
                </button>
            </form>
            <button onclick="document.getElementById('loginModal').classList.add('hidden')"
                    class="w-full mt-6 text-white/70 hover:text-white text-center text-lg">
                Fermer
            </button>
        </div>
    </div>

    <script>
        // Animation delay خفيفة
        document.querySelectorAll('.animation-delay-300').forEach(el => {
            el.style.animationDelay = '0.3s';
        });
    </script>
</body>
</html>