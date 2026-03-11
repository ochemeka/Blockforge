<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="generator" content="BlockForge BFB">
    <title>BlockForge - Forging the Future</title>
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
    </script>
    <style>
        * {
            font-family: 'Space Grotesk', sans-serif;
        }
        
        /* Dark theme (default) */
        .dark body {
            background: linear-gradient(135deg, #0f0c29 0%, #1a0a2e 50%, #0d0221 100%);
        }
        
        /* Light theme */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 50%, #dde1ec 100%);
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
        }
        
        .light-body .input-field {
            background: rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.1);
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
            backdrop-filter: blur(20px);
        }
        
        .light-body nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        /* Text colors */
        .dark .text-primary { color: white; }
        .dark .text-secondary { color: rgba(255, 255, 255, 0.7); }
        .dark .text-muted { color: rgba(255, 255, 255, 0.5); }
        
        .light-body .text-primary { color: #1a1a2e; }
        .light-body .text-secondary { color: #4a4a6a; }
        .light-body .text-muted { color: #6a6a8a; }
        
        /* Progress bar */
        .progress-65 {
            width: 65%;
        }
    </style>
</head>
<body class="antialiased min-h-screen transition-colors duration-300" id="main-body">
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
                    
                    <!-- Auth Buttons -->
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

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-20">
        <!-- Background Effects -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/3 left-1/4 w-[500px] h-[500px] bg-purple-600/20 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-1/3 right-1/4 w-[400px] h-[400px] bg-fuchsia-600/15 rounded-full blur-[100px]"></div>
        </div>
        
        <div class="relative max-w-4xl mx-auto px-4 text-center">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 rounded-full card mb-6">
                <span class="w-2 h-2 rounded-full bg-green-400 mr-2 animate-pulse"></span>
                <span class="text-secondary text-sm">Mining Phase 1 is Live</span>
            </div>
            
            <!-- Headline -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-primary mb-4 leading-tight">
                The Future of<br>
                <span class="gradient-text">Decentralized Mining</span>
            </h1>
            
            <h2 class="text-xl md:text-2xl font-semibold text-primary mb-2">Blockforge - Forging the Future</h2>
            
            <!-- Subtitle -->
            <p class="text-lg text-secondary mb-8 max-w-2xl mx-auto">
                Blockforge (BFB) powers real-world ecosystems from finance to agriculture. Start mining today and secure your stake in the future.
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
                <a href="/register" class="w-full sm:w-auto px-8 py-4 rounded-xl purple-glow text-white font-semibold text-lg purple-glow-hover transition transform hover:scale-105">
                    Start Mining Free
                </a>
                <a href="#" class="w-full sm:w-auto px-8 py-4 rounded-xl border border-purple-500 text-purple-500 hover:bg-purple-500/10 transition font-semibold text-lg">
                    Buy BFB Token
                </a>
            </div>
            
            <!-- Price Info -->
            <div class="flex flex-wrap justify-center gap-8 mb-8">
                <div class="card rounded-xl px-6 py-4">
                    <div class="text-sm text-muted mb-1">Current Price</div>
                    <div class="text-2xl font-bold text-primary">$0.0125 / BFB</div>
                </div>
                <div class="card rounded-xl px-6 py-4">
                    <div class="text-sm text-muted mb-1">NGN Rate</div>
                    <div class="text-2xl font-bold text-primary">₦20.00</div>
                </div>
            </div>
            
            <!-- Phase Progress -->
            <div class="card rounded-xl px-6 py-4 max-w-md mx-auto">
                <div class="flex justify-between mb-2">
                    <span class="text-secondary font-medium">Phase 1 Allocation</span>
                    <span class="text-primary font-semibold">65% Sold</span>
                </div>
                <div class="h-3 rounded-full bg-gray-700 overflow-hidden">
                    <div class="h-full progress-65 purple-glow rounded-full"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Advertisement Section -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="card rounded-xl py-12 text-center">
                <h3 class="text-xl font-semibold text-primary">Advertisement Space</h3>
                <p class="text-secondary mt-2">Promote your project here</p>
            </div>
        </div>
    </section>

    <!-- Real World Utility Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-primary mb-4">
                Real World Utility
            </h2>
            <p class="text-center text-secondary mb-12 max-w-2xl mx-auto">
                BFB isn't just another token. It's the currency fueling a diverse ecosystem of practical applications.
            </p>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Global Payments -->
                <div class="card rounded-xl p-6 hover:border-purple-500/30 transition">
                    <div class="w-12 h-12 rounded-lg purple-glow flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-primary mb-2">Global Payments</h3>
                    <p class="text-sm text-secondary">Seamless cross-border transactions with minimal fees and instant settlement.</p>
                </div>
                
                <!-- Transportation -->
                <div class="card rounded-xl p-6 hover:border-purple-500/30 transition">
                    <div class="w-12 h-12 rounded-lg purple-glow flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0                             <path stroke24 24">
-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-primary mb-2">Transportation</h3>
                    <p class="text-sm text-secondary">Decentralized fare systems for ride-hailing and logistics platforms.</p>
                </div>
                
                <!-- AgroWorld -->
                <div class="card rounded-xl p-6 hover:border-purple-500/30 transition">
                    <div class="w-12 h-12 rounded-lg purple-glow flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-primary mb-2">AgroWorld</h3>
                    <p class="text-sm text-secondary">Smart financing and supply chain tracking for the agricultural sector.</p>
                </div>
                
                <!-- Hospitality -->
                <div class="card rounded-xl p-6 hover:border-purple-500/30 transition">
                    <div class="w-12 h-12 rounded-lg purple-glow flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-primary mb-2">Hospitality</h3>
                    <p class="text-sm text-secondary">Booking hotels and properties with exclusive crypto discounts.</p>
                </div>
                
                <!-- Oil & Gas -->
                <div class="card rounded-xl p-6 hover:border-purple-500/30 transition">
                    <div class="w-12 h-12 rounded-lg purple-glow flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-primary mb-2">Oil & Gas</h3>
                    <p class="text-sm text-secondary">Transparent royalty payments and commodity trading on-chain.</p>
                </div>
                
                <!-- DeFi Lending -->
                <div class="card rounded-xl p-6 hover:border-purple-500/30 transition">
                    <div class="w-12 h-12 rounded-lg purple-glow flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-primary mb-2">DeFi Lending</h3>
                    <p class="text-sm text-secondary">Borrow against assets or lend to earn competitive yields.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Whitepaper Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="card rounded-2xl p-8 md:p-12 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">
                    Read Our Whitepaper
                </h2>
                <p class="text-secondary mb-8 max-w-2xl mx-auto">
                    Dive deep into the technical architecture, tokenomics, and roadmap of the Blockforge ecosystem.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="#" class="px-8 py-3 rounded-xl purple-glow text-white font-semibold purple-glow-hover transition">
                        Read Online
                    </a>
                    <a href="#" class="px-8 py-3 rounded-xl border border-purple-500 text-purple-500 hover:bg-purple-500/10 transition font-semibold">
                        Download PDF
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 border-t border-gray-200 dark:border-white/10">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-lg purple-glow flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-primary">Blockforge</span>
                </div>
                
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-sm text-secondary hover:text-purple-500">Support</a>
                    <a href="#" class="text-sm text-secondary hover:text-purple-500">Privacy Policy</a>
                    <a href="#" class="text-sm text-secondary hover:text-purple-500">Terms of Service</a>
                </div>
                
                <div class="text-sm text-muted">
                    © 2024 Blockforge. All rights reserved.
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
