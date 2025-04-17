@extends('layouts.rs-admin')

@section('title', 'Riwayat Permintaan Darah')
@section('header', 'Riwayat Permintaan Darah')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Permintaan Darah</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Semua riwayat permintaan darah yang telah dibuat
                </p>
            </div>
            <a href="{{ route('rs.blood-requests.create') }}" 
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Permintaan Baru
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-gray-50 border-b border-gray-200 px-4 py-4 sm:px-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4">
            <div class="flex-1">
                <label for="search" class="sr-only">Cari</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" id="search" 
                        class="focus:ring-red-500 focus:border-red-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" 
                        placeholder="Cari berdasarkan nama pasien...">
                </div>
            </div>
            <div class="mt-3 sm:mt-0 flex items-center space-x-4">
                <select id="status" name="status" 
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="accepted">Diterima</option>
                    <option value="rejected">Ditolak</option>
                </select>
                <select id="blood_type" name="blood_type" 
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md">
                    <option value="">Semua Golongan</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama Pasien
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Golongan Darah
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal Permintaan
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bloodRequests as $request)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $request->patient_name }}</div>
                        <div class="text-sm text-gray-500">{{ $request->hospital_name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $request->blood_type }}{{ $request->rhesus }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $request->request_date->format('d/m/Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $request->request_date->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($request->status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($request->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <a href="{{ route('rs.blood-requests.show', $request) }}" 
                            class="text-red-600 hover:text-red-900 font-medium">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        Tidak ada permintaan darah
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bloodRequests->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $bloodRequests->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const statusSelect = document.getElementById('status');
    const bloodTypeSelect = document.getElementById('blood_type');
    let timeoutId;

    function applyFilters() {
        const searchQuery = searchInput.value;
        const status = statusSelect.value;
        const bloodType = bloodTypeSelect.value;

        let url = new URL(window.location.href);
        url.searchParams.set('search', searchQuery);
        url.searchParams.set('status', status);
        url.searchParams.set('blood_type', bloodType);

        window.location.href = url.toString();
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(applyFilters, 500);
    });

    statusSelect.addEventListener('change', applyFilters);
    bloodTypeSelect.addEventListener('change', applyFilters);
});
</script>
@endpush 