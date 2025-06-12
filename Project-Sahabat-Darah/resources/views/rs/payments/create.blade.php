@extends('layouts.rs-admin')

@section('title', 'Pembayaran Invoice')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-4 py-5 sm:px-6 bg-gradient-to-r from-purple-600 to-purple-700">
        <h3 class="text-lg leading-6 font-medium text-white">Form Pembayaran Invoice {{ $invoice->transaction_id }}</h3>
        <p class="text-sm text-purple-100 mt-1">Total yang harus dibayar: <span class="font-bold">Rp {{ number_format($invoice->total, 0, ',', '.') }}</span></p>
    </div>
    <div class="p-6 space-y-6">
        <form action="{{ route('rs.payments.store', $invoice->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                    <ul class="mt-3 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                    <select id="payment_method" name="payment_method"
                        class="w-full rounded-md border border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors" required>
                        <option value="">Pilih Metode</option>
                        <option value="transfer_bank" {{ old('payment_method') == 'transfer_bank' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                        <option value="ewallet" {{ old('payment_method') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>Kartu Kredit</option>
                    </select>
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pembayaran</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" id="amount" name="amount"
                            class="pl-10 w-full rounded-md border border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors"
                            placeholder="0" min="0" step="1000" value="{{ old('amount', $invoice->total) }}" required>
                    </div>
                </div>
            </div>

            <div>
                <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembayaran</label>
                <input type="datetime-local" id="payment_date" name="payment_date"
                    class="w-full rounded-md border border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors"
                    value="{{ old('payment_date', now()->format('Y-m-d\TH:i')) }}" required>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full rounded-md border border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-colors"
                    placeholder="Masukkan keterangan pembayaran">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="proof_of_payment" class="block text-sm font-medium text-gray-700 mb-1">Bukti Pembayaran</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-purple-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="proof_of_payment" class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                                <span>Upload bukti pembayaran</span>
                                <input id="proof_of_payment" name="proof_of_payment" type="file" accept="image/jpeg,image/jpg,image/png" class="sr-only">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 5MB</p>
                    </div>
                </div>
                <div id="previewContainer" class="mt-4 hidden">
                    <div class="relative">
                        <img id="imagePreview" class="h-32 w-auto mx-auto rounded-lg shadow-md" alt="Preview bukti pembayaran">
                        <button type="button" id="removeImage" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col space-y-4">
                <button type="submit"
                    class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    Kirim Pembayaran
                </button>

                <a href="{{ route('rs.invoices.show', $invoice->id) }}"
                    class="w-full flex justify-center items-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buktiPembayaranInput = document.getElementById('proof_of_payment');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const removeImageButton = document.getElementById('removeImage');

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

    removeImageButton.addEventListener('click', function() {
        imagePreview.src = '';
        buktiPembayaranInput.value = ''; // Clear the selected file
        previewContainer.classList.add('hidden');
    });
});
</script>
@endsection