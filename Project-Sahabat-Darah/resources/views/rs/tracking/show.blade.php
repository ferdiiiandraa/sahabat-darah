@extends('layouts.rs-admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Tracking Pengiriman</h1>
                <p class="text-gray-600">Pasien: {{ $bloodRequest->patient_name }}</p>
            </div>
            <a href="{{ route('rs.tracking.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informasi Permintaan -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Informasi Permintaan</h2>
            </div>
            <div class="px-6 py-4 space-y-4">
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
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rumah Sakit</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $bloodRequest->rumahSakit->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Status Tracking -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Status Pengiriman</h2>
            </div>
            <div class="px-6 py-4">
                <!-- Timeline -->
                <div class="flow-root">
                    <ul class="-mb-8">
                        @php
                            $currentStatus = $bloodRequest->delivery_status ?? 'preparing';
                            $statuses = [
                                'preparing' => ['label' => 'Sedang Dipersiapkan', 'icon' => 'clock'],
                                'shipped' => ['label' => 'Dalam Perjalanan', 'icon' => 'truck'],
                                'delivered' => ['label' => 'Telah Dikirim', 'icon' => 'check-circle']
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
                                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </span>
                                        @else
                                        <span class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white">
                                            <span class="h-2 w-2 bg-white rounded-full"></span>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">{{ $statuses[$status]['label'] }}</p>
                                            @if($index == $currentIndex)
                                            <p class="text-xs text-green-600 font-medium">Status saat ini</p>
                                            @endif
                                        </div>
                                        @if($index <= $currentIndex)
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            {{ $bloodRequest->updated_at->format('d/m/Y H:i') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Catatan Tracking -->
                @if($bloodRequest->tracking_notes)
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Catatan Pengiriman:</h4>
                    <p class="text-sm text-gray-700">{{ $bloodRequest->tracking_notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection