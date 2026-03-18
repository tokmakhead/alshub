Çok önemli cevap kuralı:
- Büyük fazları tek yanıtta aşırı büyütme.
- Ben onay vermeden bir sonraki fazla devam etme.
- Ama her fazı kendi içinde tamamlanmış, uygulanabilir ve net ver.
- Kod verirken eksik bırakma.
- Çalışmayacak varsayımsal kod verme.
- Her faz sonunda “Bu adımda sadece istenen kapsamı yaptım” diye kontrol et.

FAZ 11 — Connector contract
Kod üret.
Aşağıdakiler için ortak contract/interface kur:
- ClinicalTrialsConnector
- PubMedConnector
- OpenFdaConnector
- DailyMedConnector
- DrugsFdaConnector
- OrangeBookConnector

Her biri için:
- fetchRaw
- normalize
- validate
- upsert
- sync

FAZ 12 — ClinicalTrials entegrasyonu
Kod üret.
- API client
- type’lar
- normalize
- validate
- upsert
- sync script
- loglama
- retry/timeout
- test akışı

FAZ 13 — openFDA entegrasyonu
Kod üret.
- client
- response types
- normalization
- güvenli alan seçimi
- upsert
- sync
- traceability

FAZ 14 — DailyMed entegrasyonu
Kod üret.
- client
- type’lar
- normalization
- SPL/setid mantığı
- drug eşleme
- merge strategy
- source priority

FAZ 15 — Drugs@FDA + Orange Book entegrasyonu
Kod üret.
- approval katmanı
- official verification mantığı
- normalize
- upsert
- drug eşleme
- traceability

FAZ 16 — PubMed entegrasyonu
Kod üret.
- client
- arama
- detay
- PMID kayıtları
- author parsing
- publication type parsing
- metadata normalize
- editorial summary altyapısı