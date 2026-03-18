# PLESK Deployment Guide - ALS Hub

## 1. Node.js Ayarları
Plesk üzerinde **Node.js** eklentisini açın ve şu ayarları yapın:
- **Node.js Version:** 20.x or higher
- **Package Manager:** npm
- **Document Root:** `/httpdocs` (veya `apps/web/public`)
- **Application Mode:** production
- **Application Startup File:** `server.js` (Standalone build sonrası)

## 2. Ortam Değişkenleri (.env)
Plesk "Environment Variables" kısmına `.env.example` içindeki tüm değerleri girin.
**Kritik:** `DATABASE_URL` MariaDB soketine veya hostuna göre güncellenmelidir.

## 3. Build & Standalone
Next.js `standalone` modunda build edilmelidir. `apps/web/next.config.ts` içinde:
```typescript
{
  output: 'standalone'
}
```
Build sonrası `apps/web/.next/standalone` klasörü oluşur.

## 4. Post-Deploy Komutları
Her deploy sonrası şu komutlar çalıştırılmalıdır (Plesk SSH üzerinden):
```bash
./scripts/plesk-post-deploy.sh
```

## 5. Cron Setup
Plesk "Scheduled Tasks" kısmında:
- **Task Type:** Run a URL
- **URL:** `https://siteniz.com/api/cron/sync?secret=SİZİN_CRON_SECRET`
- **Schedule:** Her sabah 04:00 (Öneri)
