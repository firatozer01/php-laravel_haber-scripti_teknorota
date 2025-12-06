<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ 
          darkMode: localStorage.getItem('darkMode') 
              ? localStorage.getItem('darkMode') === 'true' 
              : window.matchMedia('(prefers-color-scheme: dark)').matches,
          mobileMenuOpen: false
      }" 
      :class="{ 'dark': darkMode }" 
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', \App\Models\SiteSetting::get('site.title', config('app.name')))</title>
    
    @if($favicon = \App\Models\SiteSetting::get('site.favicon'))
        <link rel="icon" href="{{ Storage::url($favicon) }}">
    @endif

    <meta name="description" content="@yield('meta_description', 'En güncel teknoloji haberleri, mobil incelemeler ve yazılım dünyasından gelişmeler TeknoRota\'da.')">
    <meta name="keywords" content="@yield('meta_keywords', 'teknoloji, haber, inceleme, mobil, yazılım, yapay zeka')">
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', \App\Models\SiteSetting::get('site.title', 'TeknoRota'))">
    <meta property="og:description" content="@yield('meta_description', 'En güncel teknoloji haberleri ve incelemeler.')">
    <meta property="og:image" content="@yield('meta_image', \App\Models\SiteSetting::get('site.logo') ? Storage::url(\App\Models\SiteSetting::get('site.logo')) : asset('logo.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('meta_type', 'website')">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        gray: {
                            900: '#111',
                            800: '#222',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        /* Smooth transitions */
        body, .bg-white, .bg-black, .text-black, .text-white {
            transition-property: color, background-color, border-color;
            transition-duration: 300ms;
        }
    </style>
</head>
<body class="bg-white text-black dark:bg-black dark:text-gray-100 font-sans antialiased min-h-screen">
    
    <nav class="border-b border-gray-200 dark:border-gray-800 sticky top-0 z-50 bg-white/95 dark:bg-black/95 backdrop-blur-sm transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Hamburger Menu Button (Mobile) -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-md text-gray-400 hover:text-black dark:hover:text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center md:space-x-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-3xl font-black tracking-tighter uppercase whitespace-nowrap dark:text-white">
                        @if($logo = \App\Models\SiteSetting::get('site.logo'))
                            <img src="{{ Storage::url($logo) }}" alt="Logo" class="h-8 w-auto">
                        @endif
                        {{ \App\Models\SiteSetting::get('site.title', 'TEKNOROTA') }}
                    </a>

                    <!-- Desktop Nav Links -->
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('home') }}" class="text-sm font-bold uppercase tracking-wider hover:text-gray-600 dark:hover:text-gray-300 dark:text-gray-100 transition-colors">Anasayfa</a>
                        
                        <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                             <button class="text-sm font-bold uppercase tracking-wider hover:text-gray-600 dark:hover:text-gray-300 dark:text-gray-100 transition-colors flex items-center">
                                 Kategoriler
                                 <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                             </button>
                             <div x-show="open" class="absolute left-0 mt-0 w-48 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 shadow-xl py-2 z-50">
                                 @foreach(\App\Models\Category::where('is_active', true)->get() as $category)
                                     <a href="{{ route('categories.show', $category) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 uppercase font-bold">{{ $category->name }}</a>
                                 @endforeach
                             </div>
                        </div>

                        <a href="{{ route('articles.index') }}" class="text-sm font-bold uppercase tracking-wider hover:text-gray-600 dark:hover:text-gray-300 dark:text-gray-100 transition-colors">Tüm Haberler</a>
                        <a href="{{ route('about') }}" class="text-sm font-bold uppercase tracking-wider hover:text-gray-600 dark:hover:text-gray-300 dark:text-gray-100 transition-colors">Hakkımızda</a>
                        <a href="{{ route('videos.index') }}" class="text-sm font-bold uppercase tracking-wider hover:text-gray-600 dark:hover:text-gray-300 dark:text-gray-100 transition-colors">Videolar</a>
                        <a href="{{ route('questions.index') }}" class="text-sm font-bold uppercase tracking-wider hover:text-gray-600 dark:hover:text-gray-300 dark:text-gray-100 transition-colors">Soru-Cevap</a>
                    </div>
                </div>
                
                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition-colors">
                        <svg x-show="!darkMode" class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg x-show="darkMode" class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </button>

                    <!-- Auth Links -->
                    <div class="hidden md:flex items-center space-x-4 text-sm font-semibold">
                        @auth
                            <div class="relative group" x-data="{ userOpen: false }" @mouseenter="userOpen = true" @mouseleave="userOpen = false">
                                <button class="flex items-center focus:outline-none">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center font-bold text-xs uppercase">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                </button>
                                <div x-show="userOpen" class="absolute right-0 mt-0 w-48 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 shadow-xl py-2 z-50">
                                    <div class="px-4 py-2 text-xs text-gray-500 uppercase border-b border-gray-100 dark:border-gray-800">{{ auth()->user()->name }}</div>
                                    
                                    @if(auth()->user()->isAdmin() || auth()->user()->isEditor())
                                        <a href="{{ url('/admin') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Yönetim Paneli</a>
                                    @endif
                                    
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Profil Ayarları</a>
                                    
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-800">Çıkış Yap</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="hover:text-gray-600 dark:hover:text-gray-300 dark:text-white uppercase transition-colors">Giriş</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-black text-white dark:bg-white dark:text-black rounded hover:opacity-80 transition uppercase font-bold">Kayıt</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" class="md:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-800">Anasayfa</a>
                <a href="{{ route('articles.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800">Tüm Haberler</a>
                <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800">Hakkımızda</a>
                
                @auth
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-800">Profil Ayarları</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-gray-100 dark:hover:bg-gray-800">Çıkış Yap</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-800">Giriş Yap</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100 dark:hover:bg-gray-800">Kayıt Ol</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 dark:border-gray-800 mt-20 py-12 bg-gray-50 dark:bg-black transition-colors">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-black uppercase tracking-tighter mb-6 dark:text-white">TEKNOROTA</h2>
            
            <div class="flex justify-center space-x-6 mb-8">
                @foreach(\App\Models\SocialMedia::where('is_active', true)->orderBy('order')->get() as $social)
                    <a href="{{ $social->url }}" target="_blank" class="w-12 h-12 rounded-full flex items-center justify-center text-white transition transform hover:scale-110 hover:-translate-y-1 shadow-lg" style="background-color: {{ $social->color }}">
                        @if($social->icon)
                            <i class="{{ $social->icon }} fa-lg"></i>
                        @else
                           <span class="font-bold">{{ substr($social->name, 0, 2) }}</span>
                        @endif
                    </a>
                @endforeach
            </div>

            <p class="text-gray-500 dark:text-gray-400 text-sm">
                &copy; {{ date('Y') }} TeknoRota. Teknoloji dünyasının nabzını tutun.
            </p>
        </div>
    </footer>

</body>
</html>
