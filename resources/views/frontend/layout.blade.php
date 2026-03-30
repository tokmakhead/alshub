<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ALSHub - ALS Bilgi Platformu')</title>
    <meta name="description" content="ALS hastalığı hakkında güvenilir, güncel ve Türkçe bilgilendirme platformu.">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
        .text-primary { color: #0f4c81; }
        .bg-primary { background-color: #0f4c81; }
        .border-primary { border-color: #0f4c81; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Floating Header -->
    <header class="fixed top-6 left-1/2 -translate-x-1/2 w-[95%] max-w-7xl z-50">
        <nav class="bg-white/80 backdrop-blur-xl border border-white/50 shadow-[0_20px_50px_rgba(15,76,129,0.05)] rounded-[2.5rem] px-8">
            <div class="grid grid-cols-3 items-center h-20">
                <!-- Left: Logo -->
                <div class="flex justify-start items-center shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" class="h-16 w-auto py-1" alt="ALSHub Logo">
                    </a>
                </div>
                
                <!-- Center: Desktop Menu (Grid Center) -->
                <div class="hidden md:flex justify-center items-center">
                    <div class="flex items-center space-x-1 whitespace-nowrap">
                        <a href="{{ route('about.als') }}" class="text-gray-500 hover:text-primary px-3 py-2 text-sm font-bold transition rounded-xl hover:bg-blue-50/50">ALS Nedir?</a>
                        <div class="h-4 w-px bg-gray-100 mx-1"></div>
                        
                        <a href="{{ route('publications') }}" class="text-gray-500 hover:text-primary px-3 py-2 text-sm font-bold transition rounded-xl hover:bg-blue-50/50">Araştırmalar</a>
                        <div class="h-4 w-px bg-gray-100 mx-1"></div>
                        
                        <a href="{{ route('trials') }}" class="text-gray-500 hover:text-primary px-3 py-2 text-sm font-bold transition rounded-xl hover:bg-blue-50/50">Klinik Çalışmalar</a>
                        <div class="h-4 w-px bg-gray-100 mx-1"></div>
                        
                        <a href="{{ route('drugs') }}" class="text-gray-500 hover:text-primary px-3 py-2 text-sm font-bold transition rounded-xl hover:bg-blue-50/50">İlaçlar</a>
                        <div class="h-4 w-px bg-gray-100 mx-1"></div>
                        
                        <a href="{{ route('news') }}" class="text-gray-500 hover:text-primary px-3 py-2 text-sm font-bold transition rounded-xl hover:bg-blue-50/50">Haberler</a>
                        <div class="h-4 w-px bg-gray-100 mx-1"></div>
                        
                        <a href="{{ route('guidelines') }}" class="text-gray-500 hover:text-primary px-3 py-2 text-sm font-bold transition rounded-xl hover:bg-blue-50/50">Klinik Rehberler</a>
                        <div class="h-4 w-px bg-gray-100 mx-1"></div>
                        
                        <a href="{{ route('experts.index') }}" class="text-gray-500 hover:text-primary px-3 py-2 text-sm font-bold transition rounded-xl hover:bg-blue-50/50">Uzmanlar & Merkezler</a>
                    </div>
                </div>

                <!-- Right: Mobile Menu / Balance -->
                <div class="flex justify-end items-center">
                    <button class="md:hidden p-2 text-gray-500 hover:bg-gray-50 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                    <!-- PC'de dengeleyici boş div -->
                    <div class="hidden md:block w-8"></div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Content -->
    <main class="flex-grow {{ request()->routeIs('home') ? '' : 'pt-20 md:pt-28' }}">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-20">
        <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <img src="{{ asset('images/logo.png') }}" class="h-14 w-auto mb-4" alt="ALSHub Logo">
                    <p class="text-gray-500 text-sm max-w-sm leading-relaxed">
                        ALS hastalığı ile ilgili güvenilir ve güncel bilgileri, Türkçe olarak sunan kar amacı gütmeyen bir bilgilendirme platformudur.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Hızlı Erişim</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('about.us') }}" class="text-gray-500 hover:text-primary text-sm">Hakkımızda</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-500 hover:text-primary text-sm">İletişim</a></li>
                        <li><a href="{{ route('policy') }}" class="text-gray-500 hover:text-primary text-sm">Kaynak Politikası</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Yasal Uyarı</h3>
                    <p class="text-xs text-red-500 leading-normal">
                        Bu site tıbbi tavsiye vermez. Tüm içerikler bilgilendirme amaçlıdır. Tedavi süreçleriniz için mutlaka bir uzman hekime danışınız.
                    </p>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-xs">&copy; {{ date('Y') }} ALSHub. Tüm hakları saklıdır.</p>
                <div class="flex gap-4">
                    <!-- Social icons could go here -->
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
