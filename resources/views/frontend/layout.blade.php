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
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-primary tracking-tight">ALS<span class="text-gray-400 font-light">Hub</span></span>
                    </a>
                    <div class="hidden md:ml-10 md:flex md:space-x-4 lg:space-x-6 items-center">
                        <a href="{{ route('about.als') }}" class="text-gray-600 hover:text-primary px-2 py-2 text-sm font-semibold transition flex items-center gap-1.5 group">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-primary transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            ALS Nedir?
                        </a>
                        <a href="{{ route('publications') }}" class="text-gray-600 hover:text-primary px-2 py-2 text-sm font-semibold transition flex items-center gap-1.5 group">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-primary transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.691.346a6 6 0 01-3.86.517l-2.387-.477a2 2 0 00-1.022.547l-1.168 1.168a2 2 0 00.566 3.414l9.74 1.391a2 2 0 001.166-.2l9.74-5.566a2 2 0 00.566-3.414l-1.168-1.168z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01"></path></svg>
                            Araştırmalar
                        </a>
                        <a href="{{ route('trials') }}" class="text-gray-600 hover:text-primary px-2 py-2 text-sm font-semibold transition flex items-center gap-1.5 group">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-primary transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Klinik Çalışmalar
                        </a>
                        <a href="{{ route('drugs') }}" class="text-gray-600 hover:text-primary px-2 py-2 text-sm font-semibold transition flex items-center gap-1.5 group">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-primary transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.691.346a6 6 0 00-3.86.517l-2.387-.477a2 2 0 00-1.022.547l-1.168 1.168a2 2 0 00.566 3.414l9.74 1.391a2 2 0 001.166-.2l9.74-5.566a2 2 0 00.566-3.414l-1.168-1.168z"></path></svg>
                            İlaçlar
                        </a>
                        <a href="{{ route('guidelines') }}" class="text-gray-600 hover:text-primary px-2 py-2 text-sm font-semibold transition flex items-center gap-1.5 group">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-primary transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            Klinik Rehberler
                        </a>
                        <a href="{{ route('experts.index') }}" class="text-gray-600 hover:text-primary px-2 py-2 text-sm font-semibold transition flex items-center gap-1.5 group">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-primary transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Uzmanlar & Merkezler
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <form action="{{ route('search') }}" method="GET" class="hidden lg:block relative">
                        <input type="text" name="q" placeholder="Arama yapın..." class="w-48 xl:w-64 pl-10 pr-4 py-2 border border-gray-200 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        <svg class="w-4 h-4 text-gray-400 absolute left-4 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-20">
        <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <span class="text-2xl font-bold text-primary mb-4 block">ALS<span class="text-gray-400 font-light">Hub</span></span>
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
