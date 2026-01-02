<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gradient-primary">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="card-glass mb-8 animate-slide-up">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-neutral-800 mb-2">
                            {{ __('Welcome back') }}, {{ Auth::user()->name }}! 👋
                        </h3>
                        <p class="text-neutral-600">
                            {{ __('Here\'s what\'s happening with your account today.') }}
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <div
                            class="w-20 h-20 bg-gradient-primary rounded-2xl flex items-center justify-center shadow-glow">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Stat Card 1 -->
                <div class="card-glass animate-scale-in" style="animation-delay: 0.1s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-neutral-600 mb-1">{{ __('Total Users') }}</p>
                            <p class="text-3xl font-bold text-gradient-primary">1,234</p>
                            <p class="text-xs text-accent-600 mt-2">↑ 12% {{ __('from last month') }}</p>
                        </div>
                        <div
                            class="w-14 h-14 bg-gradient-primary rounded-xl flex items-center justify-center shadow-glow">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="card-glass animate-scale-in" style="animation-delay: 0.2s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-neutral-600 mb-1">{{ __('Revenue') }}</p>
                            <p class="text-3xl font-bold text-gradient-secondary">$45.2K</p>
                            <p class="text-xs text-accent-600 mt-2">↑ 8% {{ __('from last month') }}</p>
                        </div>
                        <div
                            class="w-14 h-14 bg-gradient-secondary rounded-xl flex items-center justify-center shadow-glow-purple">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="card-glass animate-scale-in" style="animation-delay: 0.3s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-neutral-600 mb-1">{{ __('Active Projects') }}</p>
                            <p class="text-3xl font-bold text-gradient-accent">24</p>
                            <p class="text-xs text-accent-600 mt-2">↑ 4 {{ __('new this week') }}</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-accent rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card-glass animate-fade-in">
                <h3 class="text-xl font-bold text-neutral-800 mb-6">{{ __('Recent Activity') }}</h3>
                <div class="space-y-4">
                    <div
                        class="flex items-center p-4 bg-white/50 rounded-xl hover:bg-white/70 transition-all duration-200">
                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-neutral-800">{{ __('New user registered') }}</p>
                            <p class="text-xs text-neutral-500">{{ __('2 minutes ago') }}</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center p-4 bg-white/50 rounded-xl hover:bg-white/70 transition-all duration-200">
                        <div class="w-10 h-10 bg-secondary-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-secondary-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-neutral-800">{{ __('New comment on project') }}</p>
                            <p class="text-xs text-neutral-500">{{ __('1 hour ago') }}</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center p-4 bg-white/50 rounded-xl hover:bg-white/70 transition-all duration-200">
                        <div class="w-10 h-10 bg-accent-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-neutral-800">{{ __('Task completed successfully') }}</p>
                            <p class="text-xs text-neutral-500">{{ __('3 hours ago') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>