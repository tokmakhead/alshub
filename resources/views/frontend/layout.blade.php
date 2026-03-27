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
                    <div class="hidden md:ml-10 md:flex md:space-x-8 lg:space-x-10 items-center">
                        <a href="{{ route('about.als') }}" class="text-gray-600 hover:text-primary px-2 py-2 text-sm font-semibold transition flex items-center gap-1.5 group">
                            ALS Nedir?
                        </a>
                        <a href="{{ route('publications') }}" class="text-gray-600 hover:text-primary px-2 py-2 text-sm font-semibold transition flex items-center gap-1.5 group">
                            Araştırmalar
                        </a>
                        <a href="{{ route('trials') }}" class="text-gray-600 hover:text-primary px-2 py-2 text-sm font-semibold transition flex items-center gap-1.5 group">
                            Klinik Çalışmalar
                        </a>
                        <a href="{{ route('drugs') }}" class="text-gray-600 hover:text-primary px-2 py-2 text-sm font-semibold transition flex items-center gap-1.5 group">
                            İlaçlar
                        </a>
                        <a href="{{ route('guidelines') }}" class="text-gray-600 hover:text-primary px-2 py-2 text-sm font-semibold transition flex items-center gap-1.5 group">
                            Klinik Rehberler
                        </a>
                        <a href="{{ route('experts.index') }}" class="text-gray-600 hover:text-primary px-2 py-2 text-sm font-semibold transition flex items-center gap-1.5 group">
                            Uzmanlar & Merkezler
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    {{-- Header Arama Kaldırıldı - Tasarım Hero'da --}}
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
