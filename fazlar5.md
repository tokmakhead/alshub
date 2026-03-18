Çok önemli cevap kuralı:
- Büyük fazları tek yanıtta aşırı büyütme.
- Ben onay vermeden bir sonraki fazla devam etme.
- Ama her fazı kendi içinde tamamlanmış, uygulanabilir ve net ver.
- Kod verirken eksik bırakma.
- Çalışmayacak varsayımsal kod verme.
- Her faz sonunda “Bu adımda sadece istenen kapsamı yaptım” diye kontrol et.

FAZ 22 — Cron / sync orkestrasyonu
Kod üret.
- manual sync endpoint
- cron trigger endpoint
- source bazlı çalışma
- full sync / incremental sync
- retry
- timeout
- çakışan job önleme
- AI generation sonrası reindex

FAZ 23 — Plesk deploy planı
Kod + açıklama üret.
- build/start stratejisi
- Plesk Node.js ayarı
- env yönetimi
- post-deploy komutları
- migration
- seed
- cron kurulumu
- log/debug yaklaşımı
- subdomain’den ana domaine geçişte değişmeyecek yapı taşları

FAZ 24 — Son teknik denetim
En sonda denetim raporu ver:
- eksik import
- path sorunları
- type sorunları
- env eksikleri
- veri modeli çelişkileri
- sync kırılma riskleri
- AI akışı riskleri
- search riskleri
- Plesk riskleri
- MariaDB riskleri
- telif riski
- production checklist
- deploy checklist
- ilk hafta izlenecek log/check listesi