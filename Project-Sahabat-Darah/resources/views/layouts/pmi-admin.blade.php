@extends('layouts.app')

@section('navigation')
    <a href="{{ route('pmi.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pmi.dashboard') ? 'border-white' : 'border-transparent' }} text-white hover:border-white">
        Dashboard
    </a>
    <a href="{{ route('pmi.blood-requests.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pmi.blood-requests.index') ? 'border-white' : 'border-transparent' }} text-white hover:border-white">
        Riwayat Permintaan
    </a>
@endsection 