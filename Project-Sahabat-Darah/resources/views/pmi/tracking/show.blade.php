@extends('layouts.pmi-admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Tracking Pengiriman</h1>
                <p class="text-gray-600">Pasien: {{ $bloodRequest->patient_name }}</p>
            </div>
            <div class="space-x-2">
                <a href="{{ route('pmi.tracking.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
                @if($bloodRequest->delivery_status !== 'delivered')
                <button onclick="openUpdateModal({{ $bloodRequest->id }}, '{{ $bloodRequest->delivery_status ?? 'preparing' }}', '{{ $bloodRequest->tracking_notes }}')" 
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Update Status
                </button>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informasi Permintaan -->
        <div class="lg:col-span-2 bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Informasi Permintaan</h2>
            </div>
            <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $bloodRequest->patient_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $bloodRequest->blood_type }}{{ $bloodRequest->rhesus }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Kantong</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $bloodRequest->quantity }} kantong</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tingkat Urgensi</label>
                        <p class="mt-1">
                            @php
                                $urgencyColors = [
                                    'low' => 'bg-green-100 text-green-800',
                                    'medium' => 'bg-yellow-100 text-yellow-800',
                                    'high' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $urgencyColors[$bloodRequest->urgency] }}">
                                {{ ucfirst($bloodRequest->urgency) }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rumah Sakit</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $bloodRequest->rumahSakit->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat RS</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $bloodRequest->rumahSakit->address ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Permintaan</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $bloodRequest->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($bloodRequest->used_alternative_blood_type)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Golongan Darah Digunakan</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $bloodRequest->used_alternative_blood_type }}
                            </span>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Tracking -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Timeline Pengiriman</h2>
            </div>
            <div class="px-6 py-4">
                <!-- Timeline -->
                <div class="flow-root">
                    <ul class="-mb-8">
                        @php
                            $currentStatus = $bloodRequest->delivery_status ?? 'preparing';
                            $statuses = [
                                'preparing' => ['label' => 'Sedang Dipersiapkan', 'desc' => 'Darah sedang disiapkan untuk pengiriman'],
                                'shipped' => ['label' => 'Dalam Perjalanan', 'desc' => 'Darah sedang dalam perjalanan ke RS'],
                                'delivered' => ['label' => 'Telah Dikirim', 'desc' => 'Darah telah sampai di RS']
                            ];
                            $statusOrder = ['preparing', 'shipped', 'delivered'];
                            $currentIndex = array_search($currentStatus, $statusOrder);
                        @endphp
                        
                        @foreach($statusOrder as $index => $status)
                        <li>
                            <div class="relative pb-8">
                                @if($index < count($statusOrder) - 1)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 {{ $index < $currentIndex ? 'bg-green-500' : 'bg-gray-200' }}" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        @if($index <= $currentIndex)
                                        <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                            @if($index == $currentIndex)
                                            <div class="h-2 w-2 bg-white rounded-full animate-pulse"></div>
                                            @else
                                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            @endif
                                        </span>
                                        @else
                                        <span class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white">
                                            <span class="h-2 w-2 bg-white rounded-full"></span>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $statuses[$status]['label'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $statuses[$status]['desc'] }}</p>
                                            @if($index == $currentIndex)
                                            <p class="text-xs text-green-600 font-medium mt-1">Status saat ini</p>
                                            @endif
                                            @if($index <= $currentIndex)
                                            <p class="text-xs text-gray-400 mt-1">{{ $bloodRequest->updated_at->format('d/m/Y H:i') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Catatan Tracking -->
                @if($bloodRequest->tracking_notes)
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h4 class="text-sm font-medium text-blue-900 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        Catatan Pengiriman
                    </h4>
                    <p class="text-sm text-blue-800">{{ $bloodRequest->tracking_notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Status (sama seperti di index) -->
<div id="updateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status Pengiriman</h3>
            <form id="updateForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="delivery_status" class="block text-sm font-medium text-gray-700 mb-2">Status Pengiriman</label>
                    <select id="delivery_status" name="delivery_status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="preparing">Sedang Dipersiapkan</option>
                        <option value="shipped">Dalam Perjalanan</option>
                        <option value="delivered">Telah Dikirim</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="tracking_notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                    <textarea id="tracking_notes" name="tracking_notes" rows="3" 
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                              placeholder="Tambahkan catatan pengiriman..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeUpdateModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openUpdateModal(requestId, currentStatus, currentNotes) {
    document.getElementById('updateModal').classList.remove('hidden');
    document.getElementById('updateForm').action = `/pmi/tracking/${requestId}/update`;
    document.getElementById('delivery_status').value = currentStatus;
    document.getElementById('tracking_notes').value = currentNotes || '';
}

function closeUpdateModal() {
    document.getElementById('updateModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('updateModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUpdateModal();
    }
});
</script>
@endsection