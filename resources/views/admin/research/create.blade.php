@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Yeni Araştırma Ekle (PubMed)</h6>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{ route('admin.research.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="pmid">PubMed ID (PMID)</label>
                            <input type="text" name="pmid" class="form-control" placeholder="Örn: 41877246" required>
                            <small class="text-muted">Sistem, girdiğiniz PMID numarasına ait başlık, özet ve yazar bilgilerini otomatik çekecektir.</small>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Veriyi Çek ve Taslak Oluştur</button>
                            <a href="{{ route('admin.research.index') }}" class="btn btn-secondary">İptal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
