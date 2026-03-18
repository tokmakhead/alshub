# ALS Hub — Adım Adım Canlıya Alım (Deploy) Rehberi

Plesk sunucunuza sorunsuz bir kurulum yapmak için aşağıdaki adımları sırayla takip edin.

## 📜 Hazırlık (Lokalde)
1.  **Kodun Gönderilmesi:** Tüm değişikliklerinizi ana branch'e (main) commit edin ve GitHub/GitLab deponuza pushlayın.
2.  **Standalone Yapılandırması:** `apps/web/next.config.ts` içinde `output: 'standalone'` ayarının olduğundan emin olun.

## 🚀 Sunucu Kurulumu (Plesk Panel)
1.  **Git Entegrasyonu:** Plesk üzerinde "Git" eklentisini kullanarak deponuzu `/httpdocs` klasörüne klonlayın.
2.  **Node.js Ayarı:** 
    - Uygulama klasörü: `/httpdocs`
    - Startup File: `apps/web/server.js` (Build sonrası standalone klasöründeki dosyadır)
    - Mode: `production`
3.  **Environment Variables:** Plesk > Node.js > Environment Variables kısmına `.env.example` içindeki tüm anahtarları ve değerlerini (DATABASE_URL, GEMINI_API_KEY, NEXTAUTH_SECRET vb.) ekleyin.

## 🛠️ Derleme ve Uzak Kurulum (SSH veya Plesk Terminal)
SSH üzerinden proje kök dizinine gidin ve şu komutları çalıştırın:
1.  `npm install` (Tüm bağımlılıkları yükleyin)
2.  `npm run build` (Next.js projesini build edin)
3.  `./scripts/plesk-post-deploy.sh` (Veritabanı migration ve seed işlemlerini çalıştırın)

## 🔄 Otomatik Güncelleme (Cron)
Plesk > Scheduled Tasks kısmına gidin:
- **Type:** Run a PHP script / Run a URL
- **URL:** `https://siteniz.com/api/cron/sync?secret=[SİZİN_CRON_SECRET_DEĞERİNİZ]`
- **Zaman:** Günlük (Daily) - Gece 04:00

## ✅ Kontrol Listesi
- [ ] `/api/health` endpoint'inden "status: ok" yanıtı alınıyor mu?
- [ ] Admin paneline (`/login`) giriş yapılabiliyor mu?
- [ ] Ana sayfadaki arama motoru çalışıyor mu?
- [ ] `.env` dosyasındaki `NEXT_PUBLIC_SITE_URL` doğru mu?

Daha detaylı bilgi için: `apps/web/PLESK_DEPLOY.md` dosyasını inceleyebilirsiniz.
