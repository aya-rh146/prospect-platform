<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') - Business Pro Academy</title>
    
    <!-- Tailwind CSS CDN (comme les pages publiques) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e3a8a',
                            900: '#1e40af',
                        },
                        slate: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    spacing: {
                        '18': '4.5rem',
                        '88': '22rem',
                    },
                    borderRadius: {
                        '4xl': '2rem',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                    },
                },
            },
        }
    </script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS pour l'admin -->
    <style>
        .admin-test {
          background-color: rgb(239 68 68);
          color: white;
          padding: 5rem;
          font-size: 3rem;
          font-weight: bold;
          border-radius: 1rem;
          box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
          text-align: center;
          margin: 2rem;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans antialiased flex flex-col min-h-screen">
    <!-- Navigation Admin -->
    @include('layouts.navigation')

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 flex-grow">
        @yield('content')
    </main>

    <!-- Footer Admin -->
    <footer class="bg-gray-800 dark:bg-gray-950 text-white mt-auto">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-300">&copy; {{ date('Y') }} Business Pro Academy. Panel d'administration.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.prospects.index') }}" class="text-gray-300 hover:text-white transition">
                        Prospects
                    </a>
                    <a href="{{ route('admin.videos.index') }}" class="text-gray-300 hover:text-white transition">
                        Vidéos
                    </a>
                    <a href="{{ route('admin.settings') }}" class="text-gray-300 hover:text-white transition">
                        Paramètres
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Flash Messages avec SweetAlert2 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Success messages
            @if(session()->has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: '{{ session('success') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#10b981',
                    color: '#ffffff'
                });
            @endif

            // Error messages
            @if(session()->has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: '{{ session('error') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    background: '#ef4444',
                    color: '#ffffff'
                });
            @endif

            // Info messages (pour autres types de notifications)
            @if(session()->has('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Information',
                    text: '{{ session('info') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#3b82f6',
                    color: '#ffffff'
                });
            @endif
        });
    </script>
</body>
</html>
