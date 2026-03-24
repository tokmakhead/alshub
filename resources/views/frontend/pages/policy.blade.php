@extends('frontend.layout')

@section('title', 'Kaynak Politikası - ALSHub')

@section('content')
    <article class="max-w-4xl mx-auto px-4 py-20 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-10 tracking-tight">Kaynak Politikası</h1>
        
        <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed space-y-8">
            <p class="text-lg">
                ALSHub üzerindeki tüm içerikler, güvenilir küresel kaynaklardan derlenmektedir. Bilginin şeffaflığı ve doğrulanabilirliği bizim için en önemli önceliktir.
            </p>

            <h2 class="text-2xl font-bold text-gray-900">Atıf ve Kaynak Gösterimi</h2>
            <p>
                Yayınladığımız her özet veya haberin altında "Kaynak" bölümü bulunur. Bu bölümde içeriğin orijinal başlığı, yayınlanan platformun adı ve orijinal içeriğe yönlendiren bir bağlantı yer alır. 
            </p>

            <h2 class="text-2xl font-bold text-gray-900">Çeviri Yaklaşımı</h2>
            <p>
                Tıbbi terimlerin Türkçe karşılıklarını kullanırken azami özen gösteriyoruz. Ancak, orijinalliği bozmamak adına bazı terimlerin İngilizce karşılıklarını da parantez içinde veya meta bilgilerde belirtiyoruz. Sistemimiz, orijinal veriyi her zaman yedekleyerek veri kaybını önler.
            </p>

            <h2 class="text-2xl font-bold text-gray-900">Hatalı İçerik Bildirimi</h2>
            <p>
                Eğer bir çeviride hata olduğunu düşünüyorsanız veya bir kaynağın yanlış yorumlandığını fark ederseniz, lütfen `iletisim@alshub.org` üzerinden bizimle iletişime geçiniz. 
            </p>
        </div>
    </article>
@endsection
