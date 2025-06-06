@extends('layouts.pmi-admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Kelola Tracking Pengiriman</h1>
        <p class="text-gray-600">Update dan monitor status pengiriman darah ke rumah sakit</p>
    </div>

    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Daftar Pengiriman</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pasien & RS
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Golongan Darah
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status Pengiriman
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Urgensi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bloodRequests as $request)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $request->patient_name }}</div>
                            <div class="text-sm text-gray-500">{{ $request->rumahSakit->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $request->blood_type }}{{ $request->rhesus }} ({{ $request->quantity }} kantong)
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'preparing' => 'bg-yellow-100 text-yellow-800',
                                    'shipped' => 'bg-blue-100 text-blue-800',
                                    'delivered' => 'bg-green-100 text-green-800'
                                ];
                                $statusText = [
                                    'preparing' => 'Dipersiapkan',
                                    'shipped' => 'Dalam Perjalanan',
                                    'delivered' => 'Terkirim'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$request->delivery_status ?? 'preparing'] }}">
                                {{ $statusText[$request->delivery_status ?? 'preparing'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $urgencyColors = [
                                    'low' => 'bg-green-100 text-green-800',
                                    'medium' => 'bg-yellow-100 text-yellow-800',
                                    'high' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $urgencyColors[$request->urgency] }}">
                                {{ ucfirst($request->urgency) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('pmi.tracking.show', $request) }}" class="text-blue-600 hover:text-blue-900">
                                Detail
                            </a>
                            @if($request->delivery_status !== 'delivered')
                            <span class="text-gray-300">|</span>
                            <button onclick="openUpdateModal({{ $request->id }}, '{{ $request->delivery_status ?? 'preparing' }}', '{{ $request->tracking_notes }}')" 
                                    class="text-red-600 hover:text-red-900">
                                Update Status
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data pengiriman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($bloodRequests->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $bloodRequests->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Update Status -->
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
