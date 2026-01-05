<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo & Navigation -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-indigo-600">
                        DtHesap ERP
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('caris.index') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('caris.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Cariler
                    </a>
                    <a href="{{ route('faturas.index') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('faturas.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Faturalar
                    </a>
                </div>
            </div>

            <!-- User Menu -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 border border-transparent rounded-md p-1 hover:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="flex flex-col items-end mr-2">
                            <span class="font-bold">{{ auth()->user()->name }}</span>
                            @if(current_firma())
                                <span class="text-xs text-indigo-600 font-semibold">{{ current_firma()->unvan }}</span>
                            @endif
                        </div>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" 
                         x-cloak
                         @click.away="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200">
                        <!-- User Info -->
                        <div class="px-4 py-2 text-xs text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            Kullanıcı Ayarları
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Bilgileri</a>
                        
                        <!-- Firma Switcher -->
                        <div class="px-4 py-2 text-xs text-gray-400 uppercase tracking-wider border-t border-b border-gray-100 mt-1">
                            Firma Değiştir
                        </div>
                        <div class="max-h-48 overflow-y-auto">
                            @foreach(auth()->user()->firmas as $firma)
                                <form method="POST" action="{{ route('firmas.switch', $firma->id) }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left px-4 py-2 text-sm {{ current_firma_id() == $firma->id ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                        <div class="flex items-center">
                                            @if(current_firma_id() == $firma->id)
                                                <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                            {{ $firma->unvan }}
                                        </div>
                                    </button>
                                </form>
                            @endforeach
                        </div>

                        <!-- Logout -->
                        <div class="border-t border-gray-100 mt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    Çıkış Yap
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>