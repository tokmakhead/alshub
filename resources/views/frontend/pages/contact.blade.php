@extends('frontend.layout')

@section('title', 'İletişim - ALSHub')

@section('content')
<div class="min-h-screen pt-32 pb-20 bg-gradient-to-b from-white to-blue-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Header -->
        <div class="text-center max-w-3xl mx-auto mb-20 animate-fade-in">
            <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-6 tracking-tight">
                Nasıl <span class="text-primary italic">Yardımcı</span> Olabiliriz?
            </h1>
            <p class="text-xl text-gray-500 leading-relaxed font-medium">
                Sıklıkla sorulan soruları yanıtlamak, gönüllü desteklerinizi organize etmek veya teknik sorularınızı cevaplamak için buradayız.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <!-- Left Side: Info & FAQ -->
            <div class="space-y-12">
                <!-- Contact Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-900/5 hover:shadow-blue-900/10 transition-shadow">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-primary mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">E-posta</h3>
                        <p class="text-lg font-bold text-gray-900">iletisim@alshub.org</p>
                    </div>
                    <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-xl shadow-blue-900/5 hover:shadow-blue-900/10 transition-shadow">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-primary mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">Gönüllü Olun</h3>
                        <p class="text-lg font-bold text-gray-900">gonullu@alshub.org</p>
                    </div>
                </div>

                <!-- FAQ Shortlist -->
                <div class="bg-white/50 backdrop-blur-xl p-10 rounded-[2.5rem] border border-white shadow-2xl shadow-blue-900/5">
                    <h2 class="text-2xl font-black text-gray-900 mb-8 flex items-center gap-3">
                        <span class="w-8 h-8 bg-primary text-white rounded-lg flex items-center justify-center text-sm">?</span>
                        Hızlı Yanıtlar
                    </h2>
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2">Veriler ne sıklıkla güncelleniyor?</h4>
                            <p class="text-sm text-gray-500 leading-relaxed">Sistemimiz küresel API'leri (PubMed, FDA, EMA) her 24 saatte bir otomatik olarak tarar ve yeni verileri işler.</p>
                        </div>
                        <div class="border-t border-gray-100 pt-6">
                            <h4 class="font-bold text-gray-900 mb-2">Gönüllü olarak nasıl destek olabilirim?</h4>
                            <p class="text-sm text-gray-500 leading-relaxed">Çeviri, veri girişi veya teknoloji geliştirme alanlarında destek olabilirsiniz. İletişim formundan "Gönüllülük" konusunu seçerek bize yazın.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Interaction Form -->
            <div class="bg-white p-10 md:p-12 rounded-[3rem] shadow-2xl shadow-blue-200/50 border border-gray-100 relative overflow-hidden">
                <!-- Decorette Gradient -->
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-50"></div>
                
                <form id="contactForm" class="relative z-10 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Adınız Soyadınız</label>
                            <input type="text" name="name" required class="w-full bg-gray-50 border-0 rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none" placeholder="Örn: Ahmet Yılmaz">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">E-posta Adresiniz</label>
                            <input type="email" name="email" required class="w-full bg-gray-50 border-0 rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none" placeholder="ahmet@email.com">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Telefon (Opsiyonel)</label>
                            <input type="tel" name="phone" class="w-full bg-gray-50 border-0 rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none" placeholder="05XX XXX XX XX">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Konu</label>
                            <select name="subject" required class="w-full bg-gray-50 border-0 rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none appearance-none">
                                <option value="Bilgi Talebi">Bilgi Talebi / Soru</option>
                                <option value="Gönüllülük">Gönüllü Destek</option>
                                <option value="Hata Bildirimi">Hata Bildirimi</option>
                                <option value="İş Birliği">İş Birliği</option>
                                <option value="Diğer">Diğer</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Mesajınız</label>
                        <textarea name="message" rows="5" required class="w-full bg-gray-50 border-0 rounded-3xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none" placeholder="Nasıl yardımcı olabiliriz?"></textarea>
                    </div>

                    <button type="submit" id="submitBtn" class="w-full bg-primary text-white py-5 px-8 rounded-2xl font-black text-lg shadow-xl shadow-blue-100 hover:bg-blue-900 transition-all flex items-center justify-center gap-3 active:scale-95">
                        <span>Mesajı Gönder</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    
                    <p class="text-[10px] text-gray-400 text-center uppercase tracking-widest font-black opacity-50">Kişisel verileriniz gizlilik politikamız kapsamında korunur.</p>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    const originalText = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<span class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></span>';

    const formData = new FormData(this);
    
    fetch('{{ route("contact.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Harika!',
                text: data.message,
                confirmButtonColor: '#1d4ed8',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-10 py-3 font-bold'
                }
            });
            this.reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Hata',
                text: data.message,
                confirmButtonColor: '#1d4ed8'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Hata',
            text: 'Beklenmeyen bir hata oluştu. Lütfen tekrar deneyiniz.',
            confirmButtonColor: '#1d4ed8'
        });
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
});
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
@endsection
