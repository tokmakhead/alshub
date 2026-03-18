FAZ 1 — Teknik mimari
- en uygun teknoloji stack
- neden bu stack
- neden riskli alternatifler seçilmedi
- tek repo mimarisi
- klasör yapısı
- veri akışı
- admin/editör/yayın akışı
- tam metin arama yaklaşımı
- subdomain’den ana domaine sorunsuz geçiş için mimari kararlar
- Plesk uyumlu deployment yaklaşımı

FAZ 2 — MVP sınırı
- V1’de kesin olacaklar
- V1’de olmayacaklar
- neden dışarıda bırakıldıkları
- V1 → V1.1 → V2 yol haritası

FAZ 3 — Veri modeli planı
Aşağıdaki ana tabloları değerlendir, gerekiyorsa sadeleştir ama mantığı bozma:
- users
- roles
- user_roles
- sources
- source_records
- drugs
- drug_approvals
- drug_labels
- drug_sources
- trials
- trial_locations
- trial_sources
- publications
- publication_authors
- publication_sources
- editorial_contents
- editorial_versions
- translation_jobs
- ai_providers
- ai_jobs
- sync_jobs
- sync_runs
- import_logs
- search_index_queue
- audit_logs
- disclaimers
- source_links

Her tablo için:
- amaç
- kolonlar
- tipler
- ilişkiler
- unique/index mantığı
- traceability alanları
- yayın statüleri
- AI ve editorial ayrımı
- full text aramaya etkisi

FAZ 4 — Kaynak entegrasyon mimarisi
Her kaynak için:
- ne çekilecek
- nasıl normalize edilecek
- hangi alanlar public’e uygun
- hangi alanlar admin’de kalmalı
- retry/timeout/fallback
- source traceability
- cross-check mantığı
- telif/lisans riski olan alanlar

FAZ 5 — AI provider mimarisi
- Gemini ilk provider olacak
- ileride farklı provider eklenebilecek
- abstraction tasarla
- prompt template sistemi kur
- content type bazlı AI generation mantığı kur
- draft generation + admin approval mantığı kur
- ai_jobs ve translation_jobs akışını tasarla