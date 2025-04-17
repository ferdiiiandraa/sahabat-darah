@extends('layouts.app')

@section('navigation')
    <a href="{{ route('rs.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('rs.dashboard') ? 'border-white' : 'border-transparent' }} text-white hover:border-white">
        Dashboard
    </a>
    <a href="{{ route('rs.blood-requests.create') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('rs.blood-requests.create') ? 'border-white' : 'border-transparent' }} text-white hover:border-white">
        Buat Permintaan
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
@endsection 