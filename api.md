Mevcut sistemi yeniden kurgula. Şu anda ALS içerikleri RSS üzerinden toplanıyor ancak bu yaklaşım yetersiz ve güvenilirlik açısından doğru değil. Sistemi RSS merkezli yapıdan çıkarıp, kaynak türüne göre ayrıştırılmış, doğrulanabilir ve kurumsal veri kaynaklarına dayalı bir mimariye çevir.

TEMEL PRENSİP
ALS gibi kritik bir konuda tek kaynak veya RSS mantığı yeterli değil.
Sistem; araştırma, klinik çalışma, ilaç/onay, kılavuz ve uzman merkez/doktor verilerini ayrı katmanlar halinde toplamalı.
Her veri tipi kendi resmi veya kurumsal kaynağından alınmalı.
RSS sadece geçici bir toplama yöntemi değil, bu projede mümkünse tamamen kaldırılmalı. En azından ana veri kaynağı olmamalı.

HEDEF
Sistemi “haber toplar gibi içerik çeken RSS yapısı” olmaktan çıkar.
Bunun yerine “kanıt düzeyi olan, kaynağı belli, doğrulanabilir tıbbi bilgi platformu” mantığına geçir.

YENİ KAYNAK MANTIĞI

1. RESEARCH / BİLİMSEL YAYINLAR
Kaynak:
- PubMed API (NCBI E-utilities)
Amaç:
- ALS ile ilgili güncel ve globalde kabul gören bilimsel yayınları almak
Not:
- Araştırma makaleleri RSS ile değil PubMed API ile çekilsin
- PMID unique kimlik olarak kullanılsın
- Başlık, özet, yazarlar, dergi, yayın tarihi, DOI, PubMed linki saklansın

2. CLINICAL TRIALS / KLİNİK ÇALIŞMALAR
Kaynak:
- ClinicalTrials.gov API
- WHO ICTRP (mümkünse entegrasyon veya ikincil kaynak olarak)
Amaç:
- Devam eden, tamamlanan, sonuç açıklayan ALS klinik çalışmalarını toplamak
Not:
- Trial kayıtları research makalelerinden ayrı tutulmalı
- NCT ID veya resmi trial ID unique alan olmalı
- Faz, durum, sponsor, müdahale tipi, ülke, merkezler, sonuç özeti gibi alanlar saklanmalı

3. DRUGS / İLAÇLAR VE ONAY DURUMU
Kaynak:
- FDA
- EMA
Amaç:
- ALS ile ilgili ilaçların gerçekten resmi onay alıp almadığını doğrulamak
Not:
- İlaç bilgisi makalelerden türetilmemeli
- Her ilaç için bölgesel onay durumu tutulmalı
- Örn: US approval, EU approval, orphan status, indication, label date
- Her ilacın kaynağı resmi regülatör sayfası olmalı

4. GUIDELINES / KILAVUZLAR
Kaynak:
- NICE
- AAN
- EAN
Amaç:
- Klinik uygulamada kabul gören rehberleri ayrı içerik tipi olarak sunmak
Not:
- Kılavuzlar research makalesi gibi gösterilmemeli
- Ayrı kategori olmalı
- Rehber adı, yayınlayan kurum, yayın tarihi, özet, hedef alan, kaynak linki tutulmalı

5. EXPERT CENTERS / DOKTORLAR / MERKEZLER
Kaynak:
- ALS Association clinic/center listings
- NEALS
- ENCALS
- MDA Care Center Network
Amaç:
- Dünya çapında ALS konusunda çalışan kurumsal merkezleri ve ilişkili uzmanları göstermek
Not:
- Rastgele “top doctor” siteleri kullanılmasın
- Doktor verisi yalnızca resmi merkez/profil sayfalarından türetilsin
- Öncelik bireysel “en iyi doktor” listesi değil, resmi ALS merkezleri olsun
- Doktorlar merkez ilişkisi ile tutulmalı

SİSTEM TASARIM KARARI
Bu projede tüm içerikler aynı tipte tutulmayacak.
Ayrı veri modelleri veya en azından ayrı content types kurulmalı:

- research_articles
- clinical_trials
- drugs
- guidelines
- expert_centers
- doctors
- sources

Her kayıt için aşağıdaki metadata zorunlu olsun:
- source_name
- source_type
- source_url
- external_id
- verification_level
- fetched_at
- last_verified_at
- raw_payload_json
- status (draft / in_review / approved / rejected / published)

GÜVENİLİRLİK MODELİ
Her içerik için evidence / trust tier sistemi kur:

Tier 1:
- PubMed
- ClinicalTrials.gov
- WHO ICTRP
- FDA
- EMA
- NICE
- AAN
- EAN

Tier 2:
- NEALS
- ENCALS
- ALS Association
- MDA
- üniversite hastaneleri / akademik ALS merkezleri

Tier 3:
- haber kaynakları
- blog içerikleri
- yorumlayıcı ikincil içerikler

UI’de kullanıcıya bunun kaynağı ve güven düzeyi açıkça gösterilsin.

MEVCUT RSS YAPISI İÇİN KARAR
Şu anda sistem RSS üzerinden ilerliyor.
Bu yapıyı aşağıdaki şekilde dönüştür:

SEÇENEK TERCİHİ:
- Ana hedef: RSS’i tamamen kaldır
- Geçici gerekiyorsa: RSS sadece düşük öncelikli yardımcı kaynak olsun, ana veri kaynağı olmasın

Amaç:
- Research verisi RSS’ten değil PubMed API’den gelsin
- Trial verisi RSS’ten değil ClinicalTrials.gov API’den gelsin
- Drug approval verisi RSS’ten değil FDA/EMA doğrulamasından gelsin
- Guideline verisi RSS haberlerinden değil resmi guideline sayfalarından gelsin
- Doctor/center verisi RSS’ten değil resmi kurum dizinlerinden gelsin

YAPILACAK DÖNÜŞÜM
1. RSS feed importer yapısını incele
2. Hangi içeriklerin şu anda RSS ile toplandığını tespit et
3. Her RSS akışını uygun resmi kaynağa map et
4. PubMed API client ekle
5. ClinicalTrials.gov API client ekle
6. Drug verification source layer ekle
7. Guidelines source layer ekle
8. Expert centers source layer ekle
9. Eski RSS parser/job bağımlılıklarını temizle veya devre dışı bırak
10. Veri tekrarını önlemek için external_id bazlı dedup kur

İÇERİK YAYIN AKIŞI
Yeni sistem şu şekilde çalışsın:
1. Scheduler / cron çalışır
2. Resmi kaynaklardan veri çekilir
3. Raw veri saklanır
4. Normalize edilir
5. Duplicate kontrolü yapılır
6. Türkçe özet / kısa özet üretilir
7. Admin review queue’ya düşer
8. Onaydan sonra yayınlanır

ADMIN PANEL GEREKSİNİMLERİ
Admin panelinde içerik tipi bazlı filtreleme olsun:
- Research
- Trials
- Drugs
- Guidelines
- Centers
- Doctors

Ayrıca:
- Kaynak adı
- Kaynak linki
- Güven seviyesi
- Son doğrulama tarihi
- Orijinal veri
- Türkçe özet
- Yeniden çek
- Yeniden özetle
- Yayınla / reddet

KRİTİK KURAL
ALS gibi hassas bir alanda sistem “haber toplayıcı” gibi davranmamalı.
Her bilgi; kaynağı doğrulanabilir, resmi veya bilimsel temelli ve kategorik olarak ayrıştırılmış olmalı.
Mimari buna göre revize edilsin.

TESLİMDE İSTEDİKLERİM
- Yeni kaynak mimarisi
- Veri modelleri
- API entegrasyon servisleri
- Scheduler yapısı
- Admin panel değişiklikleri
- RSS’ten API tabanlı yapıya geçiş planı
- Gerekli migration dosyaları
- Dedup stratejisi
- Örnek veri akışı
- Hangi mevcut dosyaların kaldırıldığı / değiştiği

Not:
Ben bu projeyi RSS tabanlı bir içerik toplayıcı olarak istemiyorum.
ALS konusunda güvenilir, global, doğrulanabilir ve kaynak bazlı ayrıştırılmış bir bilgi platformu istiyorum.
Bu yüzden mimari kararı buna göre ver ve sistemi bu mantıkla refactor et.