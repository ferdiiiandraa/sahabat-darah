@extends('layouts.rs-admin')

@section('title', 'Notifikasi')
@section('header', 'Notifikasi')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Notifikasi</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Semua notifikasi terkait permintaan darah akan muncul di sini
                </p>
            </div>
            @if($notifications->isNotEmpty())
            <form action="{{ route('rs.notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tandai Semua Dibaca
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="divide-y divide-gray-200">
        @forelse($notifications as $notification)
        <div class="p-4 sm:px-6 hover:bg-gray-50 transition-colors {{ $notification->is_read ? 'bg-white' : 'bg-red-50' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        @if($notification->type === 'status_update')
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full {{ $notification->is_read ? 'bg-gray-100' : 'bg-red-100' }}">
                            <svg class="h-5 w-5 {{ $notification->is_read ? 'text-gray-500' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </span>
                        @else
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full {{ $notification->is_read ? 'bg-gray-100' : 'bg-red-100' }}">
                            <svg class="h-5 w-5 {{ $notification->is_read ? 'text-gray-500' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                        </span>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-medium {{ $notification->is_read ? 'text-gray-900' : 'text-red-900' }}">
                            {{ $notification->title }}
                        </p>
                        <p class="text-sm {{ $notification->is_read ? 'text-gray-500' : 'text-red-700' }}">
                            {{ $notification->message }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">
                        {{ $notification->created_at->diffForHumans() }}
                    </span>
                    @if(!$notification->is_read)
                    <form action="{{ route('rs.notifications.mark-read', $notification->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            <span class="sr-only">Tandai sudah dibaca</span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
            <p class="mt-1 text-sm text-gray-500">
                Notifikasi baru akan muncul di sini ketika ada pembaruan status permintaan darah.
            </p>
        </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $notifications->links() }}
    </div>
    @endif
</div>
@endsection 