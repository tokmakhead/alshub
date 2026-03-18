Çok önemli cevap kuralı:
- Büyük fazları tek yanıtta aşırı büyütme.
- Ben onay vermeden bir sonraki fazla devam etme.
- Ama her fazı kendi içinde tamamlanmış, uygulanabilir ve net ver.
- Kod verirken eksik bırakma.
- Çalışmayacak varsayımsal kod verme.
- Her faz sonunda “Bu adımda sadece istenen kapsamı yaptım” diye kontrol et.

FAZ 17 — AI draft generation
Kod üret.
- provider abstraction
- Gemini provider
- prompt templates
- içerik tipleri:
  - ilaç özeti
  - klinik araştırma özeti
  - makale özeti
  - sade hasta anlatımı
  - editoryal kısa açıklama
  - SEO kısa açıklama
- AI çıktısı taslak olarak oluşsun
- public’e gitmesin
- versiyonlansın

FAZ 18 — Tam metin arama
Kod üret.
- ilaçlar
- klinik araştırmalar
- makaleler
- Türkçe editoryal içerikler
için site geneli tam metin arama kur.
MariaDB/MySQL ile uyumlu, Plesk üzerinde sorun çıkarmayacak sade ama etkili bir yaklaşım kullan.

FAZ 19 — Admin panel
Kod üret.
Ekranlar:
- dashboard
- sync job listesi
- import log listesi
- ilaç listesi
- klinik araştırma listesi
- makale listesi
- taslak içerikler
- yayınlanmış içerikler
- editoryal içerik edit ekranı
- kullanıcı/rol ekranı
- AI jobs ekranı

Arayüz:
- sade
- premium hissiyatlı
- gereksiz şov yok
- veri yönetimi odaklı

FAZ 20 — Draft / approval / publish akışı
Kod üret.
- taslak
- onay
- red
- tekrar üret
- publish
- unpublish
- rollback
- audit log

FAZ 21 — Public site
Kod üret.
Sayfalar:
- ana sayfa
- ALS nedir
- onaylı ilaçlar
- klinik araştırmalar
- makaleler
- detay sayfaları
- arama sayfası
- kaynak politikası
- disclaimer sayfası

Arayüz:
- sade
- premium
- sağlık sitesi ciddiyeti
- okunabilir Türkçe tipografi
- mobile uyumlu

Her içerikte:
- kaynak
- kaynak linki
- son güncelleme
- doğrulama bilgisi
göster.