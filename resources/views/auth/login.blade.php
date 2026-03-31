<x-guest-layout>
    <div class="min-h-screen flex">
        {{-- Left side - Branding --}}
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 800 800" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="400" cy="400" r="200" stroke="white" stroke-width="0.5"/>
                    <circle cx="400" cy="400" r="300" stroke="white" stroke-width="0.5"/>
                    <circle cx="400" cy="400" r="400" stroke="white" stroke-width="0.5"/>
                    <line x1="0" y1="400" x2="800" y2="400" stroke="white" stroke-width="0.5"/>
                    <line x1="400" y1="0" x2="400" y2="800" stroke="white" stroke-width="0.5"/>
                </svg>
            </div>
            <div class="relative z-10 flex flex-col justify-center px-16 text-white">
                <div class="flex items-center gap-3 mb-8">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm text-white font-bold text-lg">SF</div>
                    <span class="text-2xl font-bold tracking-tight">StudyFlow</span>
                </div>
                <h1 class="text-4xl font-bold leading-tight mb-4">Master your studies<br>with focus & flow.</h1>
                <p class="text-indigo-200 text-lg mb-10 max-w-md">Plan tasks, track time with Pomodoro, and visualize your progress — all in one beautiful workspace.</p>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <span class="text-indigo-100">Organize tasks by subjects & priority</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-indigo-100">Pomodoro timer with auto-cycling</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <span class="text-indigo-100">Detailed analytics & progress tracking</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right side - Login Form --}}
        <div class="flex-1 flex flex-col justify-center px-6 sm:px-12 lg:px-20 bg-white">
            <div class="w-full max-w-md mx-auto">
                {{-- Mobile logo --}}
                <div class="lg:hidden flex items-center gap-3 mb-8">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-indigo-600 text-white font-bold text-sm">SF</div>
                    <span class="text-xl font-bold text-gray-900 tracking-tight">StudyFlow</span>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-1">Welcome back</h2>
                <p class="text-gray-500 mb-8">Sign in to continue your study sessions.</p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                @if(session('success'))
                    <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 text-green-700 text-sm border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Google Sign In --}}
                <a href="{{ route('google.redirect') }}"
                   class="w-full flex items-center justify-center gap-3 py-3 px-4 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition mb-6">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Continue with Google
                </a>

                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                    <div class="relative flex justify-center text-sm"><span class="px-3 bg-white text-gray-400">or sign in with email</span></div>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                   class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition placeholder-gray-400"
                                   placeholder="you@example.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Forgot?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition placeholder-gray-400"
                                   placeholder="Enter your password">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center mb-6">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="remember_me" class="ml-2 text-sm text-gray-600">Remember me</label>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                            class="w-full py-3 px-4 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition shadow-sm">
                        Sign in
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">Create one free</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
