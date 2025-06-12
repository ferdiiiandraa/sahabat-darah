@extends('layouts.app')

@section('navigation')
    <a href="{{ route('pmi.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pmi.dashboard') ? 'border-white' : 'border-transparent' }} text-white hover:border-white">
        Dashboard
    </a>
    <a href="{{ route('pmi.blood-requests.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pmi.blood-requests.*') ? 'border-white' : 'border-transparent' }} text-white hover:border-white">
        Permintaan Darah
    </a>
    <a href="{{ route('pmi.tracking.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pmi.tracking.*') ? 'border-white' : 'border-transparent' }} text-white hover:border-white">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Tracking Pengiriman
    </a>
    <a href="{{ route('pmi.blood-inventory.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pmi.blood-inventory.*') ? 'border-white' : 'border-transparent' }} text-white hover:border-white">
        Stok Darah
    </a>
@endsection
