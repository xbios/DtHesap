<x-guest-layout>
    <div class="mb-8 text-center animate-fade-in" style="animation-delay: 0.2s;">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Hoş Geldiniz</h1>
        <p class="text-gray-500 dark:text-gray-400">Devam etmek için lütfen giriş yapın.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="animate-slide-up" style="animation-delay: 0.3s;">
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">E-Posta Adresi</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                </div>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    class="block w-full pl-10 pr-3 py-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                    placeholder="ornek@firma.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="animate-slide-up" style="animation-delay: 0.4s;">
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Şifre</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 transition-colors" href="{{ route('password.request') }}">
                        Şifremi Unuttum?
                    </a>
                @endif
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full pl-10 pr-3 py-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                    placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between animate-slide-up" style="animation-delay: 0.5s;">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-md border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400 font-medium">Beni Hatırla</span>
            </label>
        </div>

        <div class="animate-slide-up" style="animation-delay: 0.6s;">
            <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-xl shadow-glow bg-gradient-primary text-white text-sm font-bold hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                Giriş Yap
            </button>
        </div>

        <div class="mt-8 text-center animate-fade-in" style="animation-delay: 0.8s;">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Hesabınız yok mu? 
                <a href="{{ route('register') }}" class="font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 transition-colors">Hemen Kaydolun</a>
            </p>
        </div>
    </form>
</x-guest-layout>
