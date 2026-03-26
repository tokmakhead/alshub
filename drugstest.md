İlaçlar admin liste ekranını (admin/drugs) yeniden tasarlama; mevcut ekranı test odaklı değerlendir ve bana kısa ama net bir UX + product + QA raporu ver. Mevcut tasarım dilini ve görsel bütünlüğü bozma; öneri ve revizyonlar mevcut UI sistemine uyumlu olsun.

Amaç:
Bu sayfada ne eksik, ne fazla, ne kaldırılmalı, hangi bilgiler görünür olmalı ve bu ekranı hangi temel senaryolarla test etmemiz gerektiğini netleştirmek.

Bağlam:
Bu ekran FDA / EMA tracker mantığında ilaç kayıtlarının admin liste ekranı.
Şu an görünen alanlar:
- İlaç Adı (Generic / Brand)
- Bölgesel Durumlar (FDA/EMA)
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
- generic_name / brand_name ayrımı yeterli mi
- source/regulator görünürlüğü
- US ve EU durumlarının aynı anda görünmesi gerekip gerekmediği
- approval_status, indication, approval_date, last_verified_at ihtiyacı
- change_detected / review needed bilgisi
- source link (FDA / EMA) görünürlüğü
- AI summary veya kısa açıklama durumu gerekli mi
- duplicate/aynı ilaç farklı label kayıtlarının ayrıştırılması gerekiyor mu

3. Kaldırılması / değiştirilmesi gereken şeyler
Özellikle:
- “Sil” aksiyonu burada doğru mu
- Tier 1 her satırda statik görünmesi yeterli mi
- sadece DRAFT badge’i admin için yeterli mi
- uzun ve kirli ilaç adları / label metinleri listeyi bozuyor mu
- mevcut ilk kolon ilaç adı yerine yanlışlıkla label text gösteriyor mu

4. Eklenmesi gereken aksiyonlar
Özellikle değerlendir:
- görüntüle / önizle
- FDA’da aç
- EMA’da aç
- incelemeye al
- onayla
- reddet
- yayınla
- yeniden doğrula / yeniden çek
- değişiklik geçmişini gör
- duplicate birleştirme / eşleştirme aksiyonu gerekli mi

5. Test etmemiz gereken temel senaryolar
Kısa ama net test listesi ver:
- filtre çalışıyor mu
- düzenle doğru kaydı açıyor mu
- yanlışlıkla veri kaybı riski var mı
- US/EU status’ler doğru görünüyor mu
- approval status ve review status karışıyor mu
- source link doğru açılıyor mu
- duplicate drug kayıtları nasıl davranıyor
- change_detected olan kayıt görünür mü
- uzun isim / kirli label text tabloyu bozuyor mu
- eksik EMA veya eksik FDA verisinde ekran nasıl davranıyor

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
- özellikle duplicate riskine, regulator görünürlüğüne, veri temizliğine ve yanlış aksiyon riskine odaklan
- mevcut tasarım bütünlüğünü bozacak öneriler verme