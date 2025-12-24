<div>
    <div class="relative flex h-auto min-h-screen w-full flex-col items-center justify-center px-4 py-8 overflow-hidden">
        <!-- Mosque Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/60 to-black/80"></div>
            <img src="https://images.unsplash.com/photo-1542816417-0983c9c9ad53?q=80&w=2070" 
                 alt="Mosque Background" 
                 class="w-full h-full object-cover"
                 style="object-position: center;">
        </div>

        <!-- Islamic Pattern Overlay -->
        <div class="absolute inset-0 opacity-10 z-0">
            <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.15) 35px, rgba(255,255,255,.15) 70px), repeating-linear-gradient(-45deg, transparent, transparent 35px, rgba(255,255,255,.15) 35px, rgba(255,255,255,.15) 70px);"></div>
        </div>
        
        <!-- Content Container -->
        <div class="relative z-10 w-full max-w-md mx-auto">
            <!-- Mosque Logo and Title -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <!-- Decorative Border -->
                        <div class="absolute -inset-4 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 rounded-full blur-xl opacity-30 animate-pulse"></div>
                        
                        <!-- Mosque Icon -->
                        <div class="relative w-40 h-40 flex items-center justify-center shadow-2xl">
                            <img src="{{ asset('images/mosque.png') }}" alt="Mosque Logo" class="w-full h-full object-contain drop-shadow-lg">
                        </div>
                    </div>
                </div>
                
                <h1 class="text-4xl font-bold text-white mb-2 drop-shadow-lg font-arabic">
                    مسجد
                </h1>
                <h2 class="text-2xl font-bold text-white mb-3 drop-shadow-lg">
                    Mosque Management System
                </h2>
                <p class="text-emerald-200 text-sm drop-shadow">
                    Service • Faith • Community
                </p>
            </div>

            <!-- Login Card -->
            <div class="bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 p-8">
                <!-- Welcome Text -->
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Welcome Back</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        Sign in to access your portal
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-6 p-4 text-sm font-medium text-green-600 bg-green-50 border border-green-200 rounded-lg dark:bg-green-900/20 dark:border-green-800 dark:text-green-300">
                        {{ session('status') }}
                    </div>
                @endif

            <!-- Login Form -->
            <form wire:submit.prevent="login" class="w-full space-y-5">
                
                <!-- Email Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email Address
                    </label>
                    <input
                        wire:model="email"
                        type="email"
                        required
                        autofocus
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                        placeholder="admin@mosque.com"
                    />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Password
                    </label>
                    <input 
                        wire:model="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                        placeholder="••••••••"
                    />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input 
                            wire:model="remember"
                            type="checkbox" 
                            class="rounded border-gray-300 dark:border-gray-600 text-emerald-600 focus:ring-emerald-500 h-4 w-4"
                        />
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                            Remember me
                        </span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-emerald-600 hover:text-emerald-500 transition" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-lg hover:from-emerald-700 hover:to-teal-700 active:from-emerald-800 active:to-teal-800 transition-all shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span wire:loading.remove>Sign In to Your Portal</span>
                    <span wire:loading class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Signing in...
                    </span>
                </button>
            </form>

            <!-- Demo Credentials -->
            <div class="mt-6 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-lg border border-emerald-200 dark:border-emerald-800">
                <p class="text-sm text-emerald-800 dark:text-emerald-300 font-semibold mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    Demo Credentials
                </p>
                <div class="space-y-1">
                    <p class="text-xs text-emerald-700 dark:text-emerald-400">
                        <span class="font-medium">Admin:</span> admin@mosque.com / admin123
                    </p>
                    <p class="text-xs text-emerald-700 dark:text-emerald-400">
                        <span class="font-medium">Mosque:</span> masjid@example.com / masjid123
                    </p>
                </div>
            </div>

        </div>
        </div>
</div>