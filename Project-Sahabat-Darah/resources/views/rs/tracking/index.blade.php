@extends('layouts.rs-admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Pelacakan Pengiriman</h1>
        <p class="text-gray-600 mt-2">Pantau status pengiriman darah ke rumah sakit</p>
    </div>

    {{-- Form Filter --}}
    <form method="GET" class="mb-6 bg-white p-4 rounded-lg shadow flex flex-col lg:flex-row gap-4 items-start lg:items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Filter berdasarkan Tanggal Pengiriman</label>
            <input type="date" name="date" value="{{ request('date') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700">Filter Status Pengiriman</label>
            <select name="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2">
                <option value="">Semua Status</option>
                <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>Sedang Dipersiapkan</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Sedang Dikirim</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Sudah Sampai</option>
            </select>
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Terapkan Filter</button>
        </div>
    </form>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Daftar Pengiriman Darah</h2>
        </div>

        <div class="p-6">
            @php
                $deliveries = [
                    [
                        'id' => 1,
                        'patient_name' => 'Ruben',
                        'blood_type' => 'A',
                        'rhesus' => '+',
                        'quantity' => 2,
                        'urgency' => 'high',
                        'pmi' => 'PMI Jakarta Barat',
                        'delivery_status' => 'shipped',
                        'delivery_date' => '2025-06-11',
                        'tracking_notes' => 'Dalam perjalanan menuju rumah sakit.'
                    ],
                    [
                        'id' => 2,
                        'patient_name' => 'Ferdi',
                        'blood_type' => 'B',
                        'rhesus' => '-',
                        'quantity' => 1,
                        'urgency' => 'medium',
                        'pmi' => 'PMI Jakarta Timur',
                        'delivery_status' => 'delivered',
                        'delivery_date' => '2025-06-10',
                        'tracking_notes' => 'Telah sampai di rumah sakit.'
                    ],
                    [
                        'id' => 3,
                        'patient_name' => 'Joy',
                        'blood_type' => 'AB',
                        'rhesus' => '+',
                        'quantity' => 3,
                        'urgency' => 'low',
                        'pmi' => 'PMI Jakarta Pusat',
                        'delivery_status' => 'preparing',
                        'delivery_date' => '2025-06-12',
                        'tracking_notes' => 'Sedang dipersiapkan.'
                    ]
                ];

                $date = request('date', '');
                $status = request('status', '');

                $deliveries = array_filter($deliveries, function ($d) use ($date, $status) {
                    $matchDate = $date === '' || $d['delivery_date'] === $date;
                    $matchStatus = $status === '' || $d['delivery_status'] === $status;
                    return $matchDate && $matchStatus;
                });

                $urgencyColors = [
                    'low' => 'bg-green-100 text-green-800',
                    'medium' => 'bg-yellow-100 text-yellow-800',
                    'high' => 'bg-red-100 text-red-800'
                ];

                $statusLabel = [
                    'preparing' => 'Sedang Dipersiapkan',
                    'shipped' => 'Sedang Dikirim',
                    'delivered' => 'Sudah Sampai'
                ];
            @endphp

            @if (empty($deliveries))
                <p class="text-gray-500">Tidak ada data pengiriman yang cocok dengan filter.</p>
            @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($deliveries as $delivery)
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Pengiriman #{{ $delivery['id'] }}</h2>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $delivery['patient_name'] }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ $delivery['blood_type'] }}{{ $delivery['rhesus'] }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah Kantong</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $delivery['quantity'] }} kantong</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tingkat Urgensi</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $urgencyColors[$delivery['urgency']] }}">
                                    {{ ucfirst($delivery['urgency']) == 'Low' ? 'Rendah' : (ucfirst($delivery['urgency']) == 'Medium' ? 'Sedang' : 'Tinggi') }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">PMI Pengirim</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $delivery['pmi'] }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Pengiriman</label>
                            <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($delivery['delivery_date'])->translatedFormat('d F Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status Pengiriman</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $statusLabel[$delivery['delivery_status']] ?? ucfirst($delivery['delivery_status']) }}</p>
                        </div>
                        {{-- Catatan pelacakan dihapus --}}
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
