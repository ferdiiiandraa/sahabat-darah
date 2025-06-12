@extends('layouts.pmi-admin')

@section('title', 'Dashboard PMI')
@section('header', 'Dashboard PMI')

@section('content')
<div class="space-y-6">
    <div class="flex justify-end">
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </button>
        </form>
    </div>

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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Invoice</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $totalInvoices ?? 0 }}</dd>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Invoice Belum Lunas</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $unpaidInvoices ?? 0 }}</dd>
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Invoice Lunas</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $paidInvoices ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Permintaan Terbaru</h3>
                <a href="{{ route('pmi.blood-requests.index') }}" class="text-sm text-red-600 hover:text-red-800">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($bloodRequests as $request)
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
                                    {{ $request->rumahSakit->name ?? 'N/A' }} {{-- Asumsi ada relasi ke Rumah Sakit/User --}}
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
                    <a href="{{ route('pmi.invoices.index') }}"
                        class="flex items-center justify-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Lihat Semua Invoice
                    </a>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Stok Darah Tersedia</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
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