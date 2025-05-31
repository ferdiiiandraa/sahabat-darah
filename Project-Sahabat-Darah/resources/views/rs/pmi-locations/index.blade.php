@extends('layouts.rs-admin')

@section('title', 'Cari PMI')
@section('header', 'Cari PMI')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 400px;
        width: 100%;
        border-radius: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Cari PMI</h3>
            <p class="mt-1 text-sm text-gray-500">
                Temukan lokasi PMI berdasarkan nama
            </p>
        </div>
    </div>

    <div class="p-4">
        <!-- Search Form -->
        <form action="{{ route('rs.pmi-locations.index') }}" method="GET" class="mb-4">
            <div class="flex items-center">
                <div class="flex-grow">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari PMI berdasarkan nama</label>
                    <input type="text" name="search" id="search" value="{{ $search ?? '' }}" placeholder="Masukkan nama PMI..." class="shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="ml-4 self-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                </div>
            </div>
        </form>
        

        
        <!-- PMI List Section -->
        <div class="w-full">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Daftar PMI</h4>
            <div id="pmiList" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($pmis as $pmi)
                <div class="location-card p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer"
                    data-id="{{ $pmi->id }}"
                    data-name="{{ $pmi->namainstitusi }}"
                    data-address="{{ $pmi->alamat }}"
                    data-phone="{{ $pmi->telepon }}"
                    data-lat="{{ $pmi->latitude ?? '-6.2088' }}"
                    data-lng="{{ $pmi->longitude ?? '106.8456' }}">
                    <h3 class="text-lg font-medium text-gray-900">{{ $pmi->namainstitusi }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $pmi->alamat }}</p>
                    <p class="text-sm text-gray-500 mt-1">Telepon: {{ $pmi->telepon }}</p>
                    <div class="mt-2">
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $pmi->latitude ?? '-6.2088' }},{{ $pmi->longitude ?? '106.8456' }}" target="_blank" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 hover:bg-green-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Lihat di Google Maps
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Global variables for map and markers
    let map;
    let markers = [];
    let userMarker = null;
    
    // Wait for the page to load
    window.addEventListener('load', function() {
        // Initialize the map
        try {
            console.log('Initializing map...');
            
            // Create the map centered on Indonesia
            map = L.map('map', {
                center: [-2.5489, 118.0149], // Center of Indonesia
                zoom: 5,
                zoomControl: true
            });
            
            // Add the OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: ' OpenStreetMap contributors'
            }).addTo(map);
            
            // Add markers for all PMIs
            addPMIMarkers();
            
            // Force a map refresh
            setTimeout(function() {
                map.invalidateSize();
            }, 100);
            
            console.log('Map initialized successfully');
        } catch (error) {
            console.error('Error initializing map:', error);
        }
    });
    
    // Function to add markers for all PMIs
    function addPMIMarkers() {
        try {
            // Clear existing markers
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
            
            // Get all PMI cards
            const pmiCards = document.querySelectorAll('.location-card');
            
            // Add a marker for each PMI
            pmiCards.forEach(card => {
                const lat = parseFloat(card.dataset.lat);
                const lng = parseFloat(card.dataset.lng);
                const name = card.dataset.name;
                const address = card.dataset.address;
                
                if (isNaN(lat) || isNaN(lng)) {
                    console.warn('Invalid coordinates for PMI:', name);
                    return;
                }
                
                // Create marker
                const marker = L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup(`<b>${name}</b><br>${address}`);
                
                // Add click event to marker
                marker.on('click', function() {
                    // Highlight the corresponding card
                    highlightCard(card);
                });
                
                // Store marker reference
                markers.push(marker);
            });
            
            // If we have markers, fit the map to show all markers
            if (markers.length > 0) {
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        } catch (error) {
            console.error('Error adding PMI markers:', error);
        }
    }
    
    // Function to highlight a PMI card
    function highlightCard(card) {
        // Remove highlight from all cards
        document.querySelectorAll('.location-card').forEach(c => {
            c.classList.remove('bg-red-50', 'border-red-300');
            c.classList.add('hover:bg-gray-50', 'border-gray-300');
        });
        
        // Add highlight to the selected card
        card.classList.remove('hover:bg-gray-50', 'border-gray-300');
        card.classList.add('bg-red-50', 'border-red-300');
        
        // Scroll the card into view
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    
    // Function to get user location (global scope)
    function getUserLocation() {
        // Show loading state
        const getLocationBtn = document.getElementById('getLocationBtn');
        getLocationBtn.disabled = true;
        getLocationBtn.innerHTML = 'Meminta lokasi...';
        
        try {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    // Center map on user location
                    map.setView([lat, lng], 13);
                    
                    // Add a special marker for user location
                    const userMarker = L.marker([lat, lng], {
                        icon: L.divIcon({
                            className: 'user-location-marker',
                            html: `<div style="background-color: #3b82f6; width: 16px; height: 16px; border-radius: 50%; border: 2px solid white;"></div>`,
                            iconSize: [16, 16],
                            iconAnchor: [8, 8]
                        })
                    }).addTo(map);
                    
                    // Add a circle to show accuracy
                    L.circle([lat, lng], {
                        radius: 1000,
                        color: '#3b82f6',
                        fillColor: '#93c5fd',
                        fillOpacity: 0.2
                    }).addTo(map);
                    
                    // Reset button state
                    getLocationBtn.disabled = false;
                    getLocationBtn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Gunakan Lokasi Saya
                    `;
                },
                function(error) {
                    console.error('Error getting location:', error);
                    
                    // Show error message
                    alert('Tidak dapat mengakses lokasi Anda. Pastikan Anda telah memberikan izin lokasi pada browser.');
                    
                    // Reset button state
                    getLocationBtn.disabled = false;
                    getLocationBtn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Gunakan Lokasi Saya
                    `;
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } catch (error) {
            console.error('Error requesting location:', error);
            
            // Reset button state
            getLocationBtn.disabled = false;
            getLocationBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Gunakan Lokasi Saya
            `;
        }
    }
    
    // Set up event listeners when document is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, setting up event listeners');
        
        // Set up location button
        const locationButton = document.getElementById('getLocationBtn');
        if (locationButton) {
            locationButton.addEventListener('click', getUserLocation);
        }
        
        // Set up PMI card click handlers
        document.querySelectorAll('.location-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't trigger card click if clicking on the Google Maps link
                if (e.target.closest('a')) {
                    return;
                }
                
                const lat = parseFloat(this.getAttribute('data-lat'));
                const lng = parseFloat(this.getAttribute('data-lng'));
                const name = this.getAttribute('data-name');
                const address = this.getAttribute('data-address');
                
                console.log('PMI card clicked:', name, lat, lng);
                
                // Highlight this card
                highlightCard(this);
                
                // Center map on the selected PMI
                map.setView([lat, lng], 15);
                
                // Find the corresponding marker and open its popup
                markers.forEach(marker => {
                    const markerLatLng = marker.getLatLng();
                    if (Math.abs(markerLatLng.lat - lat) < 0.0001 && Math.abs(markerLatLng.lng - lng) < 0.0001) {
                        marker.openPopup();
                    }
                });
            });
        });
        
        // Add markers for all PMIs
        addPMIMarkers();
    });
                
                if (distance < shortestDistance) {
                    shortestDistance = distance;
        // Add click event listeners to all PMI cards
    document.addEventListener('DOMContentLoaded', function() {
        const pmiCards = document.querySelectorAll('.location-card');
        pmiCards.forEach(card => {
            card.addEventListener('click', function() {
                // Skip if clicking on a link
                if (event.target.tagName.toLowerCase() === 'a') {
                    return;
                }
                
                const lat = parseFloat(this.dataset.lat);
                const lng = parseFloat(this.dataset.lng);
                const name = this.dataset.name;
                
                // Highlight the card
                highlightCard(this);
                
                // Center map and zoom to the PMI location
                if (map) {
                    map.setView([lat, lng], 15);
                    
                    // Open the popup for this marker
                    markers.forEach(marker => {
                        const pos = marker.getLatLng();
                        if (Math.abs(pos.lat - lat) < 0.0001 && Math.abs(pos.lng - lng) < 0.0001) {
                            marker.openPopup();
                        }
                    });
                }
            });
        });
    });
    });
    
    // Function to initialize the map and add markers
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the map
        try {
            // Add markers for all PMIs
            addPMIMarkers();
            
            // Set up event listener for location button
            const locationButton = document.getElementById('getLocationBtn');
            if (locationButton) {
                locationButton.addEventListener('click', getUserLocation);
            }
        } catch (error) {
            console.error('Error initializing map:', error);
                window.selectedPMILat, 
                window.selectedPMILng
            );
            document.getElementById('distanceInfo').classList.remove('hidden');
            document.getElementById('distanceValue').textContent = distance.toFixed(2);
        } else {
            document.getElementById('distanceInfo').classList.add('hidden');
        }
    }
</script>
@endsection
