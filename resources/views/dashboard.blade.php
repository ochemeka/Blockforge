<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="generator" content="BlockForge BFB">
    <title>{{ config('app.name', 'BlockForge') }} - Dashboard</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E⚡%3C/text%3E%3C/svg%3E">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        // Configure Tailwind dark mode to use class strategy
        tailwind.config = {
            darkMode: 'class'
        }
        
        // CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Dark/Light theme toggle
        function toggleTheme() {
            const html = document.documentElement;
            const body = document.body;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                body.classList.remove('dark');
                body.classList.add('light-body');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                body.classList.add('dark');
                body.classList.remove('light-body');
                localStorage.setItem('theme', 'dark');
            }
        }
        
        // Initialize theme on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            // Check saved theme on load - default to dark mode
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light') {
                document.documentElement.classList.remove('dark');
                document.body.classList.add('light-body');
                document.body.classList.remove('dark');
            } else {
                // Default to dark mode (no action needed - dark class is already on html from server)
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
            }
        });
    </script>
    <style>
        * {
            font-family: 'Space Grotesk', sans-serif;
        }
        
        /* Prevent horizontal scroll */
        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }
        
        /* Dark theme (default) */
        .dark body {
            background: linear-gradient(135deg, #0f0c29 0%, #1a0a2e 50%, #0d0221 100%);
            min-height: 100vh;
        }
        
        /* Light theme */
        body:not(.dark) {
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
        
        .dark .text-primary { color: white; }
        .dark .text-secondary { color: rgba(255, 255, 255, 0.8); }
        .dark .text-muted { color: rgba(255, 255, 255, 0.6); }
        
        body:not(.dark) .text-primary { color: #1a0a2e; }
        body:not(.dark) .text-secondary { color: #3a3a5a; }
        body:not(.dark) .text-muted { color: #5a5a7a; }
        
        .light-body .text-primary { color: #1a0a2e; }
        .light-body .text-secondary { color: #3a3a5a; }
        .light-body .text-muted { color: #5a5a7a; }
        
        /* Card styles */
        .dark .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .light-body .card, body:not(.dark) .card {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        /* Circular progress */
        .circular-progress {
            transform: rotate(-90deg);
        }
        
        /* Mining button pulse */
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(168, 85, 247, 0.4); }
            50% { box-shadow: 0 0 40px rgba(168, 85, 247, 0.6); }
        }
        
        .mine-btn-active {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 50%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Light mode gradient text fix */
        body:not(.dark) .gradient-text {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Text overflow handling */
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        /* Responsive text sizes */
        @media (max-width: 640px) {
            .text-responsive {
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body class="antialiased min-h-screen transition-colors duration-300 overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 top-0 transition-colors duration-300 dark:bg-[#0f0c29]/95 bg-white/95 backdrop-blur-lg border-b dark:border-white/10 border-gray-300">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg purple-glow flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-lg sm:text-xl font-bold dark:text-white text-gray-900 hidden sm:block">Blockforge</span>
                    </a>
                </div>
                
                <!-- Nav Links - Desktop -->
                <div class="hidden lg:flex items-center space-x-6 lg:space-x-8">
                    <a href="/dashboard" class="font-medium text-sm lg:text-base dark:text-purple-400 text-purple-600">Dashboard</a>
                    <a href="/wallet" class="dark:text-gray-300 text-gray-600 hover:dark:text-purple-400 hover:text-purple-600 transition font-medium text-sm lg:text-base">Wallet</a>
                    <a href="/referrals" class="dark:text-gray-300 text-gray-600 hover:dark:text-purple-400 hover:text-purple-600 transition font-medium text-sm lg:text-base">Referrals</a>
                    <a href="/leaderboard" class="dark:text-gray-300 text-gray-600 hover:dark:text-purple-400 hover:text-purple-600 transition font-medium text-sm lg:text-base">Leaderboard</a>
                </div>
                
                <!-- Right Side -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <!-- Mining Balance -->
                    <div class="px-2 sm:px-4 py-1 sm:py-2 rounded-lg dark:bg-white/10 bg-gray-100 hidden sm:block">
                        <span class="text-xs sm:text-sm dark:text-gray-300 text-gray-600">Balance:</span>
                        <span id="miningBalance" class="text-xs sm:text-sm font-bold dark:text-white text-gray-900 ml-1">0.00 BFB</span>
                    </div>
                    
                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()" class="p-2 rounded-lg dark:hover:bg-white/10 hover:bg-gray-200 transition">
                        <!-- Sun icon (shown in dark mode) -->
                        <svg class="w-5 h-5 dark:text-white text-gray-700 dark:block hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <!-- Moon icon (shown in light mode) -->
                        <svg class="w-5 h-5 dark:text-white text-gray-700 dark:hidden block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>
                    
                    <!-- User Menu -->
                    <div class="flex items-center space-x-1 sm:space-x-2">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg purple-glow flex items-center justify-center">
                            <span class="text-white text-xs sm:text-sm font-medium">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-2 sm:px-3 py-1 sm:py-2 rounded-lg dark:text-gray-300 text-gray-600 dark:hover:text-white hover:bg-purple-600 hover:text-white transition text-xs sm:text-sm font-medium">
                                <span class="hidden sm:inline">Logout</span>
                                <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen pt-20 pb-8 px-2 sm:px-4">
        <div class="max-w-7xl mx-auto px-2 sm:px-4">
            <!-- Dashboard Header -->
            <div class="mb-6 md:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold dark:text-white text-gray-900">Welcome back, {{ Auth::user()->name ?? 'Miner' }}!</h1>
                <p class="dark:text-gray-300 text-gray-600 mt-1 text-sm sm:text-base">Start mining BFB tokens and grow your balance</p>
            </div>

            <!-- Mining Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
                <!-- Daily Mining Card -->
                <div class="rounded-2xl p-4 sm:p-6 md:p-8 border dark:border-purple-500/30 border-purple-300 dark:bg-white/5 bg-white">
                    <div class="text-center">
                        <h2 class="text-lg sm:text-xl font-semibold dark:text-white text-gray-900 mb-4 sm:mb-6">DAILY MINING</h2>
                        
                        <!-- Circular Progress with Countdown - Timer INSIDE circle -->
                        <div class="relative w-40 h-40 sm:w-48 sm:h-48 mx-auto mb-6">
                            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="45" fill="none" class="dark:stroke-white/10 stroke-gray-300" stroke-width="8"/>
                                <circle id="progressCircle" cx="50" cy="50" r="45" fill="none" stroke="url(#gradient)" stroke-width="8" stroke-linecap="round" stroke-dasharray="283" stroke-dashoffset="0"/>
                                <defs>
                                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:#7c3aed"/>
                                        <stop offset="100%" style="stop-color:#a855f7"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                            
                            <!-- Timer content centered in circle -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span id="countdownTimer" class="text-xl sm:text-2xl font-bold dark:text-white text-gray-900 tabular-nums">24:00:00</span>
                                <span class="text-xs dark:text-gray-400 text-gray-500 mt-1">until next mine</span>
                            </div>
                        </div>
                        
                        <!-- Mining Reward -->
                        <div class="mb-6">
                            <span class="text-3xl sm:text-4xl font-bold gradient-text">2400</span>
                            <span class="text-sm sm:text-lg dark:text-gray-300 text-gray-600 ml-1">BFB</span>
                            <p class="text-xs sm:text-sm dark:text-gray-300 text-gray-600 mt-1">per 24 hours</p>
                        </div>
                        
                        <!-- Mine Button -->
                        <button id="mineBtn" onclick="mineNow()" class="w-full py-3 sm:py-4 rounded-xl purple-glow text-white font-bold text-sm sm:text-lg purple-glow-hover transition mine-btn-active">
                            MINE NOW
                        </button>
                        
                        <!-- Status Message -->
                        <p id="miningStatus" class="mt-4 text-sm dark:text-gray-300 text-gray-600 hidden"></p>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="space-y-4 sm:space-y-6">
                    <!-- Total Balance -->
                    <div class="rounded-2xl p-4 sm:p-6 border dark:border-purple-500/30 border-purple-300 dark:bg-white/5 bg-white min-h-[100px]">
                        <div class="flex items-center justify-between">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs sm:text-sm dark:text-gray-300 text-gray-600 mb-1 truncate">Total Mining Balance</p>
                                <p id="totalBalance" class="text-2xl sm:text-3xl font-bold dark:text-white text-gray-900 truncate">0.00 <span class="text-sm sm:text-lg">BFB</span></p>
                            </div>
                            <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-lg purple-glow flex items-center justify-center flex-shrink-0 ml-2">
                                <svg class="w-5 h-5 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Mined -->
                    <div class="rounded-2xl p-4 sm:p-6 border dark:border-purple-500/30 border-purple-300 dark:bg-white/5 bg-white">
                        <div class="flex items-center justify-between">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs sm:text-sm dark:text-gray-300 text-gray-600 mb-1 truncate">Total Mined All Time</p>
                                <p id="totalMined" class="text-2xl sm:text-3xl font-bold dark:text-white text-gray-900 truncate">0.00 <span class="text-sm sm:text-lg">BFB</span></p>
                            </div>
                            <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0 ml-2">
                                <svg class="w-5 h-5 sm:w-7 sm:h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Last Mined -->
                    <div class="rounded-2xl p-4 sm:p-6 border dark:border-purple-500/30 border-purple-300 dark:bg-white/5 bg-white">
                        <div class="flex items-center justify-between">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs sm:text-sm dark:text-gray-300 text-gray-600 mb-1">Last Mined</p>
                                <p id="lastMined" class="text-sm sm:text-lg font-semibold dark:text-white text-gray-900 truncate">Never</p>
                            </div>
                            <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-lg bg-blue-500/20 flex items-center justify-center flex-shrink-0 ml-2">
                                <svg class="w-5 h-5 sm:w-7 sm:h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <a href="#" class="rounded-xl p-4 sm:p-6 border dark:border-purple-500/20 border-purple-300 dark:hover:border-purple-500/50 hover:border-purple-500 dark:bg-white/5 bg-white transition">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg purple-glow flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-semibold dark:text-white text-gray-900 text-sm sm:text-base truncate">Wallet</h3>
                            <p class="text-xs sm:text-sm dark:text-gray-400 text-gray-600 truncate">Manage your BFB</p>
                        </div>
                    </div>
                </a>

                <a href="#" class="rounded-xl p-4 sm:p-6 border dark:border-purple-500/20 border-purple-300 dark:hover:border-purple-500/50 hover:border-purple-500 dark:bg-white/5 bg-white transition">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg purple-glow flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-semibold dark:text-white text-gray-900 text-sm sm:text-base truncate">Referrals</h3>
                            <p class="text-xs sm:text-sm dark:text-gray-400 text-gray-600 truncate">Invite friends & earn</p>
                        </div>
                    </div>
                </a>

                <a href="#" class="rounded-xl p-4 sm:p-6 border dark:border-purple-500/20 border-purple-300 dark:hover:border-purple-500/50 hover:border-purple-500 dark:bg-white/5 bg-white transition">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg purple-glow flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-semibold dark:text-white text-gray-900 text-sm sm:text-base truncate">Leaderboard</h3>
                            <p class="text-xs sm:text-sm dark:text-gray-400 text-gray-600 truncate">Top miners</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Mining state
        let miningData = {
            mining_balance: 0,
            total_mined: 0,
            can_mine: false,
            countdown: 0,
            last_mined_at: null,
            next_mining_available_at: null,
            mining_reward: 2400
        };

        let countdownInterval = null;

        // Fetch mining status on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetchMiningStatus();
        });

        async function fetchMiningStatus() {
            try {
                const response = await fetch('/mining/status', {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                    miningData = data;
                    updateMiningUI();
                }
            } catch (error) {
                console.error('Error fetching mining status:', error);
            }
        }

        function updateMiningUI() {
            // Update balance displays
            document.getElementById('miningBalance').textContent = miningData.mining_balance.toFixed(2) + ' BFB';
            document.getElementById('totalBalance').textContent = miningData.mining_balance.toFixed(2) + ' BFB';
            document.getElementById('totalMined').textContent = miningData.total_mined.toFixed(2) + ' BFB';
            
            // Update last mined
            if (miningData.last_mined_at) {
                const lastMined = new Date(miningData.last_mined_at);
                document.getElementById('lastMined').textContent = lastMined.toLocaleString();
            }
            
            // Update mine button state
            const mineBtn = document.getElementById('mineBtn');
            if (miningData.can_mine) {
                mineBtn.disabled = false;
                mineBtn.classList.add('mine-btn-active');
                mineBtn.textContent = 'MINE NOW';
                document.getElementById('countdownTimer').textContent = 'Ready!';
            } else {
                mineBtn.disabled = true;
                mineBtn.classList.remove('mine-btn-active');
                mineBtn.textContent = 'MINING...';
            }
            
            // Start countdown if not ready
            if (!miningData.can_mine && miningData.countdown > 0) {
                startCountdown(miningData.countdown);
            }
        }

        function startCountdown(seconds) {
            seconds = Math.floor(seconds);
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
            
            countdownInterval = setInterval(() => {
                if (seconds <= 0) {
                    clearInterval(countdownInterval);
                    fetchMiningStatus();
                    return;
                }
                
                const hours = Math.floor(seconds / 3600);
                const minutes = Math.floor((seconds % 3600) / 60);
                const secs = seconds % 60;
                
                document.getElementById('countdownTimer').textContent = 
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                
                // Update progress circle
                const totalSeconds = 24 * 60 * 60; // 24 hours
                const progress = (seconds / totalSeconds) * 283;
                document.getElementById('progressCircle').style.strokeDashoffset = 283 - progress;
                
                seconds--;
                miningData.countdown = seconds;
            }, 1000);
        }

        async function mineNow() {
            const mineBtn = document.getElementById('mineBtn');
            const statusEl = document.getElementById('miningStatus');
            
            mineBtn.disabled = true;
            mineBtn.textContent = 'MINING...';
            statusEl.classList.remove('hidden');
            statusEl.textContent = 'Processing your mining reward...';
            statusEl.classList.remove('text-red-400');
            statusEl.classList.add('text-purple-400');
            
            try {
                const response = await fetch('/mining/mine', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                    statusEl.textContent = data.message;
                    statusEl.classList.remove('text-purple-400');
                    statusEl.classList.add('text-green-400');
                    
                    miningData = data;
                    updateMiningUI();
                    
                    // Start countdown
                    if (data.countdown > 0) {
                        startCountdown(data.countdown);
                    }
                } else {
                    statusEl.textContent = data.message;
                    statusEl.classList.remove('text-purple-400');
                    statusEl.classList.add('text-red-400');
                    mineBtn.disabled = false;
                    mineBtn.textContent = 'MINE NOW';
                }
            } catch (error) {
                console.error('Error mining:', error);
                statusEl.textContent = 'An error occurred. Please try again.';
                statusEl.classList.remove('text-purple-400');
                statusEl.classList.add('text-red-400');
                mineBtn.disabled = false;
                mineBtn.textContent = 'MINE NOW';
            }
        }
    </script>
</body>
</html>
