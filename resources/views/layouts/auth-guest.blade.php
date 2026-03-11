<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="generator" content="BlockForge BFB">
    <title>{{ config('app.name', 'BlockForge') }}</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E⚡%3C/text%3E%3C/svg%3E">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        // Dark/Light theme toggle
        function toggleTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
        
        // Check saved theme on load
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
        
        // Password toggle
        function togglePassword(fieldId, toggleId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(toggleId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                passwordInput.type = 'password';
                toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }
    </script>
    <style>
        * {
            font-family: 'Space Grotesk', sans-serif;
        }
        
        /* Dark theme (default) */
        .dark body {
            background: linear-gradient(135deg, #0f0c29 0%, #1a0a2e 50%, #0d0221 100%);
            min-height: 100vh;
        }
        
        /* Light theme */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 50%, #dde1ec 100%);
            min-height: 100vh;
        }
        
        .light-body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 50%, #dde1ec 100%);
        }
        
        .purple-glow {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 50%, #c084fc 100%);
        }
        
        .purple-glow-hover:hover {
            box-shadow: 0 0 30px rgba(168, 85, 247, 0.4);
        }
        
        .input-dark, .dark .input-field {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .light-body .input-field {
            background: rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #1a0a2e;
        }
        
        .dark .input-field::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .light-body .input-field::placeholder {
            color: rgba(0, 0, 0, 0.5);
        }
        
        /* Select dropdown styling for light mode */
        .light-body .input-field option {
            background: white;
            color: #1a0a2e;
        }
        
        .input-dark:focus, .dark .input-field:focus {
            border-color: #a855f7;
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.2);
            outline: none;
        }
        
        .light-body .input-field:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.2);
            outline: none;
        }
        
        .light-body .gradient-text {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #c084fc 0%, #a855f7 50%, #7c3aed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .light-body .gradient-text {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Card styles */
        .dark .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .light-body .card {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        /* Nav styles */
        .dark nav {
            background: rgba(15, 12, 41, 0.95);
        }
        
        .light-body nav {
            background: rgba(255, 255, 255, 0.95);
        }
        
        .dark .text-primary {
            color: white;
        }
        
        .light-body .text-primary {
            color: #1a0a2e;
        }
        
        .dark .text-secondary {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .light-body .text-secondary {
            color: rgba(0, 0, 0, 0.7);
        }
        
        .dark .text-muted {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .light-body .text-muted {
            color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 top-0 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-lg purple-glow flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-primary">Blockforge</span>
                    </a>
                </div>
                
                <!-- Nav Links - Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-secondary hover:text-purple-500 transition font-medium">Wallet</a>
                    <a href="#" class="text-secondary hover:text-purple-500 transition font-medium">Referrals</a>
                    <a href="#" class="text-secondary hover:text-purple-500 transition font-medium">Leaderboard</a>
                    <a href="#" class="text-secondary hover:text-purple-500 transition font-medium">Promo</a>
                </div>
                
                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()" class="p-2 rounded-lg hover:bg-white/10 transition">
                        <!-- Sun icon (show in dark mode) -->
                        <svg class="w-5 h-5 text-primary dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <!-- Moon icon (show in light mode) -->
                        <svg class="w-5 h-5 text-primary hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>
                    
                    <!-- Auth Buttons - Change based on login status -->
                    @auth
                        <a href="/dashboard" class="px-4 py-2 rounded-lg purple-glow text-white font-medium purple-glow-hover transition">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-lg text-secondary hover:text-white hover:bg-purple-600 transition font-medium">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="/login" class="px-4 py-2 rounded-lg text-secondary hover:text-white hover:bg-purple-600 transition font-medium">Login</a>
                        <a href="/register" class="px-4 py-2 rounded-lg purple-glow text-white font-medium purple-glow-hover transition">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center pt-20">
        {{ $slot }}
    </div>
</body>
</html>
