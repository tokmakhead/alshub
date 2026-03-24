@extends('frontend.layout')

@section('title', 'Hakkımızda - ALSHub')

@section('content')
    <article class="max-w-4xl mx-auto px-4 py-20 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-10 tracking-tight">Hakkımızda</h1>
        
        <div class="prose prose-blue max-w-none text-gray-600 leading-relaxed space-y-8">
            <p class="text-lg">
                ALSHub, ALS hastalığı ile yaşayan bireyler, aileleri ve konuya ilgi duyan araştırmacılar için güvenilir bir bilgi kaynağı olma amacıyla kurulmuş kar amacı gütmeyen bir platformdur.
            </p>

            <h2 class="text-2xl font-bold text-gray-900">Misyonumuz</h2>
            <p>
                Dünyadaki bilimsel gelişmeleri, klinik çalışmaları ve yeni ilaç araştırmalarını yakından takip ederek; bu karmaşık tıbbi süreçleri herkesin anlayabileceği sade ve duru bir Türkçe ile sunmaktır. 
            </p>

            <h2 class="text-2xl font-bold text-gray-900">Neden ALSHub?</h2>
            <p>
                İnternet dünyasında tıbbi konularda çok sayıda bilgi kirliliği bulunmaktadır. ALSHub olarak biz, her içeriğimizi güvenilir kaynaklara (PubMed, ClinicalTrials.gov, ALS Association vb.) dayandırıyor ve orijinal bağlantıları her zaman sizlerle paylaşıyoruz. Amacımız, teknik bir şov yapmak değil, bilgiye erişimi demokratikleştirmektir.
            </p>

            <div class="bg-gray-50 p-8 rounded-3xl border border-gray-100 flex items-center gap-6 mt-12">
                <div class="bg-primary text-white p-4 rounded-2xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium leading-relaxed italic text-gray-500">
                        "Doğru bilgi, belirsizlikle mücadeledeki en güçlü silahtır."
                    </p>
                </div>
            </div>
        </div>
    </article>
@endsection
