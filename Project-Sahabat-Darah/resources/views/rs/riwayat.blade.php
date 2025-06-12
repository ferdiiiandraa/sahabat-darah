@extends('layouts.rs-admin')

@section('title', 'Riwayat Transaksi')
@section('header', 'Riwayat Transaksi')

@section('content')
<div class="space-y-6">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Daftar Riwayat Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <!-- Hapus baris th dan td yang terkait quantity -->
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <!-- Hapus kolom jumlah -->
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}</td>
                        <td>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                {{ $transaction->status === 'Done' ? 'bg-green-100 text-green-800' :
                                ($transaction->status === 'Shipping' ? 'bg-blue-100 text-blue-800' :
                                ($transaction->status === 'Processing' ? 'bg-yellow-100 text-yellow-800' :
                                'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <!-- Kolom kosong untuk action button -->
                        <td><a href="#" class="text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded-md text-xs font-medium">Detail</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500">Tidak ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
