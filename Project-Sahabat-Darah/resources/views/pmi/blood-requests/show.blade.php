@extends('layouts.pmi-admin')

@section('title', 'Detail Permintaan Darah')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-4 py-5 sm:px-6">
        <h2 class="text-2xl font-bold text-gray-900">Detail Permintaan Darah</h2>
    </div>
    
    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Nama Pasien</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $bloodRequest->patient_name }}</dd>
            </div>
            
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Golongan Darah</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $bloodRequest->blood_type }}</dd>
            </div>
            
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Rhesus</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $bloodRequest->rhesus }}</dd>
            </div>
            
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Tanggal Permintaan</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $bloodRequest->request_date->format('d/m/Y H:i') }}</dd>
            </div>
            
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Nomor Telepon RS</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $bloodRequest->hospital_phone }}</dd>
            </div>
            
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Alamat RS</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $bloodRequest->hospital_address }}</dd>
            </div>
            
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $bloodRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($bloodRequest->status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($bloodRequest->status) }}
                    </span>
                    
                    @if($bloodRequest->status === 'accepted' && $bloodRequest->used_alternative_blood_type)
                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            Menggunakan {{ $bloodRequest->used_alternative_blood_type }}
                        </span>
                    @endif
                </dd>
            </div>
            
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Stok Darah {{ $bloodRequest->blood_type }}{{ $bloodRequest->rhesus }} Tersedia</dt>
                <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                    <span class="font-semibold {{ $availableStock > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $availableStock }} Kantong
                    </span>
                </dd>
            </div>
        </dl>
    </div>

    @if($bloodRequest->status === 'pending')
        @if($availableStock < 1)
            <div class="px-4 py-3 sm:px-6 bg-red-50 border-t border-red-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Stok darah {{ $bloodRequest->blood_type }}{{ $bloodRequest->rhesus }} tidak mencukupi!</h3>
                        <div class="mt-1 text-sm text-red-700">
                            <p>Tidak dapat menerima permintaan karena stok darah yang diminta tidak mencukupi. Silakan tambahkan stok terlebih dahulu atau gunakan golongan darah lain yang kompatibel.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(count($alternativeStocks) > 0)
                <div class="px-4 py-4 sm:px-6 bg-blue-50 border-t border-blue-200">
                    <div>
                        <h3 class="text-sm font-medium text-blue-800">Stok darah alternatif yang kompatibel:</h3>
                        <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-2">
                            @foreach($alternativeStocks as $type => $quantity)
                                <div class="bg-white rounded-md p-3 shadow-sm border border-blue-100">
                                    <div class="font-medium text-blue-800">{{ $type }}</div>
                                    <div class="mt-1 text-blue-600 font-semibold">{{ $quantity }} Kantong</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-2 text-xs text-blue-600">
                            <p>* Golongan darah di atas dapat digunakan sebagai alternatif yang kompatibel untuk pasien dengan golongan darah {{ $bloodRequest->blood_type }}{{ $bloodRequest->rhesus }}.</p>
                        </div>
                        
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-blue-800">Terima permintaan dengan menggunakan golongan darah alternatif:</h4>
                            <div class="mt-2 bg-white p-4 border border-blue-100 rounded-md">
                                <form action="{{ route('pmi.blood-requests.update', $bloodRequest) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="accepted">
                                    
                                    <div>
                                        <label for="alternative_blood_type" class="block text-sm font-medium text-gray-700">Pilih golongan darah alternatif:</label>
                                        <select name="alternative_blood_type" id="alternative_blood_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                            <option value="">-- Pilih golongan darah --</option>
                                            @foreach($alternativeStocks as $type => $quantity)
                                                <option value="{{ $type }}">{{ $type }} ({{ $quantity }} Kantong)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Terima dengan Golongan Darah Alternatif
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="px-4 py-3 sm:px-6 bg-yellow-50 border-t border-yellow-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Tidak ada stok darah alternatif yang tersedia</h3>
                            <div class="mt-1 text-sm text-yellow-700">
                                <p>Tidak ada golongan darah kompatibel yang tersedia saat ini. Silakan tambahkan stok darah terlebih dahulu.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        
        <div class="px-4 py-5 sm:px-6 bg-gray-50 border-t border-gray-200">
            <div class="flex space-x-4">
                @if($availableStock > 0)
                <form action="{{ route('pmi.blood-requests.update', $bloodRequest) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="accepted">
                    <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Terima Permintaan
                    </button>
                </form>
                @endif
                
                <form action="{{ route('pmi.blood-requests.update', $bloodRequest) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Tolak Permintaan
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>

<div class="mt-4">
    <a href="{{ route('pmi.blood-requests.index') }}" 
        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
        Kembali ke Daftar
    </a>
</div>
@endsection 