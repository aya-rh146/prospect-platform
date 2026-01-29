<!DOCTYPE html>
<html lang="fr" dir="ltr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prospect Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        /* Glass effect léger et moderne */
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

    <!-- Navbar avec Button Espace Admin -->
    <header class="container mx-auto max-w-7xl px-6 py-8 flex justify-between items-center">
        <div class="shrink-0 flex items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/foto.png') }}" alt="Business Pro Academy" class="h-20 w-20">                    </a>
        </div> 
       @if(auth()->check())
           <a href="{{ route('dashboard') }}"
                   class="glass px-8 py-4 rounded-full font-semibold text-lg hover:scale-105 transition transform shadow-xl">
               Espace Admin
           </a>
       @else
           <button onclick="document.getElementById('loginModal').classList.remove('hidden')"
                   class="glass px-8 py-4 rounded-full font-semibold text-lg hover:scale-105 transition transform shadow-xl">
               Espace Admin
           </button>
       @endif
    </header>

    <!-- Hero Section -->
    <section class="container mx-auto max-w-7xl px-6 py-16 text-center">
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
            <form action="{{ route('prospects.store') }}" method="POST" id="prospectForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <div>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Nom Complet *" required
                               class="glass px-6 py-4 rounded-xl focus:outline-none focus:ring-4 focus:ring-pink-500/50 text-lg w-full">
                        @error('full_name')
                            <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="Téléphone *" required
                               class="glass px-6 py-4 rounded-xl focus:outline-none focus:ring-4 focus:ring-pink-500/50 text-lg w-full">
                        @error('phone_number')
                            <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email (optionnel)"
                               class="glass px-6 py-4 rounded-xl focus:outline-none focus:ring-4 focus:ring-pink-500/50 text-lg w-full">
                        @error('email')
                            <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <select name="city" required
                                class="glass px-6 py-4 rounded-xl focus:outline-none focus:ring-4 focus:ring-pink-500/50 text-lg w-full">
                            <option value="">Ville *</option>
                            <option value="Tangier" {{ old('city') == 'Tangier' ? 'selected' : '' }}>Tangier</option>
                            <option value="Tetouan" {{ old('city') == 'Tetouan' ? 'selected' : '' }}>Tetouan</option>
                            <option value="Rabat" {{ old('city') == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                            <option value="Kenitra" {{ old('city') == 'Kenitra' ? 'selected' : '' }}>Kenitra</option>
                        </select>
                        @error('city')
                            <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-pink-600 to-yellow-500 py-5 rounded-xl text-xl font-bold hover:scale-105 transition transform shadow-2xl">
                    Envoyer ma demande
                </button>
                
                <!-- Google reCAPTCHA -->
                <div class="mt-6">
                    <div class="g-recaptcha" data-sitekey="6LcXvQpAAAAAKjYhN_8fXhJhN8pKjYhN8fXhJ"></div>
                </div>
            </form>
        </div>
    </section>

    <!-- Videos Highlights Section -->
    <section class="container mx-auto max-w-7xl px-6 py-16">
        <div class="relative">
            <!-- Boutons navigation -->
            <button id="prevBtn" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-all duration-300 opacity-0 hover:opacity-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button id="nextBtn" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-all duration-300 opacity-0 hover:opacity-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Videos Container -->
            <div class="overflow-hidden rounded-2xl">
                <div id="videosContainer" class="flex transition-transform duration-500 ease-in-out">
                    @if($videos->count() > 0)
                        @foreach($videos as $video)
                            <div class="w-full flex-shrink-0">
                                <video 
                                    poster="{{ asset('storage/' . $video->video_url) }}"
                                    class="w-full h-96 object-cover"
                                    muted
                                    loop>
                                    <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                                </video>
                            </div>
                        @endforeach
                    @else
                        <div class="w-full flex-shrink-0 flex items-center justify-center h-96 bg-white/10">
                            <p class="text-white/70 text-xl">Aucune vidéo disponible</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal (caché jusqu'à ce que vous cliquiez sur le button) -->
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

    <!-- Video Modal -->
    <div id="videoModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 px-4">
        <div class="relative max-w-4xl w-full">
            <button onclick="closeVideoModal()" class="absolute -top-12 right-0 text-white text-2xl hover:text-gray-300">
                ✕
            </button>
            <video id="modalVideo" controls class="w-full rounded-lg shadow-2xl">
                <source id="videoSource" src="" type="video/mp4">
                Votre navigateur ne supporte pas la vidéo.
            </video>
            <h3 id="videoTitle" class="text-white text-2xl font-bold text-center mt-4"></h3>
        </div>
    </div>

    <!-- Photo Modal -->
    <div id="photoModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 px-4">
        <div class="relative max-w-4xl w-full">
            <button onclick="closePhotoModal()" class="absolute -top-12 right-0 text-white text-2xl hover:text-gray-300">
                ✕
            </button>
            <img id="modalPhoto" src="" alt="" class="w-full rounded-lg shadow-2xl">
            <h3 id="photoTitle" class="text-white text-2xl font-bold text-center mt-4"></h3>
        </div>
    </div>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/212655767109?text=Bonjour%20Aya%2C%20je%20viens%20de%20votre%20site%2C%20je%20veux%20plus%20d'infos%20sur%20les%20prospects" 
       target="_blank"
       class="fixed bottom-8 right-8 bg-green-600 hover:bg-green-700 text-white p-4 rounded-full shadow-2xl hover:scale-110 transition transform z-40">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.297-.446.099-.148.099-.272.099-.372 0-.099-.446-.297-.644-.495-.198-.198-.446-.396-.595-.594-.149-.198-.298-.198-.447-.198h-.595c-.198 0-.446.099-.644.297-.198.198-.347.446-.347.744 0 .297.149.595.297.893.149.297.446.595.644.893.198.198.396.396.595.495.198.099.396.099.595.099.198 0 .396-.099.595-.198.198-.099.396-.198.495-.396.099-.198.198-.396.198-.595 0-.198-.099-.396-.198-.495zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
        </svg>
    </a>

    <!-- Footer -->
    <footer class="glass mt-20 py-8">
        <div class="container mx-auto max-w-7xl px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-white/80">&copy; {{ date('Y') }} Business Pro Academy. Tous droits réservés.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="https://wa.me/212655767109" target="_blank" class="text-white/80 hover:text-white transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.297-.446.099-.148.099-.272.099-.372 0-.099-.446-.297-.644-.495-.198-.198-.446-.396-.595-.594-.149-.198-.298-.198-.447-.198h-.595c-.198 0-.446.099-.644.297-.198.198-.347.446-.347.744 0 .297.149.595.297.893.149.297.446.595.644.893.198.198.396.396.595.495.198.099.396.099.595.099.198 0 .396-.099.595-.198.198-.099.396-.198.495-.396.099-.198.198-.396.198-.595 0-.198-.099-.396-.198-.495zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/aya.rouah146" target="_blank" class="text-white/80 hover:text-white transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                        </svg>
                    </a>
                    <a href="https://facebook.com/businessproacademy" target="_blank" class="text-white/80 hover:text-white transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Videos Auto-Slide
        let currentSlide = 0;
        const videosContainer = document.getElementById('videosContainer');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const totalSlides = videosContainer ? videosContainer.children.length : 0;

        if (videosContainer && totalSlides > 1) {
            // Auto-slide toutes les 5 secondes
            let autoSlideInterval = setInterval(nextSlide, 5000);

            function goToSlide(slideIndex) {
                currentSlide = slideIndex;
                if (currentSlide < 0) currentSlide = totalSlides - 1;
                if (currentSlide >= totalSlides) currentSlide = 0;
                
                videosContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
                
                // Reset auto-slide timer
                clearInterval(autoSlideInterval);
                autoSlideInterval = setInterval(nextSlide, 5000);
            }

            function nextSlide() {
                goToSlide(currentSlide + 1);
            }

            function prevSlide() {
                goToSlide(currentSlide - 1);
            }

            // Navigation manuelle
            prevBtn.addEventListener('click', prevSlide);
            nextBtn.addEventListener('click', nextSlide);

            // Touch/swipe support pour mobile
            let touchStartX = 0;
            let touchEndX = 0;

            videosContainer.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });

            videosContainer.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                if (touchEndX < touchStartX - 50) nextSlide();
                if (touchEndX > touchStartX + 50) prevSlide();
            }

            // Pause auto-slide au hover
            videosContainer.addEventListener('mouseenter', () => {
                clearInterval(autoSlideInterval);
            });

            videosContainer.addEventListener('mouseleave', () => {
                autoSlideInterval = setInterval(nextSlide, 5000);
            });
        }

        // Modal functions
        function openVideoModal(src, title) {
            document.getElementById('videoSource').src = src;
            document.getElementById('videoTitle').textContent = title;
            document.getElementById('videoModal').classList.remove('hidden');
            document.getElementById('modalVideo').play();
        }

        function closeVideoModal() {
            document.getElementById('videoModal').classList.add('hidden');
            document.getElementById('modalVideo').pause();
            document.getElementById('videoSource').src = '';
        }

        function openPhotoModal(src, title) {
            document.getElementById('modalPhoto').src = src;
            document.getElementById('photoTitle').textContent = title;
            document.getElementById('photoModal').classList.remove('hidden');
        }

        function closePhotoModal() {
            document.getElementById('photoModal').classList.add('hidden');
            document.getElementById('modalPhoto').src = '';
        }

        // Close modals on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeVideoModal();
                closePhotoModal();
            }
        });

        // Close modals on background click
        document.getElementById('videoModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeVideoModal();
            }
        });

        document.getElementById('photoModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePhotoModal();
            }
        });

        // Form validation frontend
        document.getElementById('prospectForm').addEventListener('submit', function(e) {
            const fullName = document.querySelector('input[name="full_name"]').value.trim();
            const phone = document.querySelector('input[name="phone_number"]').value.trim();
            const city = document.querySelector('select[name="city"]').value;

            let isValid = true;

            // Reset error messages
            document.querySelectorAll('.text-red-300').forEach(el => el.remove());

            if (!fullName) {
                showError('input[name="full_name"]', 'Le nom complet est requis');
                isValid = false;
            }

            if (!phone) {
                showError('input[name="phone_number"]', 'Le téléphone est requis');
                isValid = false;
            } else if (!/^[0-9+\s-]+$/.test(phone)) {
                showError('input[name="phone_number"]', 'Format de téléphone invalide');
                isValid = false;
            }

            if (!city) {
                showError('select[name="city"]', 'La ville est requise');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        function showError(selector, message) {
            const input = document.querySelector(selector);
            const error = document.createElement('p');
            error.className = 'text-red-300 text-sm mt-2';
            error.textContent = message;
            input.parentNode.appendChild(error);
        }
    </script>
</body>
</html>