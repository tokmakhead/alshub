Çok önemli cevap kuralı:
- Büyük fazları tek yanıtta aşırı büyütme.
- Ben onay vermeden bir sonraki fazla devam etme.
- Ama her fazı kendi içinde tamamlanmış, uygulanabilir ve net ver.
- Kod verirken eksik bırakma.
- Çalışmayacak varsayımsal kod verme.
- Her faz sonunda “Bu adımda sadece istenen kapsamı yaptım” diye kontrol et.

FAZ 6 — Proje iskeleti
Kod üret.
Şunları kur:
- Next.js App Router
- TypeScript
- MySQL/MariaDB uyumlu ORM
- environment validation
- config sistemi
- public/admin/api/scripts/lib/services/repositories/types/utils/search/ai/sync klasörleri
- health endpoint
- merkezi hata helper yapısı
- sade ama sağlam iskelet

FAZ 7 — Environment/config
Kod üret.
Şunları oluştur:
- .env.example
- env validation
- runtime config helper
- development/staging/production ayrımı
- gelecekte domain değişiminde sorun çıkarmayacak config mantığı

Beklenen env değişkenleri:
- DATABASE_URL
- APP_ENV
- NEXT_PUBLIC_SITE_URL
- NEXT_PUBLIC_APP_NAME
- CRON_SECRET
- SESSION_SECRET
- GEMINI_API_KEY
- AI_DEFAULT_PROVIDER
- CLINICALTRIALS_BASE_URL
- PUBMED_BASE_URL
- OPENFDA_BASE_URL
- DAILYMED_BASE_URL
- DRUGSFDA_BASE_URL
- ORANGEBOOK_SOURCE_PATH
- LOG_LEVEL

FAZ 8 — ORM schema
Kod üret.
- ilişkileri temiz kur
- enum’ları tanımla
- index ve unique’leri unutma
- editorial/versioning/source tracking alanlarını koru
- publication full text tutma, metadata + abstract + editorial summary mantığını koru

FAZ 9 — Database bootstrap
Kod üret.
- ORM client helper
- db bağlantı dosyası
- basic seed
- role seed
- source seed
- admin user seed mantığı

FAZ 10 — Auth ve roles
Kod üret.
- normal admin login
- editor role altyapısı
- admin route guard
- editor permission helper
- logout
- sade ve güvenli auth yaklaşımı
- public kullanıcı sistemi olmayacak