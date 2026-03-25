Sistemin mimarisini şu ilkeye göre yeniden düzenle:

TEMEL İLKE
Bu platformun önceliği “API kullanmak” değil, “doğru, güvenilir, globalde kabul görmüş ve doğrulanabilir ALS bilgisini” toplamaktır.
Mimari karar teknik kolaylığa göre değil, kaynak güvenilirliğine göre verilsin.
Yani sistem “API-first” değil, “source-trust-first” mantığıyla çalışsın.

ANA KURAL
- Resmi API varsa kullan.
- Resmi API yoksa yalnızca resmi ve kurumsal web kaynaklarından kontrollü ingest yap.
- Rastgele haber siteleri, bloglar, SEO içerikleri, “top doctor” tarzı listeleme siteleri, yorumlayıcı ikincil kaynaklar ana veri kaynağı olarak kullanılmasın.
- RSS ana kaynak olmaktan çıkarılsın.
- Mümkünse tamamen kaldır.
- Geçici olarak tutulacaksa yalnızca düşük öncelikli yardımcı kaynak olsun; ana veri akışı RSS üzerinden kurulmasın.

HEDEF
Bu sistemi RSS tabanlı içerik toplayıcı mantığından çıkar.
Bunun yerine ALS konusunda:
- bilimsel yayınları,
- klinik çalışmaları,
- ilaç/onay durumlarını,
- klinik kılavuzları,
- uzman merkezleri ve ilişkili doktorları
ayrı veri katmanları halinde toplayan, doğrulayan, saklayan ve editör onayı sonrası yayımlayan güvenilir bir bilgi platformuna dönüştür.

KAYNAK STRATEJİSİ

1) RESEARCH / BİLİMSEL YAYINLAR
Amaç:
ALS ile ilgili güncel ve global ölçekte kabul gören bilimsel yayınları toplamak.
Kaynak mantığı:
- Ana kaynak PubMed olsun.
- Araştırma makaleleri RSS ile değil resmi veri kaynağı üzerinden alınsın.
Kurallar:
- PMID unique kimlik olarak kullanılsın.
- Başlık, özet, yazarlar, dergi, yayın tarihi, DOI, kaynak linki saklansın.
- Aynı kayıt ikinci kez eklenmesin.

2) CLINICAL TRIALS / KLİNİK ÇALIŞMALAR
Amaç:
ALS ile ilgili devam eden, tamamlanan veya sonuç açıklayan klinik çalışmaları toplamak.
Kaynak mantığı:
- ClinicalTrials.gov ana kaynak olsun.
- Global kapsama için WHO ICTRP benzeri resmi trial kaynakları yardımcı katman olarak eklenebilsin.
Kurallar:
- Trial kayıtları research makaleleriyle karıştırılmasın.
- NCT ID veya resmi external_id unique alan olsun.
- Faz, durum, sponsor, müdahale tipi, ülke, merkez, sonuç özeti gibi alanlar saklansın.

3) DRUGS / İLAÇLAR VE RESMİ ONAY DURUMU
Amaç:
ALS ile ilişkili ilaçların gerçekten resmi düzeyde hangi bölgede hangi statüde olduğunu göstermek.
Kaynak mantığı:
- FDA ve EMA gibi resmi regülatör kaynaklar baz alınsın.
Kurallar:
- Bir ilacın “ALS için onaylı”, “belirli alt tip için onaylı”, “araştırma aşamasında”, “inceleme altında” gibi statüleri yalnızca resmi kaynaklardan doğrulansın.
- İlaç bilgisi yalnızca makaleden türetilmesin.
- Bölgesel statü tutulsun:
  - US approval
  - EU approval
  - orphan / special designation
  - indication / endikasyon
  - label / approval tarihi
- Her ilaç için resmi kaynak URL saklansın.

4) GUIDELINES / KILAVUZLAR
Amaç:
Klinik uygulamada kabul gören ALS rehberlerini ayrı içerik tipi olarak sunmak.
Kaynak mantığı:
- NICE, AAN, EAN gibi resmi mesleki/kurumsal guideline kaynakları esas alınsın.
Kurallar:
- Guideline içerikleri research makaleleriyle aynı tabloda tutulmasın.
- Ayrı content type veya ayrı tablo olsun.
- Rehber adı, kurum, yayın tarihi, kapsam, kısa özet ve kaynak linki saklansın.
- LLM özet üretebilir ama yayın öncesi editör onayı zorunlu olsun.

5) EXPERT CENTERS / UZMAN MERKEZLER
Amaç:
Dünya çapında ALS alanında çalışan güvenilir merkezleri göstermek.
Kaynak mantığı:
- ALS Association, NEALS, ENCALS, MDA ve akademik ALS merkezleri gibi kurumsal yapılar baz alınsın.
Kurallar:
- Öncelik bireysel “en iyi doktor” listeleri değil, resmi ALS merkezleri olsun.
- Merkez adı, kurum, ülke, şehir, iletişim bilgisi, resmi sayfa linki, merkez tipi gibi alanlar saklansın.
- Merkez açıklaması gerekiyorsa mümkün olduğunca kurumsal kaynaktan türetilsin.

6) DOCTORS / DOKTORLAR
Amaç:
ALS alanında çalışan doktorları ancak güvenli ve doğrulanabilir şekilde sunmak.
Kaynak mantığı:
- Doktor verisi yalnızca resmi merkez sayfaları, üniversite/hastane profilleri veya kurumsal profil sayfalarından alınsın.
Kurallar:
- Rastgele doktor listeleme siteleri kullanılmasın.
- “Dünyanın en iyi doktorları” gibi subjektif ranking mantığı kurulmasın.
- Doktor profili varsa merkezle ilişkili şekilde tutulsun.
- Yalnızca resmi profilde açıkça doğrulanabilen alanlar gösterilsin:
  - ad soyad
  - unvan
  - bağlı kurum
  - uzmanlık alanı
  - resmi profil linki
- Doktor verileri otomatik yayınlanmasın; editör onayı zorunlu olsun.

ERİŞİM MODELİ
Kaynakları 3 modda yönet:

1. API SOURCE
Resmi veya uygun programatik erişimi olan kaynaklar.
Buralarda mümkünse API kullan.

2. WEB INGEST SOURCE
Resmi API yoksa yalnızca resmi kurumsal sayfalardan kontrollü ingest yap.
Serbest scraping mantığı kurulmasın.
Parser logları ve hata takibi olsun.

3. MANUAL / CURATED VERIFICATION
Hassas içeriklerde editör doğrulaması zorunlu olsun.
Özellikle:
- doktor profilleri
- ilaç statüleri
- kılavuz özetleri
- merkez açıklamaları
doğrudan yayına çıkmasın.

VERİ MODELİ
Her şeyi tek tabloda toplama.
Ayrı veri tipleri kur:

- research_articles
- clinical_trials
- drugs
- guidelines
- expert_centers
- doctors
- source_registry
- ingestion_logs

Her içerikte ortak alanlar bulunsun:
- source_name
- source_mode
- source_type
- source_url
- external_id
- verification_tier
- raw_payload_json
- fetched_at
- last_verified_at
- status
- created_at
- updated_at

STATUS AKIŞI
Tüm hassas içerikler için yayın akışı zorunlu olsun:
- draft
- in_review
- approved
- rejected
- published

Dedup kuralları:
- research için PMID
- trials için NCT ID veya resmi trial id
- drugs için regulator-specific external key
- guidelines için canonical source_url veya kurumsal id
- centers/doctors için resmi profil URL veya kurumsal external id

GÜVEN / KANIT MODELİ
Her kayda verification_tier ver:

Tier 1
- resmi bilimsel, regülatör veya resmi kayıt kaynakları

Tier 2
- kurumsal ağlar, akademik merkezler, tanınmış ALS kuruluşları

Tier 3
- haber, blog, yorumlayıcı ikincil içerikler

Kurallar:
- Varsayılan kullanıcı deneyiminde Tier 1 ve Tier 2 içerikler öne çıkarılsın.
- Tier 3 ana bilgi kaynağı olmasın.
- Hassas tıbbi bilgi Tier 3 kaynağa dayandırılmasın.

RSS İLE İLGİLİ KESİN KARAR
Mevcut sistem RSS üzerinden ilerliyor olabilir.
Bu mimari artık ana çözüm olmayacak.

Yapılacaklar:
1. Mevcut RSS importer yapısını incele.
2. RSS ile gelen içerikleri kategori bazında ayır.
3. Her kategoriyi uygun resmi kaynağa map et.
4. Research verisini RSS’ten çıkar.
5. Trial verisini RSS’ten çıkar.
6. Drug approval mantığını RSS’ten çıkar.
7. Guideline mantığını RSS’ten çıkar.
8. Center/doctor mantığını RSS’ten çıkar.
9. Eski RSS parser/job bağımlılıklarını kaldır veya devre dışı bırak.
10. Yeni mimaride RSS ana kaynak olmasın.

İŞ AKIŞI
Yeni sistem şu akışla çalışsın:
1. Scheduler / cron çalışır.
2. Kaynak türüne göre uygun adaptör devreye girer.
3. Veri resmi kaynaktan çekilir.
4. Raw payload saklanır.
5. Normalize edilir.
6. external_id bazlı duplicate kontrolü yapılır.
7. Türkçe özet / kısa özet gerekiyorsa üretilir.
8. İçerik review queue’ya düşer.
9. Editör onayı sonrası yayımlanır.
10. Kullanıcıya her zaman kaynak ve doğrulama bilgisi gösterilir.

ADMIN PANEL
Admin panelinde şu filtreler ve alanlar olsun:
Filtreler:
- content type
- source_name
- source_mode
- verification_tier
- status
- date range

Ekranlarda gösterilecek alanlar:
- içerik başlığı
- kaynak kurumu
- kaynak linki
- external_id
- son çekilme tarihi
- son doğrulama tarihi
- ham veri
- Türkçe özet
- kısa özet
- yayın durumu

Aksiyonlar:
- yeniden çek
- yeniden özetle
- onayla
- reddet
- yayımla
- kaynağa git

MİMARİ KURAL
Bu platform “içerik toplayıcı” değil, “kaynak bazlı doğrulanmış ALS bilgi platformu” olarak davranmalı.
Teknik kararlar kolaylığa göre değil, kaynak otoritesine göre verilmeli.
Yani:
- API varsa kullan
- yoksa resmi kaynaktan kontrollü ingest yap
- hassas alanlarda editör doğrulaması uygula
- kullanıcıya kaynağı açıkça göster

TESLİMDE İSTEDİKLERİM
Bana eksiksiz olarak şunları ver:
- yeni source-trust-first mimari
- hangi içerik tipinin hangi kaynaktan beslendiği
- API source / web ingest source / manual curated source ayrımı
- veri modelleri
- migration dosyaları
- adapter / service sınıfları
- scheduler / cron yapısı
- dedup stratejisi
- review queue mantığı
- admin panel değişiklikleri
- mevcut RSS yapısından yeni mimariye geçiş planı
- kaldırılan veya devre dışı bırakılan eski dosyalar
- örnek uçtan uca veri akışı
- riskler ve fallback stratejisi

SON TALİMAT
Ben bu projeyi RSS tabanlı, her şeyi rastgele toplayan bir sistem olarak istemiyorum.
Benim istediğim şey:
doğru, güvenilir, globalde kabul görmüş, doğrulanabilir ve kaynak türüne göre ayrıştırılmış ALS bilgisini sunan bir platform.
Tüm refactor, veri modeli, scheduler, admin paneli ve ingest mantığını bu karara göre yeniden kur.