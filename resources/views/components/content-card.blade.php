@props(['item'])

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all group flex flex-col h-full relative">
    @php
        $modelClass = get_class($item);
        $typeStr = $item->type ?? '';
        $isTrial = $modelClass === 'App\Models\ClinicalTrial' || $typeStr === 'trial';
        $isDrug = $modelClass === 'App\Models\Drug' || $typeStr === 'drug';
    @endphp

    @if($isTrial)
        @php
            $rawStatus = '';
            if ($modelClass === 'App\Models\ClinicalTrial') {
                $rawStatus = $item->raw_payload_json['protocolSection']['statusModule']['overallStatus'] ?? '';
            } else if (!empty($item->extra_info)) {
                $extra = is_string($item->extra_info) ? json_decode($item->extra_info, true) : $item->extra_info;
                $rawStatus = $extra['recruitment_status'] ?? '';
            }

            $statusConfig = match(strtolower($rawStatus)) {
                'recruiting' => ['label' => 'Kayıt Devam Ediyor', 'color' => 'bg-green-500 text-white'],
                'active, not recruiting' => ['label' => 'Aktif, Kayıt Kapalı', 'color' => 'bg-blue-500 text-white'],
                'not yet recruiting' => ['label' => 'Henüz Başlamadı', 'color' => 'bg-indigo-500 text-white'],
                'completed' => ['label' => 'Tamamlandı', 'color' => 'bg-gray-500 text-white'],
                'withdrawn' => ['label' => 'Geri Çekildi', 'color' => 'bg-red-500 text-white'],
                'terminated' => ['label' => 'Durduruldu', 'color' => 'bg-red-600 text-white'],
                'suspended' => ['label' => 'Askıya Alındı', 'color' => 'bg-yellow-500 text-white'],
                'unknown status' => ['label' => 'Durum Belirsiz', 'color' => 'bg-gray-400 text-white'],
                'unknown' => ['label' => 'Durum Belirsiz', 'color' => 'bg-gray-400 text-white'],
                default => ['label' => $rawStatus ?: 'Durum Belirsiz', 'color' => 'bg-gray-400 text-white']
            };
        @endphp
        <div class="{{ $statusConfig['color'] }} text-[10px] font-black uppercase py-1 px-4 text-center tracking-widest">
            {{ $statusConfig['label'] }}
        </div>
    @elseif($isDrug)
        @php
            $isApproved = $modelClass === 'App\Models\Drug' ? $item->is_approved_fda : (str_contains(strtolower($item->extra_info ?? ''), 'approved'));
            $drugStatus = $isApproved ? 'Onaylı İlaç' : 'Araştırma Aşamasında';
            $drugColor = $isApproved ? 'bg-purple-600 text-white' : 'bg-purple-400 text-white';
        @endphp
         <div class="{{ $drugColor }} text-[10px] font-black uppercase py-1 px-4 text-center tracking-widest">
            {{ $drugStatus }}
        </div>
    @elseif($modelClass === 'App\Models\ResearchArticle' || $typeStr === 'research' || $typeStr === 'publication')
        <div class="bg-teal-600 text-white text-[10px] font-black uppercase py-1 px-4 text-center tracking-widest">
            BİLİMSEL ARAŞTIRMA
        </div>
    @elseif($modelClass === 'App\Models\Guideline' || $typeStr === 'guideline')
         <div class="bg-blue-600 text-white text-[10px] font-black uppercase py-1 px-4 text-center tracking-widest">
            REHBER
        </div>
    @else
        <div class="bg-orange-500 text-white text-[10px] font-black uppercase py-1 px-4 text-center tracking-widest">
            BİLGİ PAYLAŞIMI
        </div>
    @endif

    @php
        // Dinamik Orijinal Tarih Çıkarımı (Favoring publication/original dates)
        $displayDate = null;

        try {
            if ($modelClass === 'App\Models\ResearchArticle') {
                 $displayDate = $item->publication_date;
            } elseif ($modelClass === 'App\Models\ClinicalTrial') {
                $raw = is_string($item->raw_payload_json) ? json_decode($item->raw_payload_json, true) : ($item->raw_payload_json ?? []);
                $rawDate = $raw['protocolSection']['statusModule']['lastUpdateSubmitDate'] ?? 
                           $raw['protocolSection']['statusModule']['studyFirstPostDateStruct']['date'] ?? null;
                if ($rawDate) $displayDate = \Carbon\Carbon::parse($rawDate);
            } elseif ($modelClass === 'App\Models\Drug') {
                $usStatus = $item->regionalStatuses->where('region', 'US')->first();
                if ($usStatus) {
                    $drugRaw = is_string($usStatus->raw_payload_json) ? json_decode($usStatus->raw_payload_json, true) : ($usStatus->raw_payload_json ?? []);
                    $effTime = $drugRaw['effective_time'] ?? null;
                    if ($effTime && strlen($effTime) == 8) {
                        $strDate = substr($effTime, 0, 4) . '-' . substr($effTime, 4, 2) . '-' . substr($effTime, 6, 2);
                        $displayDate = \Carbon\Carbon::parse($strDate);
                    }
                }
            } elseif ($modelClass === 'App\Models\Guideline') {
                $displayDate = $item->publication_date;
            } elseif (isset($item->source_published_at)) {
                $displayDate = $item->source_published_at;
            }
        } catch (\Exception $e) {}

        $finalDate = $displayDate ?? $item->created_at;

        // Kesin Türkçe Tarih Çevirisi
        $monthsTr = [
            'January' => 'Ocak', 'February' => 'Şubat', 'March' => 'Mart', 'April' => 'Nisan', 
            'May' => 'Mayıs', 'June' => 'Haziran', 'July' => 'Temmuz', 'August' => 'Ağustos', 
            'September' => 'Eylül', 'October' => 'Ekim', 'November' => 'Kasım', 'December' => 'Aralık'
        ];
        $dateStr = $finalDate->format('d F Y');
        $dateStr = strtr($dateStr, $monthsTr);

        $routeType = match($modelClass) {
            'App\Models\ResearchArticle' => 'research',
            'App\Models\ClinicalTrial' => 'trial',
            'App\Models\Drug' => 'drug',
            'App\Models\Guideline' => 'guideline',
            default => ($typeStr === 'publication' ? 'research' : ($typeStr ?: 'content'))
        };
        $route = route('content.show', ['type' => $routeType, 'slug' => $item->slug]);
    @endphp

    <div class="p-8 flex flex-col flex-grow">
        <div class="flex items-center gap-2 mb-4">
            <span class="text-xs font-bold uppercase tracking-widest text-primary bg-blue-50 px-3 py-1 rounded-full">
                @if($modelClass === 'App\Models\ResearchArticle' || $typeStr === 'research' || $typeStr === 'publication')
                    Araştırma
                @elseif($isTrial)
                    Klinik Çalışma
                @elseif($isDrug)
                    İlaç 
                @elseif($modelClass === 'App\Models\Guideline' || $typeStr === 'guideline')
                    Rehber
                @else
                    Haber
                @endif
            </span>

            <span class="text-xs text-gray-400 font-medium ml-auto" title="Orijinal Kaynak Tarihi">
                {{ $dateStr }}
            </span>
        </div>
        
        <h3 class="text-xl font-bold text-gray-900 mb-4 line-clamp-2 group-hover:text-primary transition">
            <a href="{{ $route }}">{{ $item->display_title }}</a>
        </h3>
        <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-3">
            {{ Str::limit(strip_tags($item->display_summary), 150) }}
        </p>
        <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
            <span class="text-xs text-gray-400">Kaynak: <span class="font-bold text-gray-600">{{ $item->source_label ?? 'ALSHub' }}</span></span>
            <a href="{{ $route }}" class="text-primary font-bold text-sm">Detaylar</a>
        </div>
    </div>
</div>
