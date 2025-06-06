@extends('layouts.rs-admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tracking Pengiriman</h1>
        <p class="text-gray-600 mt-2">Pantau status pengiriman darah ke rumah sakit</p>
    </div>
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Daftar Pengiriman</h2>
        </div>
        
        <div class="p-6">
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pengiriman</h3>
                <p class="mt-1 text-sm text-gray-500">Pengiriman darah akan muncul di sini setelah permintaan diproses.</p>
            </div>
        </div>
    </div>
</div>
@endsection