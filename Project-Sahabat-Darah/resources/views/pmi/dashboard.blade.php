@extends('layouts.pmi-admin')

@section('title', 'Dashboard PMI')
@section('header', 'Dashboard PMI')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Permintaan Menunggu</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $pendingRequests }}</dd>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Permintaan Diterima</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $acceptedRequests }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Permintaan Ditolak</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $rejectedRequests }}</dd>
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
                <a href="{{ route('pmi.blood-requests.index') }}" class="text-sm text-red-600 hover:text-red-800">Lihat Semua</a>
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
                                <div class="text-sm text-gray-500">
                                    <span class="font-medium">{{ $request->blood_type }}{{ $request->rhesus }}</span> - 
                                    {{ $request->hospital_name }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right text-sm text-gray-500">
                                {{ $request->request_date->format('d/m/Y H:i') }}
                            </div>
                            <a href="{{ route('pmi.blood-requests.show', $request) }}" 
                                class="inline-flex items-center text-sm font-medium text-red-600 hover:text-red-900">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
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
                    <a href="{{ route('pmi.blood-requests.index') }}" 
                        class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Lihat Semua Permintaan
                    </a>
                    <a href="{{ route('pmi.blood-inventory.index') }}" 
                        class="flex items-center justify-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2M7 7h10"/>
                        </svg>
                        Kelola Stok Darah
                    </a>
                </div>
            </div>

            <!-- Blood Stock Overview -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Stok Darah Tersedia</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Golongan A -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-500">Golongan A</div>
                            <div class="mt-1 flex items-baseline justify-between">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{ isset($bloodStock['A+']) ? $bloodStock['A+']->quantity : 0 }}
                                </div>
                                <div class="text-sm font-medium {{ isset($bloodStock['A+']) && $bloodStock['A+']->quantity > 10 ? 'text-green-600' : (isset($bloodStock['A+']) && $bloodStock['A+']->quantity > 5 ? 'text-yellow-600' : 'text-red-600') }}">
                                    Kantong
                                </div>
                            </div>
                        </div>
                        
                        <!-- Golongan B -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-500">Golongan B</div>
                            <div class="mt-1 flex items-baseline justify-between">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{ isset($bloodStock['B+']) ? $bloodStock['B+']->quantity : 0 }}
                                </div>
                                <div class="text-sm font-medium {{ isset($bloodStock['B+']) && $bloodStock['B+']->quantity > 10 ? 'text-green-600' : (isset($bloodStock['B+']) && $bloodStock['B+']->quantity > 5 ? 'text-yellow-600' : 'text-red-600') }}">
                                    Kantong
                                </div>
                            </div>
                        </div>
                        
                        <!-- Golongan AB -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-500">Golongan AB</div>
                            <div class="mt-1 flex items-baseline justify-between">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{ isset($bloodStock['AB+']) ? $bloodStock['AB+']->quantity : 0 }}
                                </div>
                                <div class="text-sm font-medium {{ isset($bloodStock['AB+']) && $bloodStock['AB+']->quantity > 10 ? 'text-green-600' : (isset($bloodStock['AB+']) && $bloodStock['AB+']->quantity > 5 ? 'text-yellow-600' : 'text-red-600') }}">
                                    Kantong
                                </div>
                            </div>
                        </div>
                        
                        <!-- Golongan O -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-500">Golongan O</div>
                            <div class="mt-1 flex items-baseline justify-between">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{ isset($bloodStock['O+']) ? $bloodStock['O+']->quantity : 0 }}
                                </div>
                                <div class="text-sm font-medium {{ isset($bloodStock['O+']) && $bloodStock['O+']->quantity > 10 ? 'text-green-600' : (isset($bloodStock['O+']) && $bloodStock['O+']->quantity > 5 ? 'text-yellow-600' : 'text-red-600') }}">
                                    Kantong
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 