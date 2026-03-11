<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BlockForge') }} - Wallet</title>
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
        .purple-glow-hover:hover { box-shadow: 0 0 30px rgba(168, 85, 247, 0.4); }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 20px rgba(168, 85, 247, 0.4); } 50% { box-shadow: 0 0 40px rgba(168, 85, 247, 0.6); } }
        .mine-btn-active { animation: pulse-glow 2s ease-in-out infinite; }
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
                    <a href="/wallet" class="dark:text-purple-400 text-purple-600 font-medium text-sm lg:text-base">Wallet</a>
                    <a href="/referrals" class="dark:text-gray-300 text-gray-600 hover:dark:text-purple-400 hover:text-purple-600 transition font-medium text-sm lg:text-base">Referrals</a>
                    <a href="/leaderboard" class="dark:text-gray-300 text-gray-600 hover:dark:text-purple-400 hover:text-purple-600 transition font-medium text-sm lg:text-base">Leaderboard</a>
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
                <h1 class="text-2xl sm:text-3xl font-bold dark:text-white text-gray-900">Wallet</h1>
                <p class="dark:text-gray-300 text-gray-600 mt-1 text-sm sm:text-base">Manage your BFB tokens</p>
            </div>

            <!-- Balance Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
                <div class="rounded-2xl p-4 sm:p-6 border dark:border-purple-500/30 border-purple-300 dark:bg-white/5 bg-white">
                    <p class="text-xs sm:text-sm dark:text-gray-300 text-gray-600 mb-1">Available Balance</p>
                    <p id="balance" class="text-2xl sm:text-3xl font-bold dark:text-white text-gray-900">0.00 <span class="text-lg">BFB</span></p>
                </div>
                <div class="rounded-2xl p-4 sm:p-6 border dark:border-purple-500/30 border-purple-300 dark:bg-white/5 bg-white">
                    <p class="text-xs sm:text-sm dark:text-gray-300 text-gray-600 mb-1">Total Mined</p>
                    <p id="totalMined" class="text-2xl sm:text-3xl font-bold dark:text-white text-gray-900">0.00 <span class="text-lg">BFB</span></p>
                </div>
                <div class="rounded-2xl p-4 sm:p-6 border dark:border-purple-500/30 border-purple-300 dark:bg-white/5 bg-white">
                    <p class="text-xs sm:text-sm dark:text-gray-300 text-gray-600 mb-1">Transactions</p>
                    <p id="txCount" class="text-2xl sm:text-3xl font-bold dark:text-white text-gray-900">0</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                <button onclick="showDepositModal()" class="p-4 sm:p-6 rounded-xl border dark:border-purple-500/30 border-purple-300 dark:bg-white/5 bg-white hover:dark:border-purple-500 hover:border-purple-500 transition text-left">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-lg purple-glow flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold dark:text-white text-gray-900">Deposit</h3>
                            <p class="text-xs sm:text-sm dark:text-gray-400 text-gray-600">Add BFB to wallet</p>
                        </div>
                    </div>
                </button>
                <button onclick="showWithdrawModal()" class="p-4 sm:p-6 rounded-xl border dark:border-purple-500/30 border-purple-300 dark:bg-white/5 bg-white hover:dark:border-purple-500 hover:border-purple-500 transition text-left">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-lg bg-green-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold dark:text-white text-gray-900">Withdraw</h3>
                            <p class="text-xs sm:text-sm dark:text-gray-400 text-gray-600">Transfer BFB out</p>
                        </div>
                    </div>
                </button>
                <button onclick="showTransferModal()" class="p-4 sm:p-6 rounded-xl border dark:border-purple-500/30 border-purple-300 dark:bg-white/5 bg-white hover:dark:border-purple-500 hover:border-purple-500 transition text-left">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-lg bg-blue-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold dark:text-white text-gray-900">Transfer</h3>
                            <p class="text-xs sm:text-sm dark:text-gray-400 text-gray-600">Send to another user</p>
                        </div>
                    </div>
                </button>
            </div>

            <!-- Transaction History -->
            <div class="rounded-2xl p-4 sm:p-6 border dark:border-purple-500/30 border-purple-300 dark:bg-white/5 bg-white">
                <h2 class="text-lg sm:text-xl font-semibold dark:text-white text-gray-900 mb-4">Transaction History</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b dark:border-white/10 border-gray-200">
                                <th class="text-left py-3 px-2 text-xs sm:text-sm dark:text-gray-400 text-gray-600">Type</th>
                                <th class="text-left py-3 px-2 text-xs sm:text-sm dark:text-gray-400 text-gray-600">Amount</th>
                                <th class="text-left py-3 px-2 text-xs sm:text-sm dark:text-gray-400 text-gray-600">Description</th>
                                <th class="text-left py-3 px-2 text-xs sm:text-sm dark:text-gray-400 text-gray-600">Date</th>
                            </tr>
                        </thead>
                        <tbody id="transactionsList">
                            <tr>
                                <td colspan="4" class="py-8 text-center dark:text-gray-400 text-gray-500">No transactions yet</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        let walletData = {
            balance: 0,
            totalMined: 0,
            transactions: []
        };

        document.addEventListener('DOMContentLoaded', function() {
            fetchWalletData();
        });

        async function fetchWalletData() {
            try {
                const response = await fetch('/wallet/data', {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                    walletData = data;
                    updateWalletUI();
                }
            } catch (error) {
                console.error('Error fetching wallet data:', error);
            }
        }

        function updateWalletUI() {
            document.getElementById('balance').innerHTML = walletData.balance.toFixed(2) + ' <span class="text-lg">BFB</span>';
            document.getElementById('miningBalance').textContent = walletData.balance.toFixed(2) + ' BFB';
            document.getElementById('totalMined').innerHTML = walletData.totalMined.toFixed(2) + ' <span class="text-lg">BFB</span>';
            document.getElementById('txCount').textContent = walletData.transactions.length;
            
            const tbody = document.getElementById('transactionsList');
            if (walletData.transactions.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="py-8 text-center dark:text-gray-400 text-gray-500">No transactions yet</td></tr>';
            } else {
                tbody.innerHTML = walletData.transactions.map(tx => `
                    <tr class="border-b dark:border-white/5 border-gray-100">
                        <td class="py-3 px-2">
                            <span class="px-2 py-1 rounded-full text-xs font-medium ${getTypeClass(tx.type)}">${tx.type}</span>
                        </td>
                        <td class="py-3 px-2 dark:text-white text-gray-900 font-medium">${tx.amount.toFixed(2)} BFB</td>
                        <td class="py-3 px-2 dark:text-gray-300 text-gray-600 text-sm">${tx.description || '-'}</td>
                        <td class="py-3 px-2 dark:text-gray-400 text-gray-500 text-sm">${new Date(tx.created_at).toLocaleString()}</td>
                    </tr>
                `).join('');
            }
        }

        function getTypeClass(type) {
            const classes = {
                'mining_reward': 'bg-purple-500/20 text-purple-400',
                'referral_bonus': 'bg-blue-500/20 text-blue-400',
                'deposit': 'bg-green-500/20 text-green-400',
                'withdrawal': 'bg-red-500/20 text-red-400',
                'transfer': 'bg-yellow-500/20 text-yellow-400'
            };
            return classes[type] || 'bg-gray-500/20 text-gray-400';
        }

        function showDepositModal() {
            alert('Deposit functionality coming soon!');
        }

        function showWithdrawModal() {
            alert('Withdraw functionality coming soon!');
        }

        function showTransferModal() {
            alert('Transfer functionality coming soon!');
        }
    </script>
</body>
</html>
