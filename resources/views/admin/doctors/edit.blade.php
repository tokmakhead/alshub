<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($doctor) ? 'Uzman Düzenle' : 'Yeni Uzman Ekle' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ isset($doctor) ? route('admin.doctors.update', $doctor) : route('admin.doctors.store') }}" method="POST">
                        @csrf
                        @if(isset($doctor)) @method('PUT') @endif

                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ad</label>
                                    <input type="text" name="first_name" value="{{ $doctor->first_name ?? old('first_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Soyad</label>
                                    <input type="text" name="last_name" value="{{ $doctor->last_name ?? old('last_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Unvan (Prof, Doç, Dr vb.)</label>
                                    <input type="text" name="title" value="{{ $doctor->title ?? old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Bağlı Olduğu Merkez</label>
                                    <select name="expert_center_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">Merkez Seçin...</option>
                                        @foreach($centers as $center)
                                            <option value="{{ $center->id }}" {{ (isset($doctor) && $doctor->expert_center_id == $center->id) || old('expert_center_id') == $center->id ? 'selected' : '' }}>{{ $center->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Uzmanlık Alanı</label>
                                <input type="text" name="specialty" value="{{ $doctor->specialty ?? old('specialty') }}" placeholder="örn: Nöroloji, ALS Genetiği" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">ORCID ID</label>
                                <input type="text" name="orcid_id" value="{{ $doctor->orcid_id ?? old('orcid_id') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Biyografi / Notlar</label>
                                <textarea name="biography" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $doctor->biography ?? old('biography') }}</textarea>
                            </div>

                            <div class="flex items-center">
                                <input type="hidden" name="is_verified" value="0">
                                <input type="checkbox" name="is_verified" value="1" {{ ($doctor->is_verified ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <label class="ml-2 block text-sm text-gray-900 font-bold">Doğrulanmış Uzman Profil</label>
                            </div>

                            <div class="pt-4 border-t flex justify-end gap-3">
                                <a href="{{ route('admin.doctors.index') }}" class="px-4 py-2 border rounded text-sm hover:bg-gray-50">İptal</a>
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded text-sm font-bold hover:bg-blue-700">Kaydet</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
