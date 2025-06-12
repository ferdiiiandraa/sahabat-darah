@extends('layouts.rs-admin')

@section('title', 'Dashboard RS')
@section('header', 'Dashboard Rumah Sakit')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Permintaan</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $totalRequests ?? 0 }}</dd>
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Permintaan Diterima</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $acceptedRequests ?? 0 }}</dd>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Konfirmasi</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $pendingRequests ?? 0 }}</dd>
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
                <a href="{{ route('rs.blood-requests.create') }}" class="text-sm text-red-600 hover:text-red-800">Lihat Semua</a>
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
                                <div class="text-sm text-gray-500">Golongan Darah: {{ $request->blood_type }}{{ $request->rhesus }}</div>
                            </div>
                        </div>
                        <div class="text-right text-sm text-gray-500">
                            {{ $request->request_date->format('d/m/Y H:i') }}
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
                    <a href="{{ route('rs.blood-requests.create') }}"
                        class="flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Permintaan Baru
                    </a>
                    <a href="{{ route('rs.notifications.index') }}"
                        class="flex items-center justify-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        Lihat Notifikasi
                        @if($unreadNotifications > 0)
                            <span class="ml-2 bg-red-100 text-red-600 rounded-full px-2 py-0.5 text-xs font-medium">
                                {{ $unreadNotifications }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('rs.pmi-locations.index') }}"
                        class="flex items-center justify-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Cari PMI
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="mt-10 max-w-2xl mx-auto bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-5 bg-gradient-to-r from-green-600 to-green-700">
        <h3 class="text-lg leading-6 font-medium text-white">Hubungi PMI via WhatsApp</h3>
        <p class="text-sm text-green-100 mt-1">Isi form berikut untuk menghubungi tim PMI secara langsung melalui WhatsApp.</p>
    </div>
    <div class="p-6 space-y-6">
        <form id="waFormRS" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="namaRS" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" id="namaRS" name="nama"
                        class="w-full rounded-md border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors"
                        placeholder="  Masukkan nama Anda" required>
                </div>
                <div>
                    <label for="emailRS" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="emailRS" name="email"
                        class="w-full rounded-md border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors"
                        placeholder="  Masukkan email Rumah Sakit" required>
                </div>
            </div>

            <div>
                <label for="instagramRS" class="block text-sm font-medium text-gray-700 mb-1">
                    Instagram <span class="text-gray-400 text-xs">(opsional)</span>
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">@</span>
                    </div>
                    <input type="text" id="instagramRS" name="instagram"
                        class="pl-7 w-full rounded-md border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors"
                        placeholder="username Rumah Sakit">
                </div>
            </div>

            <div>
                <label for="pesanRS" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                <textarea id="pesanRS" name="pesan" rows="4"
                    class="w-full rounded-md border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition-colors"
                    placeholder="Tulis pesan Anda di sini..." required></textarea>
            </div>

            <div class="flex flex-col space-y-4">
                <button type="submit"
                    class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M16 3C9.373 3 4 8.373 4 15c0 2.637.86 5.08 2.36 7.09L4 29l7.18-2.31C13.09 27.14 14.52 27.5 16 27.5c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 22c-1.32 0-2.61-.26-3.81-.77l-.27-.12-4.27 1.37 1.4-4.13-.18-.28C7.26 18.61 7 17.32 7 16c0-5.06 4.13-9.19 9.19-9.19S25.38 10.94 25.38 16c0 5.06-4.13 9.19-9.19 9.19zm5.09-6.41c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.25-1.41-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.32.42-.48.14-.16.18-.28.28-.46.09-.18.05-.34-.02-.48-.07-.14-.61-1.47-.84-2.01-.22-.54-.44-.47-.61-.48-.16-.01-.34-.01-.52-.01-.18 0-.48.07-.73.34-.25.27-.97.95-.97 2.32 0 1.37.99 2.7 1.13 2.89.14.18 1.95 2.98 4.74 4.06.66.23 1.18.37 1.58.47.66.17 1.26.15 1.73.09.53-.08 1.65-.67 1.89-1.32.23-.65.23-1.21.16-1.32-.07-.11-.25-.18-.53-.32z"/>
                    </svg>
                    Kirim via WhatsApp
                </button>

                <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                    <svg class="h-5 w-5 text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-1.308-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608.974-.974 2.241-1.246 3.608-1.308C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.013 7.052.072 5.771.131 4.659.363 3.678 1.344 2.697 2.325 2.465 3.437 2.406 4.718 2.347 5.998 2.334 6.407 2.334 12c0 5.593.013 6.002.072 7.282.059 1.281.291 2.393 1.272 3.374.981.981 2.093 1.213 3.374 1.272C8.332 23.987 8.741 24 12 24s3.668-.013 4.948-.072c1.281-.059 2.393-.291 3.374-1.272.981-.981 1.213-2.093 1.272-3.374.059-1.28.072-1.689.072-7.282 0-5.593-.013-6.002-.072-7.282-.059-1.281-.291-2.393-1.272-3.374C19.341.363 18.229.131 16.948.072 15.668.013 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
                    </svg>
                    <a href="https://instagram.com/donordarahjakarta" target="_blank" class="text-pink-600 hover:text-pink-700 transition-colors">@donordarahjakarta ('Instagram Resmi PMI')</a>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="bg-white shadow rounded-lg mt-6">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Invoice Pembayaran</h3>
        <p class="text-sm text-gray-500 mt-1">Kelola invoice dan pembayaran</p>
    </div>
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-md p-2">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-blue-900">Total Invoice</p>
                        <p class="text-lg font-semibold text-blue-900">{{ $totalInvoices ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-2">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-900">Invoice Lunas</p>
                        <p class="text-lg font-semibold text-green-900">{{ $paidInvoices ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <a href="{{ route('rs.invoices.index') }}"
                class="flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Lihat Semua Invoice
            </a>

            </div>
    </div>
</div>

{{-- IMPROVED INVOICE PAYMENT FORM SECTION --}}
<div class="mt-6 bg-white shadow-xl rounded-xl overflow-hidden border border-purple-200">
    <div class="px-6 py-5 bg-gradient-to-r from-purple-700 to-purple-800 text-white flex items-center justify-between">
        <h3 class="text-2xl font-extrabold tracking-tight">Form Pembayaran Invoice</h3>
        <p class="text-sm text-purple-200 hidden md:block">Isi form berikut untuk melakukan pembayaran invoice.</p>
    </div>
    <div class="p-8 space-y-7"> {{-- Increased padding and spacing for better visual breathing room --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <strong class="font-semibold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <strong class="font-semibold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form id="paymentForm" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-7"> {{-- Increased gap --}}
                <div>
                    <label for="invoiceId" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Invoice</label>
                    <div class="relative">
                        <select id="invoiceId" name="invoice_id"
                            class="block w-full py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-base transition-all duration-300 ease-in-out cursor-pointer appearance-none bg-white pr-10" required>
                            <option value="">-- Pilih Invoice --</option>
                            @forelse($unpaidInvoices as $invoice)
                                <option value="{{ $invoice->id }}" data-transaction-id="{{ $invoice->transaction_id }}" data-total="{{ $invoice->total }}">
                                    {{ $invoice->transaction_id }} - Rp {{ number_format($invoice->total, 0, ',', '.') }}
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada invoice yang belum lunas</option>
                            @endforelse
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="metodePembayaran" class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
                    <div class="relative">
                        <select id="metodePembayaran" name="payment_method"
                            class="block w-full py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-base transition-all duration-300 ease-in-out cursor-pointer appearance-none bg-white pr-10" required>
                            <option value="">Pilih Metode</option>
                            <option value="transfer_bank">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                            <option value="ewallet">E-Wallet</option>
                            <option value="cash">Cash</option>
                            <option value="credit">Kartu Kredit</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-7"> {{-- Increased gap --}}
                <div>
                    <label for="jumlahPembayaran" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Pembayaran</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-base">Rp</span>
                        </div>
                        <input type="number" id="jumlahPembayaran" name="amount"
                            class="block w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-base transition-all duration-300 ease-in-out"
                            placeholder="0" min="0" step="1000" required>
                    </div>
                </div>

                <div>
                    <label for="tanggalPembayaran" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pembayaran</label>
                    <div class="relative">
                        <input type="datetime-local" id="tanggalPembayaran" name="payment_date"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-base transition-all duration-300 ease-in-out" required>
                    </div>
                </div>
            </div>

            <div>
                <label for="keteranganPembayaran" class="block text-sm font-semibold text-gray-700 mb-2">Keterangan (Opsional)</label>
                <textarea id="keteranganPembayaran" name="description" rows="4"
                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-base transition-all duration-300 ease-in-out"
                    placeholder="Tambahkan keterangan pembayaran (misal: Transfer Bank BCA, Pembayaran tunai)"></textarea>
            </div>

            <div>
                <label for="buktiPembayaran" class="block text-sm font-semibold text-gray-700 mb-2">Bukti Pembayaran</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:border-purple-500 hover:bg-purple-50 transition-all duration-300 ease-in-out group">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-purple-600 transition-colors duration-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 group-hover:text-purple-800 transition-colors duration-300">
                            <label for="buktiPembayaran" class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus:ring-purple-500">
                                <span>Upload bukti pembayaran</span>
                                <input id="buktiPembayaran" name="proof_of_payment" type="file" accept="image/jpeg,image/png,image/jpg" class="sr-only">
                            </label>
                            <p class="pl-1">atau seret dan lepas</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 5MB</p>
                    </div>
                </div>
                <div id="previewContainer" class="mt-4 hidden">
                    <div class="relative w-40 h-40 mx-auto border border-gray-200 rounded-lg overflow-hidden shadow-md">
                        <img id="imagePreview" class="object-cover w-full h-full" alt="Preview bukti pembayaran">
                        <button type="button" id="removeImage" class="absolute -top-3 -right-3 bg-red-600 text-white rounded-full p-2 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 transform hover:scale-110">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row-reverse space-y-4 sm:space-y-0 sm:space-x-4 sm:space-x-reverse pt-4">
                <button type="submit"
                    class="w-full sm:w-auto flex-shrink-0 flex justify-center items-center px-6 py-3 border border-transparent text-base font-semibold rounded-lg text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-300 ease-in-out transform hover:scale-105 shadow-lg">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    Proses Pembayaran
                </button>

                <button type="button" id="resetPaymentForm"
                    class="w-full sm:w-auto flex-shrink-0 flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-all duration-300 ease-in-out transform hover:scale-105 shadow-sm">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset Form
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const waFormRS = document.getElementById('waFormRS');
    if(waFormRS){
        waFormRS.addEventListener('submit', function(e) {
            e.preventDefault();
            const nama = document.getElementById('namaRS').value.trim();
            const email = document.getElementById('emailRS').value.trim();
            const ig = document.getElementById('instagramRS').value.trim();
            const pesan = document.getElementById('pesanRS').value.trim();
            if (!nama || !email || !pesan) {
                alert('Semua kolom wajib diisi kecuali Instagram!');
                return;
            }
            const nomorWa = '6289521006019';
            let pesanWa = `Halo, saya ${nama}%0A%0A`;
            pesanWa += `Email: ${email}%0A`;
            if(ig) pesanWa += `Instagram: ${ig}%0A`;
            pesanWa += `%0APesan:%0A${pesan}`;
            const url = `https://wa.me/${nomorWa}?text=${pesanWa}`;
            window.open(url, '_blank');
        });
    }

    // Script for actual payment form
    const paymentForm = document.getElementById('paymentForm');
    const invoiceIdSelect = document.getElementById('invoiceId');
    const jumlahPembayaranInput = document.getElementById('jumlahPembayaran');
    const buktiPembayaranInput = document.getElementById('buktiPembayaran');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const removeImageButton = document.getElementById('removeImage');
    const resetPaymentFormButton = document.getElementById('resetPaymentForm');

    // Set default tanggal pembayaran to current datetime
    const tanggalPembayaranInput = document.getElementById('tanggalPembayaran');
    if (tanggalPembayaranInput) {
        tanggalPembayaranInput.value = new Date().toISOString().slice(0, 16);
    }

    // Populate jumlahPembayaran and set form action when invoiceId changes
    if (invoiceIdSelect && jumlahPembayaranInput && paymentForm) {
        invoiceIdSelect.addEventListener('change', function() {
            const selectedOption = invoiceIdSelect.options[invoiceIdSelect.selectedIndex];
            const totalAmount = selectedOption.dataset.total;
            const invoiceId = selectedOption.value;

            if (totalAmount) {
                jumlahPembayaranInput.value = totalAmount;
            } else {
                jumlahPembayaranInput.value = '';
            }

            if (invoiceId) {
                paymentForm.action = `/rs/payments/store/${invoiceId}`;
                paymentForm.method = 'POST'; // Ensure method is POST
            } else {
                paymentForm.action = ''; // Clear action if no invoice selected
            }
        });
    }

    // Handle image preview for the payment form
    if(buktiPembayaranInput) {
        buktiPembayaranInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                previewContainer.classList.add('hidden');
            }
        });
    }

    if(removeImageButton) {
        removeImageButton.addEventListener('click', function() {
            imagePreview.src = '';
            buktiPembayaranInput.value = ''; // Clear the selected file
            previewContainer.classList.add('hidden');
        });
    }

    if(resetPaymentFormButton) {
        resetPaymentFormButton.addEventListener('click', function() {
            paymentForm.reset();
            imagePreview.src = '';
            previewContainer.classList.add('hidden');
            jumlahPembayaranInput.value = ''; // Reset jumlah pembayaran
            paymentForm.action = ''; // Reset action form
            tanggalPembayaranInput.value = new Date().toISOString().slice(0, 16); // Reset date to current
        });
    }
});
</script>
@endsection