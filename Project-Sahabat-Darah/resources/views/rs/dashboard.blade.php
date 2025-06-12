@extends('layouts.rs-admin')

@section('title', 'Dashboard RS')
@section('header', 'Dashboard Rumah Sakit')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Permintaan</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $totalRequests ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Permintaan Diterima</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $acceptedRequests ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Konfirmasi</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $pendingRequests ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Requests -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Permintaan Terbaru</h3>
                <a href="{{ route('rs.blood-requests.create') }}" class="text-sm text-red-600 hover:text-red-800">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentRequests as $request)
                <div class="px-4 py-4 sm:px-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($request->status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $request->patient_name }}</div>
                                <div class="text-sm text-gray-500">Golongan Darah: {{ $request->blood_type }}{{ $request->rhesus }}</div>
                            </div>
                        </div>
                        <div class="text-right text-sm text-gray-500">
                            {{ $request->request_date->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-4 py-5 text-center text-gray-500">
                    Belum ada permintaan darah
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="space-y-6">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Aksi Cepat</h3>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('rs.blood-requests.create') }}" 
                        class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Permintaan Baru
                    </a>
                    <a href="{{ route('rs.notifications.index') }}" 
                        class="flex items-center justify-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        Lihat Notifikasi
                        @if($unreadNotifications > 0)
                            <span class="ml-2 bg-red-100 text-red-600 rounded-full px-2 py-0.5 text-xs font-medium">
                                {{ $unreadNotifications }}
                            </span>
                        @endif
                    </a>
                    
                    <a href="{{ route('rs.pmi-locations.index') }}" 
                        class="flex items-center justify-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Cari PMI
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form WhatsApp untuk Rumah Sakit -->
<div class="mt-10 max-w-2xl mx-auto bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-5 bg-gradient-to-r from-green-600 to-green-700">
        <h3 class="text-lg leading-6 font-medium text-white">Hubungi PMI via WhatsApp</h3>
        <p class="text-sm text-green-100 mt-1">Isi form berikut untuk menghubungi tim PMI secara langsung melalui WhatsApp.</p>
    </div>
    <div class="p-6 space-y-6">
        <form id="waFormRS" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="namaRS" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" id="namaRS" name="nama" 
                        class="w-full rounded-md border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors" 
                        placeholder="  Masukkan nama Anda" required>
                </div>
                <div>
                    <label for="emailRS" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="emailRS" name="email" 
                        class="w-full rounded-md border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors" 
                        placeholder="  Masukkan email Rumah Sakit" required>
                </div>
            </div>
            
            <div>
                <label for="instagramRS" class="block text-sm font-medium text-gray-700 mb-1">
                    Instagram <span class="text-gray-400 text-xs">(opsional)</span>
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">@</span>
                    </div>
                    <input type="text" id="instagramRS" name="instagram" 
                        class="pl-7 w-full rounded-md border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors" 
                        placeholder="username Rumah Sakit">
                </div>
            </div>

            <div>
                <label for="pesanRS" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                <textarea id="pesanRS" name="pesan" rows="4" 
                    class="w-full rounded-md border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors" 
                    placeholder="Tulis pesan Anda di sini..." required></textarea>
            </div>

            <div class="flex flex-col space-y-4">
                <button type="submit" 
                    class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M16 3C9.373 3 4 8.373 4 15c0 2.637.86 5.08 2.36 7.09L4 29l7.18-2.31C13.09 27.14 14.52 27.5 16 27.5c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 22c-1.32 0-2.61-.26-3.81-.77l-.27-.12-4.27 1.37 1.4-4.13-.18-.28C7.26 18.61 7 17.32 7 16c0-5.06 4.13-9.19 9.19-9.19S25.38 10.94 25.38 16c0 5.06-4.13 9.19-9.19 9.19zm5.09-6.41c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.25-1.41-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.32.42-.48.14-.16.18-.28.28-.46.09-.18.05-.34-.02-.48-.07-.14-.61-1.47-.84-2.01-.22-.54-.44-.47-.61-.48-.16-.01-.34-.01-.52-.01-.18 0-.48.07-.73.34-.25.27-.97.95-.97 2.32 0 1.37.99 2.7 1.13 2.89.14.18 1.95 2.98 4.74 4.06.66.23 1.18.37 1.58.47.66.17 1.26.15 1.73.09.53-.08 1.65-.67 1.89-1.32.23-.65.23-1.21.16-1.32-.07-.11-.25-.18-.53-.32z"/>
                    </svg>
                    Kirim via WhatsApp
                </button>

                <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                    <svg class="h-5 w-5 text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.974-.974-1.246-2.241-1.308-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608.974-.974 2.241-1.246 3.608-1.308C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.013 7.052.072 5.771.131 4.659.363 3.678 1.344 2.697 2.325 2.465 3.437 2.406 4.718 2.347 5.998 2.334 6.407 2.334 12c0 5.593.013 6.002.072 7.282.059 1.281.291 2.393 1.272 3.374.981.981 2.093 1.213 3.374 1.272C8.332 23.987 8.741 24 12 24s3.668-.013 4.948-.072c1.281-.059 2.393-.291 3.374-1.272.981-.981 1.213-2.093 1.272-3.374.059-1.28.072-1.689.072-7.282 0-5.593-.013-6.002-.072-7.282-.059-1.281-.291-2.393-1.272-3.374C19.341.363 18.229.131 16.948.072 15.668.013 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
                    </svg>
                    <a href="https://instagram.com/donordarahjakarta" target="_blank" class="text-pink-600 hover:text-pink-700 transition-colors">@donordarahjakarta ('Instagram Resmi PMI')</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('waFormRS');
    if(form){
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const nama = document.getElementById('namaRS').value.trim();
            const email = document.getElementById('emailRS').value.trim();
            const ig = document.getElementById('instagramRS').value.trim();
            const pesan = document.getElementById('pesanRS').value.trim();
            if (!nama || !email || !pesan) {
                alert('Semua kolom wajib diisi kecuali Instagram!');
                return;
            }
            const nomorWa = '6289521006019';
            let pesanWa = `Halo, saya ${nama}%0A%0A`;
            pesanWa += `Email: ${email}%0A`;
            if(ig) pesanWa += `Instagram: ${ig}%0A`;
            pesanWa += `%0APesan:%0A${pesan}`;
            const url = `https://wa.me/${nomorWa}?text=${pesanWa}`;
            window.open(url, '_blank');
        });
    }
});
</script>
@endsection 