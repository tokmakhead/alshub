@extends('frontend.layout')

@section('title', 'ALS Nedir? - ALSHub')

@section('content')
    <article class="max-w-4xl mx-auto px-4 py-20 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-10 tracking-tight">ALS Nedir?</h1>
        
        <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed space-y-8">
            <p class="text-lg leading-relaxed">
                Amyotrofik Lateral Skleroz (ALS), motor nöronların kaybı ile karakterize, ilerleyici ve hayatı tehdit eden nörodejeneratif bir hastalıktır. Motor nöronlar, beynimizden kaslarımıza giden sinyalleri taşıyarak hareket etmemizi sağlayan sinir hücreleridir.
            </p>

            <div class="bg-blue-50 p-8 rounded-3xl border border-blue-100 italic">
                <h3 class="text-blue-900 font-bold mb-4">Temel Gerçekler</h3>
                <ul class="list-disc pl-5 space-y-2 text-blue-900/80">
                    <li>ALS, genellikle 40-70 yaşları arasında ortaya çıkar.</li>
                    <li>Erkeklerde kadınlara oranla biraz daha yaygındır.</li>
                    <li>Vakaların %90-95'i "sporadik" (nedeni bilinmeyen), %5-10'u ise "ailesel" (genetik) kaynaklıdır.</li>
                </ul>
            </div>

            <h2 class="text-2xl font-bold text-gray-900">Belirtiler ve Süreç</h2>
            <p>
                ALS'nin ilk belirtileri genellikle kaslarda zayıflık, seğirmeler veya konuşma bozukluğu şeklinde başlar. Hastalık ilerledikçe yürüme, konuşma, yutkunma ve nefes alma gibi temel fonksiyonlar etkilenir. Ancak zihinsel yetenekler ve duyu organları (görme, işitme, tat alma) genellikle korunur.
            </p>

            <h2 class="text-2xl font-bold text-gray-900">Güncel Durum ve Araştırmalar</h2>
            <p>
                Henüz ALS için kesin bir tedavi bulunmamasına rağmen, semptomların yönetimi ve yaşam kalitesinin artırılması konusunda önemli bilimsel ilerlemeler kaydedilmektedir. Dünyanın dört bir yanındaki araştırmacılar, hastalığın nedenlerini anlamak ve yeni tedavi yöntemleri geliştirmek için yoğun bir çalışma yürütmektedir.
            </p>
        </div>

        <div class="mt-20 p-8 bg-gray-50 rounded-3xl border border-gray-200">
            <h3 class="text-xl font-bold text-gray-900 mb-4 italic">Önemli Hatırlatma</h3>
            <p class="text-gray-500 text-sm leading-relaxed">
                Bu sayfadaki bilgiler yalnızca genel bilgilendirme amaçlıdır. Bir tanı konulması veya tedavi süreci için mutlaka nöroloji uzmanına başvurunuz.
            </p>
        </div>
    </article>
@endsection
