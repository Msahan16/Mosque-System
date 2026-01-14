<div>
    <div class="relative flex h-auto min-h-screen w-full flex-col items-center justify-center px-3 sm:px-4 py-6 sm:py-8 overflow-hidden">
        <!-- Beautiful Islamic Mosque Background -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/mosque55.jpg') }}" 
                 alt="Mosque Background" 
                 class="w-full h-full object-cover"
                 style="object-position: center;">
            <!-- Dark Overlay for better text visibility -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/50 to-black/60"></div>
        </div>

        <!-- Content Container -->
        <div class="relative z-10 w-full max-w-sm sm:max-w-md mx-auto px-2 sm:px-0">
            <!-- Mosque Logo and Title -->
            <div class="text-center mb-4 sm:mb-6">
                <div class="flex justify-center mb-0">
                    <div class="w-24 sm:w-40 h-24 sm:h-40 flex items-center justify-center">
                        <img src="{{ asset('images/masjid-logo.png') }}" alt="Mosque Logo" class="w-full h-full object-contain drop-shadow-lg filter brightness-0 invert">
                    </div>
                </div>
            </div>

            <!-- Login Card - Glassmorphism Style -->
            <div class="bg-white/5 backdrop-blur-[10px] rounded-3xl shadow-2xl border border-white/20 p-5 sm:p-6 -mt-4 sm:-mt-8">
                <!-- Welcome Text -->
                <div class="text-center mb-4 sm:mb-6">
                    <h3 class="text-xl sm:text-2xl font-bold text-white mb-1">Login</h3>
                    <p class="text-white/80 text-xs sm:text-sm">
                        Sign in to your portal
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-6 p-4 text-sm font-medium text-green-100 bg-green-500/30 border border-green-400/50 rounded-xl backdrop-blur-sm">
                        {{ session('status') }}
                    </div>
                @endif

            <!-- Login Form -->
            <form wire:submit.prevent="login" class="w-full space-y-3 sm:space-y-4">
                
                <!-- Email Field -->
                <div class="space-y-1">
                    <input
                        wire:model="email"
                        type="email"
                        required
                        autofocus
                        class="w-full px-3 sm:px-4 py-2 rounded-2xl border border-white/40 bg-white/10 backdrop-blur-[30px] text-xs sm:text-sm text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/60 transition font-medium"
                        placeholder="Email Address"
                    />
                    @error('email')
                        <p class="mt-1 text-sm text-red-200">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-1">
                    <input 
                        wire:model="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="w-full px-3 sm:px-4 py-2 rounded-2xl border border-white/40 bg-white/10 backdrop-blur-[30px] text-xs sm:text-sm text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/60 transition font-medium"
                        placeholder="Password"
                    />
                    @error('password')
                        <p class="mt-1 text-sm text-red-200">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full flex items-center justify-center px-3 sm:px-4 py-2 bg-white text-blue-600 font-bold rounded-2xl hover:bg-white/90 active:bg-white/80 transition-all shadow-lg disabled:opacity-60 disabled:cursor-not-allowed mt-3 sm:mt-4 text-xs sm:text-sm"
                >
                    <span wire:loading.remove>Login</span>
                    <span wire:loading>Signing in...</span>
                </button>
            </form>

            <!-- Demo Credentials -->
            <div class="mt-3 sm:mt-4 p-2 sm:p-3 bg-white/8 backdrop-blur-[30px] rounded-2xl border border-white/30">
                <p class="text-xs text-white font-bold mb-1 sm:mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    Demo Credentials
                </p>
                <div class="space-y-0.5 text-xs text-white/90 font-medium">
                    <p>
                        <span class="text-white">Admin:</span> admin@mosque.com / admin123
                    </p>
                    <p>
                        <span class="text-white">Mosque:</span> masjid@example.com / masjid123
                    </p>
                </div>
            </div>

        </div>
        </div>
</div>