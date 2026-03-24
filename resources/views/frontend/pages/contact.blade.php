@extends('frontend.layout')

@section('title', 'İletişim - ALSHub')

@section('content')
    <article class="max-w-4xl mx-auto px-4 py-20 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-10 tracking-tight">İletişim</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-12">
            <div>
                <p class="text-lg text-gray-600 leading-relaxed mb-8">
                    Sorularınız, önerileriniz veya gönüllü katkılarınız için bizimle iletişime geçebilirsiniz. Size en kısa sürede dönüş yapmaya çalışacağız.
                </p>

                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="bg-blue-50 p-3 rounded-xl text-primary">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block">E-posta</span>
                            <span class="text-gray-900 font-medium">iletisim@alshub.org</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-blue-900/5">
                <form action="#" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Adınız</label>
                        <input type="text" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:ring-primary focus:border-primary transition p-3 bg-gray-50/50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">E-posta</label>
                        <input type="email" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:ring-primary focus:border-primary transition p-3 bg-gray-50/50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mesajınız</label>
                        <textarea rows="4" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:ring-primary focus:border-primary transition p-3 bg-gray-50/50"></IKAN_MESSAGE></textarea>
                    </div>
                    <button type="submit" class="w-full bg-primary text-white font-bold py-3 px-6 rounded-xl hover:bg-blue-900 transition shadow-lg shadow-blue-100">Gönder</button>
                    <p class="text-[10px] text-gray-400 text-center mt-4 italic italic">Not: Bu form şu an için sadece görsel tasarımdır.</p>
                </form>
            </div>
        </div>
    </article>
@endsection
