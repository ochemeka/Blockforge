<x-guest-layout>
    <!-- Two Column Layout -->
    <div class="w-full max-w-6xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            
            <!-- Left Column - Branding/Info -->
            <div class="hidden md:block text-center">
                <div class="inline-block p-8 rounded-2xl card">
                    <div class="w-20 h-20 rounded-2xl purple-glow flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold gradient-text mb-4">BlockForge BFB</h2>
                    <p class="text-secondary text-lg mb-6">Start mining BFB tokens today!</p>
                    <ul class="text-left space-y-3 text-secondary">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Free daily mining
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Referral bonuses
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Secure blockchain mining
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Column - Login Form -->
            <div class="w-full max-w-md mx-auto">
                <div class="card rounded-2xl p-8 border border-purple-800/30">
                    <h2 class="text-2xl font-bold text-primary text-center mb-2">Welcome Back</h2>
                    <p class="text-secondary text-center mb-8">Login to your account</p>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 p-3 rounded-lg bg-green-500/10 border border-green-500/20 text-green-400 text-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-4 p-3 rounded-lg bg-green-500/10 border border-green-500/20 text-green-400 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red text-red-400-500/20 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Google Login Button -->
                    <a href="{{ route('google.redirect') }}" class="w-full flex items-center justify-center py-3 px-4 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 transition mb-6">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="text-primary font-medium">Continue with Google</span>
                    </a>

                    <!-- Divider -->
                    <div class="flex items-center mb-6">
                        <div class="flex-1 border-t border-white/10"></div>
                        <span class="px-4 text-secondary text-sm">or</span>
                        <div class="flex-1 border-t border-white/10"></div>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-secondary mb-2">Email</label>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                value="{{ old('email', session('email')) }}" 
                                required 
                                autofocus
                                autocomplete="username"
                                class="w-full px-4 py-3 rounded-xl input-field transition"
                                placeholder="Enter your email"
                            >
                            @error('email')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-secondary mb-2">Password</label>
                            <div class="relative">
                                <input 
                                    id="password" 
                                    name="password" 
                                    type="password" 
                                    required 
                                    autocomplete="current-password"
                                    class="w-full px-4 py-3 rounded-xl input-field transition pr-12"
                                    placeholder="Enter your password"
                                >
                                <button type="button" onclick="togglePassword('password', 'toggleIcon')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-black-800 hover:text-black-800 transition">
                                    <svg id="toggleIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-white/20 bg-white/5 text-purple-500 focus:ring-purple-500/20">
                                <span class="ml-2 text-sm text-secondary">Remember me</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-purple-400 hover:text-purple-300">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="w-full py-3 rounded-xl purple-glow text-white font-semibold purple-glow-hover transition">
                            Login
                        </button>
                    </form>

                    <!-- Register Link -->
                    <p class="mt-6 text-center text-secondary">
                        Don't have an account? 
                        <a href="/register" class="text-purple-400 hover:text-purple-300 font-medium">
                            Sign up here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

