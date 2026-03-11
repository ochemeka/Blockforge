<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BlockForge') }} - Leaderboard</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E⚡%3C/text%3E%3C/svg%3E">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { darkMode: 'class' }
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
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
        
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light') {
                document.documentElement.classList.remove('dark');
                document.body.classList.add('light-body');
                document.body.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
            }
        });
    </script>
    <style>
        * { font-family: 'Space Grotesk', sans-serif; }
        html, body { max-width: 100%; overflow-x: hidden; }
        .dark body { background: linear-gradient(135deg, #0f0c29 0%, #1a0a2e 50%, #0d0221 100%); min-height: 100vh; }
        body:not(.dark) { background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 50%, #dde1ec 100%); min-height: 100vh; }
        .purple-glow { background: linear-gradient(135deg, #7c3aed 0%, #a855f7 50%, #c084fc 100%); }
        .gold-glow { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%); }
        .silver-glow { background: linear-gradient(135deg, #9ca3af 0%, #6b7280 50%, #4b5563 100%); }
        .bronze-glow { background: linear-gradient(135deg, #cd7f32 0%, #b8860b 50%, #8b6914 100%); }
    </style>
</head>
<body class="antialiased min-h-screen transition-colors duration-300 overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 top-0 transition-colors duration-300 dark:bg-[#0f0c29]/95 bg-white/95 backdrop-blur-lg border-b dark:border-white/10 border-gray-300">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <div class="flex items-center">
                    <a href="/dashboard" class="flex items-center space-x-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg purple-glow flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-lg sm:text-xl font-bold dark:text-white text-gray-900 hidden sm:block">Blockforge</span>
                    </a>
                </div>
                <div class="hidden lg:flex items-center space-x-6 lg:space-x-8">
                    <a href="/dashboard" class="dark:text-gray-300 text-gray-600 hover:dark:text-purple-400 hover:text-purple-600 transition font-medium text-sm lg:text-base">Dashboard</a>
                    <a href="/wallet" class="dark:text-gray-300 text-gray-600 hover:dark:text-purple-400 hover:text-purple-600 transition font-medium text-sm lg:text-base">Wallet</a>
                    <a href="/referrals" class="dark:text-gray-300 text-gray-600 hover:dark:text-purple-400 hover:text-purple-600 transition font-medium text-sm lg:text-base">Referrals</a>
                    <a href="/leaderboard" class="dark:text-purple-400 text-purple-600 font-medium text-sm lg:text-base">Leaderboard</a>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <div class="px-2 sm:px-4 py-1 sm:py-2 rounded-lg dark:bg-white/10 bg-gray-100 hidden sm:block">
                        <span class="text-xs sm:text-sm dark:text-gray-300 text-gray-600">Balance:</span>
                        <span id="miningBalance" class="text-xs sm:text-sm font-bold dark:text-white text-gray-900 ml-1">0.00 BFB</span>
                    </div>
                    <button onclick="toggleTheme()" class="p-2 rounded-lg dark:hover:bg-white/10 hover:bg-gray-200 transition">
                        <svg class="w-5 h-5 dark:text-white text-gray-700 dark:block hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg class="w-5 h-5 dark:text-white text-gray-700 dark:hidden block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>
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
            <!-- Header -->
            <div class="mb-6 md:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold dark:text-white text-gray-900">Leaderboard</h1>
                <p class="dark:text-gray-300 text-gray-600 mt-1 text-sm sm:text-base">Top miners ranking by total BFB mined</p>
            </div>

            <!-- Your Rank Card -->
            <div class="rounded-2xl p-6 sm:p-8 border dark:border-purple-500/30 border-purple-300 dark:bg-white/5 bg-white mb-6">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <p class="text-sm dark:text-gray-400 text-gray-600 mb-1">Your Current Rank</p>
                        <p id="userRank" class="text-3xl sm:text-4xl font-bold dark:text-white text-gray-900">#-</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm dark:text-gray-400 text-gray-600 mb-1">Your Total Mined</p>
                        <p id="userTotalMined" class="text-2xl sm:text-3xl font-bold purple-glow bg-clip-text text-transparent">0.00 BFB</p>
                    </div>
                </div>
            </div>

            <!-- Top 3 Podium -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- 2nd Place -->
                <div class="order-2 md:order-1">
                    <div class="rounded-t-2xl p-4 sm:p-6 border dark:border-gray-600 border-gray-300 dark:bg-white/5 bg-white text-center">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-3 rounded-full silver-glow flex items-center justify-center">
                            <span class="text-2xl sm:text-3xl font-bold text-white">2</span>
                        </div>
                        <p id="secondName" class="font-semibold dark:text-white text-gray-900 mb-1">-</p>
                        <p id="secondMined" class="text-lg font-bold text-gray-400">0.00 BFB</p>
                    </div>
                    <div class="h-8 sm:h-12 bg-gradient-to-t from-gray-300 to-transparent dark:hidden"></div>
                    <div class="h-8 sm:h-12 bg-gradient-to-t from-gray-700 to-transparent hidden dark:block"></div>
                </div>
                
                <!-- 1st Place -->
                <div class="order-1 md:order-2">
                    <div class="rounded-t-2xl p-4 sm:p-6 border dark:border-yellow-500 border-yellow-400 dark:bg-white/5 bg-white text-center relative">
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                            <span class="text-2xl">👑</span>
                        </div>
                        <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-3 rounded-full gold-glow flex items-center justify-center">
                            <span class="text-3xl sm:text-4xl font-bold text-white">1</span>
                        </div>
                        <p id="firstName" class="font-semibold dark:text-white text-gray-900 mb-1">-</p>
                        <p id="firstMined" class="text-xl sm:text-2xl font-bold text-yellow-500">0.00 BFB</p>
                    </div>
                    <div class="h-12 sm:h-16 bg-gradient-to-t from-yellow-400/30 to-transparent dark:from-yellow-500/20"></div>
                </div>
                
                <!-- 3rd Place -->
                <div class="order-3">
                    <div class="rounded-t-2xl p-4 sm:p-6 border dark:border-amber-700 border-amber-600 dark:bg-white/5 bg-white text-center">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-3 rounded-full bronze-glow flex items-center justify-center">
                            <span class="text-2xl sm:text-3xl font-bold text-white">3</span>
                        </div>
                        <p id="thirdName" class="font-semibold dark:text-white text-gray-900 mb-1">-</p>
                        <p id="thirdMined" class="text-lg font-bold text-amber-600 dark:text-amber-500">0.00 BFB</p>
                    </div>
                    <div class="h-8 sm:h-12 bg-gradient-to-t from-amber-600/30 to-transparent dark:from-amber-700/20"></div>
                </div>
            </div>

            <!-- Full Leaderboard Table -->
            <div class="rounded-2xl p-4 sm:p-6 border dark:border-purple-500/30 border-purple-300 dark:bg-white/5 bg-white">
                <h2 class="text-lg sm:text-xl font-semibold dark:text-white text-gray-900 mb-4">Top Miners</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b dark:border-white/10 border-gray-200">
                                <th class="text-left py-3 px-2 text-xs sm:text-sm dark:text-gray-400 text-gray-600">Rank</th>
                                <th class="text-left py-3 px-2 text-xs sm:text-sm dark:text-gray-400 text-gray-600">Miner</th>
                                <th class="text-right py-3 px-2 text-xs sm:text-sm dark:text-gray-400 text-gray-600">Total Mined</th>
                            </tr>
                        </thead>
                        <tbody id="leaderboardList">
                            <tr>
                                <td colspan="3" class="py-8 text-center dark:text-gray-400 text-gray-500">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        let leaderboardData = {
            top_miners: [],
            user_rank: 0,
            user_total_mined: 0
        };

        document.addEventListener('DOMContentLoaded', function() {
            fetchLeaderboardData();
        });

        async function fetchLeaderboardData() {
            try {
                const response = await fetch('/leaderboard/data', {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                    leaderboardData = data;
                    updateLeaderboardUI();
                }
            } catch (error) {
                console.error('Error fetching leaderboard data:', error);
            }
        }

        function updateLeaderboardUI() {
            document.getElementById('userRank').textContent = '#' + leaderboardData.user_rank;
            document.getElementById('userTotalMined').textContent = leaderboardData.user_total_mined.toFixed(2) + ' BFB';
            
            // Update podium
            if (leaderboardData.top_miners.length > 0) {
                document.getElementById('firstName').textContent = leaderboardData.top_miners[0].name;
                document.getElementById('firstMined').textContent = leaderboardData.top_miners[0].total_mined.toFixed(2) + ' BFB';
            }
            if (leaderboardData.top_miners.length > 1) {
                document.getElementById('secondName').textContent = leaderboardData.top_miners[1].name;
                document.getElementById('secondMined').textContent = leaderboardData.top_miners[1].total_mined.toFixed(2) + ' BFB';
            }
            if (leaderboardData.top_miners.length > 2) {
                document.getElementById('thirdName').textContent = leaderboardData.top_miners[2].name;
                document.getElementById('thirdMined').textContent = leaderboardData.top_miners[2].total_mined.toFixed(2) + ' BFB';
            }
            
            // Update table
            const tbody = document.getElementById('leaderboardList');
            if (leaderboardData.top_miners.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="py-8 text-center dark:text-gray-400 text-gray-500">No miners yet. Start mining to appear on the leaderboard!</td></tr>';
            } else {
                tbody.innerHTML = leaderboardData.top_miners.map(miner => `
                    <tr class="border-b dark:border-white/5 border-gray-100">
                        <td class="py-3 px-2">
                            <span class="font-bold ${miner.rank <= 3 ? 'text-purple-400' : 'dark:text-gray-300 text-gray-600'}">#${miner.rank}</span>
                        </td>
                        <td class="py-3 px-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full purple-glow flex items-center justify-center">
                                    <span class="text-white text-xs font-medium">${miner.name.charAt(0).toUpperCase()}</span>
                                </div>
                                <span class="dark:text-white text-gray-900 font-medium">${miner.name}</span>
                            </div>
                        </td>
                        <td class="py-3 px-2 text-right dark:text-white text-gray-900 font-medium">${miner.total_mined.toFixed(2)} BFB</td>
                    </tr>
                `).join('');
            }
        }
    </script>
</body>
</html>
