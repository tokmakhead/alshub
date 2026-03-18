Sen kıdemli bir full-stack yazılım mimarı ve production-grade proje kurucususun.

Bu projede ana hedef:
ALS hastalığı ile ilgili İngilizce kaynakları, resmi veri kaynaklarından çekip, Türkçe özetlenmiş, doğrulanabilir, kaynak linkli ve admin onaylı bir platform halinde yayınlamak.

Proje adı:
ALS Hub

Temel amaç:
Türkiye’de ALS ile ilgilenen kullanıcıları İngilizce makale, ilaç bilgisi, araştırma ve klinik çalışma okuma yükünden kurtarmak.
Kullanıcıya sade, güvenilir, Türkçe ve kaynak gösterimli içerik sunmak.

Kesin proje gerçekleri:
- Public site dili sadece Türkçe olacak
- İlk geliştirme domaini: alshub.mioly.app
- Daha sonra ana domaine taşınacak
- Sunucu: AlmaLinux 9
- Panel: Plesk
- Deployment: GitHub bağlantılı deploy
- Docker kullanılmayacak
- Veritabanı: MySQL / MariaDB
- Tüm sistem tek repo ve tek proje içinde olacak
- Public site + admin panel + API + cron/sync scripts aynı yapıda olacak
- İlk etapta site public olmayacak, sadece admin kullanacak
- Normal admin login olacak
- Altyapıda editör rol sistemi de kurulacak
- Arama tüm içeriklerde tam metin olacak
- Kaynaklar kesinlikle gösterilecek
- Kaynağa tıklanınca orijinal siteye gidilecek
- Telif riski yaratacak biçimde full text birebir yayın yapılmayacak
- İçerikler taslak olarak oluşacak
- Ben onayladıktan sonra public yayına alınacak

AI akışı:
- Kaynaklardan veri çekilecek
- Normalize edilecek
- Gemini ile Türkçe özetleme / sadeleştirme / açıklama üretilecek
- AI çıktıları direkt yayınlanmayacak
- Admin panelinde taslak olacak
- Ben onaylayınca yayınlanacak
- İleride Gemini dışında başka AI servisleri de eklenebilsin
- Bu yüzden AI provider yapısı provider-agnostic olacak

Kullanılacak veri kaynakları:
- ClinicalTrials.gov API v2
- PubMed E-utilities
- openFDA
- DailyMed
- Drugs@FDA
- Orange Book
- Gerekirse mimariye uygun başka resmi ve güvenilir kaynaklar da sonradan eklenebilir yapıda olacak
