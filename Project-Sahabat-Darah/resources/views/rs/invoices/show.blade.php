@extends('layouts.rs-admin')

@section('title', 'Detail Invoice')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-4 py-5 sm:px-6">
        <h2 class="text-2xl font-bold text-gray-900">Detail Invoice {{ $invoice->transaction_id }}</h2>
    </div>

    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Invoice ID</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $invoice->transaction_id }}</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Permintaan Darah</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                    {{ $invoice->bloodRequest->patient_name }} ({{ $invoice->bloodRequest->blood_type }}{{ $invoice->bloodRequest->rhesus }})
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Jumlah Kantong</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $invoice->amount }}</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Harga per Kantong</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Rp {{ number_format($invoice->price, 0, ',', '.') }}</dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Total Harga</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Rp {{ number_format($invoice->total, 0, ',', '.') }}</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        {{ $invoice->status === 'unpaid' ? 'bg-yellow-100 text-yellow-800' :
                           ($invoice->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $invoice->created_at->format('d/m/Y H:i') }}</dd>
            </div>

            @if($invoice->payment)
            <div class="bg-white px-4 py-5 sm:px-6 border-t border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Pembayaran</h3>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ ucfirst(str_replace('_', ' ', $invoice->payment->payment_method)) }}</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Jumlah Dibayar</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Rp {{ number_format($invoice->payment->price, 0, ',', '.') }}</dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Tanggal Pembayaran</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($invoice->payment->payment_date)->format('d/m/Y H:i') }}</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Keterangan</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $invoice->payment->description ?? '-' }}</dd>
            </div>
            @if($invoice->payment->file_path)
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Bukti Pembayaran</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                    <img src="{{ Storage::url($invoice->payment->file_path) }}" alt="Bukti Pembayaran" class="h-48 w-auto rounded-lg shadow-md">
                </dd>
            </div>
            @endif
            @else
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Status Pembayaran</dt>
                <dd class="mt-1 text-sm text-red-600 sm:col-span-2 sm:mt-0">Belum ada pembayaran terdaftar.</dd>
            </div>
            @endif
        </dl>
    </div>

    <div class="px-4 py-5 sm:px-6 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
        <a href="{{ route('rs.invoices.index') }}"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            Kembali ke Daftar Invoice
        </a>
        @if($invoice->status === 'unpaid')
        <a href="{{ route('rs.payments.create', $invoice->id) }}"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            Bayar Invoice Ini
        </a>
        @endif
    </div>
</div>
@endsection