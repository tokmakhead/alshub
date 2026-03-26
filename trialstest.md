ClinicalTrials admin liste ekranını (admin/trials) yeniden tasarlama; mevcut ekranı test odaklı değerlendir ve bana kısa ama net bir UX + product + QA raporu ver.

Amaç:
Bu sayfada ne eksik, ne fazla, ne kaldırılmalı, hangi bilgiler görünür olmalı ve bu ekranı hangi temel senaryolarla test etmemiz gerektiğini netleştirmek.

Bağlam:
Bu ekran ClinicalTrials.gov kaynaklı klinik çalışma kayıtlarının admin liste ekranı.
Şu an görünen alanlar:
- NCT ID / Başlık
- Faz / Statü
- Güven Katmanı
- Onay Durumu
- İşlem
Aksiyonlar:
- Düzenle
- Sil
Üstte durum filtresi var.

İstediğim çıktı kısa ama net olsun. Şu başlıklarda ver:

1. Mevcut ekranın güçlü yanları
2. Eksik olan kritik alanlar
Özellikle değerlendir:
- sponsor
- study status / recruitment status görünürlüğü
- publication değil ama last update / fetched date ihtiyacı
- source link / ClinicalTrials linki
- AI summary var/yok bilgisi
- region/country bilgisi
- intervention type veya kısa trial tipi bilgisi
3. Kaldırılması / değiştirilmesi gereken şeyler
Özellikle:
- “Sil” aksiyonu burada doğru mu
- “Tier 1” her satırda statik görünmesi yeterli mi
- sadece DRAFT badge’i admin için yeterli mi
4. Eklenmesi gereken aksiyonlar
Özellikle değerlendir:
- görüntüle / önizle
- ClinicalTrials’da aç
- incelemeye al
- onayla
- reddet
- yayınla
- AI özet oluştur
- yeniden çek
5. Test etmemiz gereken temel senaryolar
Kısa ama net test listesi ver:
- filtre çalışıyor mu
- düzenle doğru kaydı açıyor mu
- yanlışlıkla veri kaybı riski var mı
- farklı trial state’leri (completed, recruiting, terminated, unknown) doğru görünüyor mu
- phase + recruitment status aynı hücrede anlaşılır mı
- source link doğru açılıyor mu
- draft / approved / published ayrımı net mi
- uzun başlıkta tablo bozuluyor mu
- eksik veri varsa ekran nasıl davranıyor
6. Net önerilen revizyon listesi
Bunu 3 grup halinde ver:
- hemen yapılmalı
- sonra yapılmalı
- şimdilik bekleyebilir

Kurallar:
- kısa yaz
- baştan tasarım üretme
- kod yazma
- bu ekranı gerçek admin operasyon ekranı gibi değerlendir
- özellikle karar verme, veri görünürlüğü ve yanlış aksiyon riskine odaklan