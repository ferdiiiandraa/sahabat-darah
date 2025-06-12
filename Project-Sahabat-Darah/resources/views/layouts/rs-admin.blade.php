@extends('layouts.app')

@section('navigation')
    <a href="{{ route('rs.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('rs.dashboard') ? 'border-white' : 'border-transparent' }} text-white hover:border-white">
        Dashboard
    </a>
    <a href="{{ route('rs.blood-requests.create') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('rs.blood-requests.create') ? 'border-white' : 'border-transparent' }} text-white hover:border-white">
        Buat Permintaan
    </a>
    <a href="{{ route('rs.tracking.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('rs.tracking.*') ? 'border-white' : 'border-transparent' }} text-white hover:border-white">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        Tracking Pengiriman
    </a>
    <a href="{{ route('rs.notifications.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('rs.notifications.index') ? 'border-white' : 'border-transparent' }} text-white hover:border-white">
        Notifikasi
        @php
            $unreadNotifications = $unreadNotifications ?? App\Models\Notification::where('is_read', false)->count();
        @endphp
        @if($unreadNotifications > 0)
            <span class="ml-2 bg-white text-red-600 rounded-full px-2 py-1 text-xs">{{ $unreadNotifications }}</span>
        @endif
    </a>
    <a href="{{ url('/riwayat') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('riwayat') ? 'border-white' : 'border-transparent' }} text-white hover:border-white">
        Riwayat
    </a>
@endsection

@section('logout')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="submit" title="Logout" class="rounded-full p-2 bg-red-600 hover:bg-red-700 focus:outline-none transition-colors">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </button>
    </form>
@endsection
