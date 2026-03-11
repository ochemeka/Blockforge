<x-guest-layout>
    <!-- Registration Form with Two Columns -->
    <div class="w-full max-w-5xl mx-auto px-4">
        <div class="card rounded-2xl p-6 md:p-8 border border-purple-800/30">
            <!-- Form Header -->
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-primary">Create Account</h2>
                <p class="text-secondary text-base mt-2">Join Blockforge to start mining today</p>
            </div>

            <!-- Google Sign Up Button -->
            <a href="{{ route('google.redirect') }}" class="w-full flex items-center justify-center py-3 px-4 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 transition mb-6">
                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="text-primary font-medium">Sign up with Google</span>
            </a>

            <!-- Divider -->
            <div class="flex items-center mb-6">
                <div class="flex-1 border-t border-white/10"></div>
                <span class="px-4 text-secondary text-sm">or</span>
                <div class="flex-1 border-t border-white/10"></div>
            </div>

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Two Column Form Layout -->
                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-primary mb-2">Full Name</label>
                            <input 
                                id="name" 
                                name="name" 
                                type="text" 
                                value="{{ old('name') }}" 
                                required 
                                autofocus
                                autocomplete="name"
                                class="w-full px-4 py-3.5 rounded-xl input-field transition text-base"
                                placeholder="Enter your full name"
                            >
                            @error('name')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-primary mb-2">Email Address</label>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                value="{{ old('email') }}" 
                                required 
                                autocomplete="email"
                                class="w-full px-4 py-3.5 rounded-xl input-field transition text-base"
                                placeholder="Enter your email"
                            >
                            @error('email')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Country -->
                        <div>
                            <label for="country" class="block text-sm font-semibold text-primary mb-2">Country</label>
                            <select 
                                id="country" 
                                name="country" 
                                required
                                onchange="updateStates()"
                                class="w-full px-4 py-3.5 rounded-xl input-field transition text-base"
                            >
                                <option value="">Select Country</option>
                                <option value="NG">Nigeria</option>
                                <option value="GH">Ghana</option>
                                <option value="KE">Kenya</option>
                                <option value="ZA">South Africa</option>
                                <option value="EG">Egypt</option>
                                <option value="MA">Morocco</option>
                                <option value="TZ">Tanzania</option>
                                <option value="UG">Uganda</option>
                                <option value="SN">Senegal</option>
                                <option value="CI">Cote d'Ivoire</option>
                                <option value="CM">Cameroon</option>
                                <option value="ET">Ethiopia</option>
                                <option value="DZ">Algeria</option>
                                <option value="RW">Rwanda</option>
                                <option value="TN">Tunisia</option>
                            </select>
                            @error('country')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-primary mb-2">Password</label>
                            <div class="relative">
                                <input 
                                    id="password" 
                                    name="password" 
                                    type="password" 
                                    required 
                                    autocomplete="new-password"
                                    class="w-full px-4 py-3.5 rounded-xl input-field transition text-base pr-12"
                                    placeholder="Create a password"
                                >
                                <button type="button" onclick="togglePassword('password', 'togglePassword')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-purple-400 hover:text-purple-300 transition">
                                    <svg id="togglePassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Referral Code -->
                        <div>
                            <label for="referral_code" class="block text-sm font-semibold text-primary mb-2">Referral Code (Optional)</label>
                            <input 
                                id="referral_code" 
                                name="referral_code" 
                                type="text" 
                                value="{{ old('referral_code', request('ref')) }}"
                                class="w-full px-4 py-3.5 rounded-xl input-field transition text-base"
                                placeholder="Enter referral code"
                            >
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-semibold text-primary mb-2">Username</label>
                            <input 
                                id="username" 
                                name="username" 
                                type="text" 
                                value="{{ old('username') }}" 
                                required
                                autocomplete="username"
                                class="w-full px-4 py-3.5 rounded-xl input-field transition text-base"
                                placeholder="Choose a username"
                            >
                            @error('username')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-primary mb-2">Phone Number</label>
                            <input 
                                id="phone" 
                                name="phone" 
                                type="tel" 
                                value="{{ old('phone') }}" 
                                required
                                class="w-full px-4 py-3.5 rounded-xl input-field transition text-base"
                                placeholder="Enter phone number"
                            >
                            @error('phone')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- State -->
                        <div>
                            <label for="state" class="block text-sm font-semibold text-primary mb-2">State</label>
                            <select 
                                id="state" 
                                name="state" 
                                required
                                class="w-full px-4 py-3.5 rounded-xl input-field transition text-base"
                            >
                                <option value="">Select State</option>
                            </select>
                            @error('state')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-primary mb-2">Confirm Password</label>
                            <div class="relative">
                                <input 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    type="password" 
                                    required 
                                    autocomplete="new-password"
                                    class="w-full px-4 py-3.5 rounded-xl input-field transition text-base pr-12"
                                    placeholder="Confirm your password"
                                >
                                <button type="button" onclick="togglePassword('password_confirmation', 'toggleConfirmPassword')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-purple-400 hover:text-purple-300 transition">
                                    <svg id="toggleConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Terms -->
                        <div class="pt-2">
                            <label class="flex items-start">
                                <input type="checkbox" name="terms" value="1" required class="mt-1 w-5 h-5 rounded border-white/20 bg-white/5 text-purple-500 focus:ring-purple-500/20">
                                <span class="ml-3 text-sm text-primary">
                                    I agree to the <a href="#" class="text-purple-400 hover:text-purple-300">Terms of Service</a> and <a href="#" class="text-purple-400 hover:text-purple-300">Privacy Policy</a>
                                </span>
                            </label>
                            @error('terms')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Register Button -->
                <button type="submit" class="w-full mt-6 py-4 rounded-xl purple-glow text-white font-bold text-lg purple-glow-hover transition">
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <p class="mt-6 text-center text-primary text-base">
                Already have an account? 
                <a href="/login" class="text-purple-400 hover:text-purple-300 font-semibold">
                    Sign In
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>

<script>
    // State data for countries
    const countryStates = {
        'NG': ['Abia', 'Abuja FCT', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno', 'Cross River', 'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'Gombe', 'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara'],
        'GH': ['Ashanti', 'Brong-Ahafo', 'Central', 'Eastern', 'Greater Accra', 'Northern', 'Upper East', 'Upper West', 'Volta', 'Western'],
        'KE': ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret', 'Malindi', 'Kitale', 'Garissa', 'Thika', 'Naivasha'],
        'ZA': ['Gauteng', 'KwaZulu-Natal', 'Western Cape', 'Eastern Cape', 'Free State', 'Limpopo', 'Mpumalanga', 'North West', 'Northern Cape'],
        'EG': ['Cairo', 'Alexandria', 'Giza', 'Luxor', 'Aswan', 'Mansoura', 'Tanta', 'Faiyum', 'Zagazig', 'Suez'],
        'MA': ['Casablanca', 'Rabat', 'Marrakech', 'Fes', 'Tanger', 'Agadir', 'Meknes', 'Oujda', 'Kenitra', 'Tetouan'],
        'TZ': ['Dar es Salaam', 'Dodoma', 'Arusha', 'Mwanza', 'Mbeya', 'Morogoro', 'Tanga', 'Kigoma', 'Iringa', 'Shinyanga'],
        'UG': ['Kampala', 'Wakiso', 'Mukono', 'Jinja', 'Gulu', 'Lira', 'Mbarara', 'Masaka', 'Kasese', 'Soroti'],
        'SN': ['Dakar', 'Thies', 'Diourbel', 'Kaolack', 'Saint-Louis', 'Fatick', 'Kaffrine', 'Kolda', 'Tambacounda', 'Ziguinchor'],
        'CI': ['Abidjan', 'Yamoussoukro', 'Bouaké', 'Daloa', 'Man', 'Korhogo', 'San-Pédro', 'Divo', 'Gagnoa', 'Bondoukou'],
        'CM': ['Yaoundé', 'Douala', 'Bafoussam', 'Bamenda', 'Kousséri', 'Koforidua', 'Bertoua', 'Maroua', 'Ngaoundéré', 'Edéa'],
        'ET': ['Addis Ababa', 'Dire Dawa', 'Gondar', 'Hawassa', 'Mekelle', 'Adama', 'Bahir Dar', 'Jimma', 'Dessie', 'Kombolcha'],
        'DZ': ['Algiers', 'Oran', 'Constantine', 'Annaba', 'Blida', 'Batna', 'Djelfa', 'Sétif', 'Sidi Bel Abbès', 'Biskra'],
        'RW': ['Kigali', 'Rwamagana', 'Huye', 'Musanze', 'Rubavu', 'Nyagatare', 'Gicumbi', 'Ruhango', 'Nyamasheke', 'Kamonyi'],
        'TN': ['Tunis', 'Sfax', 'Sousse', 'Kairouan', 'Médenine', 'Biserte', 'Gabès', 'Ariana', 'Gafsa', 'Monastir']
    };

    function updateStates() {
        const countrySelect = document.getElementById('country');
        const stateSelect = document.getElementById('state');
        const selectedCountry = countrySelect.value;
        
        stateSelect.innerHTML = '<option value="">Select State</option>';
        
        if (selectedCountry && countryStates[selectedCountry]) {
            countryStates[selectedCountry].forEach(state => {
                const option = document.createElement('option');
                option.value = state;
                option.textContent = state;
                stateSelect.appendChild(option);
            });
        }
    }
</script>
