Kaynak Yönetimi (Source-Trust Registry) ekranını yeniden yapma; mevcut ekranı test odaklı değerlendir ve bana bu ekran için detaylı bir UX + product + QA test raporu çıkar. Amacım bu sayfada ne eksik, ne fazla, ne kaldırılmalı, ne eklenmeli ve bu ekranı hangi senaryolarla test etmemiz gerektiğini netleştirmek.

Çalışma şeklin:
- Baştan tasarım üretme
- Genel yorum yapıp geçme
- “güzel olmuş” tarzı yüzeysel değerlendirme yapma
- Bu ekranı gerçek bir admin operasyon ekranı gibi ele al
- Özellikle source-trust-first mantığına uygunluk açısından değerlendir
- Hem ürün mantığı hem operasyonel kullanım hem de test senaryoları üret

Ekran bağlamı:
Bu sayfa ALS Hub admin panelindeki “Kaynak Yönetimi / Source-Trust Registry” ekranı.
Burada resmi API ve kurumsal kaynaklar listeleniyor.
Şu an görünen örnek kaynaklar:
- PubMed
- ClinicalTrials.gov
- OpenFDA
- Guidelines (NICE/EAN) [manual]
Kolonlar:
- Kaynak Adı / Notlar
- Erişim Modu
- Durum
- Son Senkronizasyon
- İşlem
Aksiyonlar:
- Şimdi Çek
- Düzenle
- Yeni Kaynak Ekle

Benden beklenen çıktı başlıkları şu sırayla olsun:

1) Ekranın Amacı Doğru Tanımlanmış mı?
- Bu ekranın gerçek işlevi ne olmalı
- Source registry ekranı sadece listeleme ekranı mı, yoksa operasyon merkezi mi
- Bu ekran admin için hangi kararları desteklemeli
- Şu an görünen yapı bu amaca ne kadar hizmet ediyor

2) Şu Anki Bilgi Mimarisi Yeterli mi?
Kolonları tek tek değerlendir:
- Kaynak Adı / Notlar
- Erişim Modu
- Durum
- Son Senkronizasyon
- İşlem
Şunları söyle:
- hangileri yeterli
- hangileri yetersiz
- hangileri fazla yüzeysel
- hangileri eksik
- hangi kolonlar eklenmeli
- hangi kolonlar kaldırılmalı ya da detay ekrana taşınmalı

3) Mutlaka Eklenmesi Gereken Alanlar
Bu ekran source-trust-first mantığında gerçek operasyon ekranı olacaksa hangi alanlar zorunlu?
Özellikle değerlendir:
- source_type
- source_mode
- verification_tier
- enabled/disabled
- last_successful_sync
- last_failed_sync
- sync frequency
- error state
- failure count
- stale warning
- total fetched / last run stats
- primary/secondary source işareti
- official domain / source URL
- API/manual/web ingest ayrımı
Bana hangi alanlar liste görünümünde olmalı, hangileri detay/düzenleme ekranında olmalı net söyle

4) Çıkarılması veya Hafifletilmesi Gereken Noktalar
Şu anki ekranda gereksiz, zayıf veya yanıltıcı olan şeyleri tespit et:
- “Durum” badge’i tek başına yeterli mi
- “Hiç yok” ifadesi doğru mu, yoksa daha anlamlı statü mü lazım
- “Şimdi Çek” butonu her kaynak için doğru mu
- manual guideline kaynağında bu aksiyon mantıklı mı
- aynı satırda çok az veri olup admin’i kör bırakıyor mu
Neleri kaldırmalı, sadeleştirmeli veya başka yere taşımalıyız?

5) Aksiyon Mantığı Doğru mu?
Şu aksiyonları değerlendir:
- Şimdi Çek
- Düzenle
- Yeni Kaynak Ekle
Şunları söyle:
- yeterli mi
- eksik aksiyon var mı
- bazı aksiyonlar yanlış yerde mi
- per-source action mı, bulk action mı gerekli
- aşağıdaki aksiyonlar gerekli mi:
  - devre dışı bırak
  - yeniden dene
  - logları gör
  - son hatayı aç
  - kaynak detayını aç
  - test bağlantısı yap
  - manuel doğrulama işaretle
  - sync geçmişini gör

6) Source-Trust-First İlkesine Uygunluk
Bu ekran gerçekten kaynak güvenilirliği merkezli davranıyor mu?
Özellikle değerlendir:
- resmi kaynak ile manual kaynak arasındaki fark yeterince açık mı
- PubMed, ClinicalTrials, OpenFDA ve Guidelines aynı ağırlıkta mı görünüyor
- manual guideline kaynağı ile API source’lar yeterince ayrışıyor mu
- verification tier görünürlüğü şart mı
- kullanıcı/admin bu ekrana bakınca hangi kaynağın ne kadar kritik olduğunu anlayabiliyor mu

7) Riskli Tasarım / Ürün Kararları
Bu ekran bu haliyle production’da hangi yanlış kararlara yol açabilir?
Örnek olarak değerlendir:
- aktif görünen ama hiç senkronize olmamış kaynak
- senkronizasyonu başarısız olmuş ama görünmeyen hata
- stale olmuş kaynak
- manual source’un API gibi algılanması
- admin’in yalnızca “aktif” etiketine bakıp yanlış güven duyması
- kaynak kapalı mı bozuk mu belirsizliği
Her risk için kısa açıklama ve çözüm önerisi ver

8) Önerilen Nihai Tablo Yapısı
Bana bu ekran için önerdiğin nihai liste görünümünü ver.
Şu formatla:
- Görünür kolonlar
- Opsiyonel kolonlar
- Detay ekranına taşınması gereken alanlar
- Satır aksiyonları
- Toplu aksiyonlar
Ama bunu kod olarak değil, ürün kararları olarak ver

9) Test Planı
Bu ekranı nasıl test etmemiz gerektiğini detaylı yaz.
Testleri şu gruplarda ver:

A. Temel UI/UX Testleri
- tablo okunabilirliği
- badge anlaşılırlığı
- aksiyon butonlarının yerleşimi
- long source name / note taşması
- mobile/tablet davranışı gerekiyorsa belirt

B. Fonksiyonel Testler
- Şimdi Çek doğru kaynağı tetikliyor mu
- manual kaynakta yanlış aksiyon çıkıyor mu
- Düzenle ekranında alanlar doğru geliyor mu
- yeni kaynak ekleme validasyonu
- aktif/pasif değişimi
- başarısız senkronizasyon sonrası durum güncellenmesi
- son senkronizasyon alanı doğru güncelleniyor mu

C. Durum / State Testleri
Şu state’ler için ayrı ayrı test senaryosu üret:
- hiç çalışmamış kaynak
- başarılı senkronize olmuş kaynak
- son çalışması başarısız kaynak
- devre dışı kaynak
- stale kaynak
- manual source
- API source
- web-ingest source varsa onun gelecekteki yeri

D. Negatif Testler
- API timeout
- 500 hata
- boş response
- hatalı config
- yanlış endpoint
- rate limit
- duplicate sync tetikleme
- kullanıcı aynı anda art arda Şimdi Çek’e basarsa ne olacak
- senkronizasyon sırasında sayfa yenilenirse ne olacak

E. Operasyonel Testler
- admin son hatayı görebiliyor mu
- loglara erişebiliyor mu
- hangi kaynağın bozuk olduğunu tek bakışta anlayabiliyor mu
- stale source’lar ayırt ediliyor mu
- yanlışlıkla manual source’a otomatik sync yaptırılabiliyor mu
- sistem health mantığıyla bu ekran yeterince entegre mi

10) Kabul Kriterleri
Bu ekran “testten geçti” diyebilmemiz için net acceptance criteria ver.
Örneğin:
- admin bir kaynağın aktif ama hiç çalışmamış olduğunu tek bakışta anlayabilmeli
- admin son başarısız senkronizasyonu görebilmeli
- manual source ile API source karıştırılmamalı
- yanlış aksiyonlar yanlış kaynaklarda görünmemeli
- source trust / criticality görünür olmalı
- stale ve healthy kaynak ayrımı net olmalı

11) Önceliklendirilmiş Revizyon Listesi
Raporun sonunda 3 liste ver:
A. Hemen eklenmesi gerekenler
B. İkinci aşamada iyileştirilecekler
C. Şimdilik gereksiz / bekleyebilir olanlar

Ek kurallar:
- Somut konuş
- Genel tasarım yorumu yapma
- Bu ekranı gerçek operasyon ekranı gibi değerlendir
- Özellikle admin’in hata, sağlık, güven ve senkronizasyon durumunu yeterince görüp görmediğine odaklan
- Gerekiyorsa sert eleştir
- Nihai hedef: Bu ekranı test edilebilir, güvenilir ve karar verilebilir hale getirmek