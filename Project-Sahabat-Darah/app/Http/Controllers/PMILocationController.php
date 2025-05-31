<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PMILocationController extends Controller
{
    /**
     * Display the map with PMI locations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Get PMI data with coordinates
        $query = \DB::table('pmis')
            ->select('id', 'namainstitusi', 'alamat', 'telepon', 'latitude', 'longitude')
            ->where('is_verified', 1);
            
        // Apply search filter if provided
        if ($search) {
            $query->where('namainstitusi', 'like', '%' . $search . '%');
        }
        
        $pmis = $query->get();

        return view('rs.pmi-locations.index', compact('pmis', 'search'));
    }

    /**
     * Get all PMI locations as JSON for the map.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocations()
    {
        // Connect directly to the database to get PMI data
        $pmiLocations = \DB::table('pmis')
            ->select('id', 'namainstitusi', 'alamat', 'telepon')
            ->where('is_verified', 1)
            ->get()
            ->map(function($pmi) {
                // Add latitude and longitude based on the PMI location
                // These are hardcoded coordinates for each PMI based on the database entries
                switch($pmi->id) {
                    case 1: // PMI Jakarta Pusat
                        $pmi->latitude = -6.1844;
                        $pmi->longitude = 106.8504;
                        break;
                    case 2: // PMI Jakarta Selatan
                        $pmi->latitude = -6.2550;
                        $pmi->longitude = 106.8422;
                        break;
                    case 3: // PMI Bandung
                        $pmi->latitude = -6.9032;
                        $pmi->longitude = 107.6186;
                        break;
                    case 4: // PMI Surabaya
                        $pmi->latitude = -7.2647;
                        $pmi->longitude = 112.7458;
                        break;
                    case 5: // PMI Yogyakarta
                        $pmi->latitude = -7.8012;
                        $pmi->longitude = 110.3778;
                        break;
                    case 6: // PMI Semarang
                        $pmi->latitude = -6.9847;
                        $pmi->longitude = 110.4082;
                        break;
                    case 7: // PMI Medan
                        $pmi->latitude = 3.5897;
                        $pmi->longitude = 98.6738;
                        break;
                    case 8: // PMI Makassar
                        $pmi->latitude = -5.1347;
                        $pmi->longitude = 119.4125;
                        break;
                    case 9: // PMI Denpasar
                        $pmi->latitude = -8.6546;
                        $pmi->longitude = 115.2196;
                        break;
                    case 10: // PMI Palembang
                        $pmi->latitude = -2.9761;
                        $pmi->longitude = 104.7754;
                        break;
                    default:
                        // Default to center of Indonesia if no match
                        $pmi->latitude = -0.7893;
                        $pmi->longitude = 113.9213;
                }
                return $pmi;
            });

        return response()->json($pmiLocations);
    }

    /**
     * Find nearest PMI locations based on user's current location.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findNearest(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $userLat = $request->latitude;
        $userLng = $request->longitude;

        // Get all PMI locations from database
        $pmiLocations = \DB::table('pmis')
            ->select('id', 'namainstitusi', 'alamat', 'telepon')
            ->where('is_verified', 1)
            ->get()
            ->map(function($pmi) use ($userLat, $userLng) {
                // Add latitude and longitude based on the PMI location
                switch($pmi->id) {
                    case 1: // PMI Jakarta Pusat
                        $pmi->latitude = -6.1844;
                        $pmi->longitude = 106.8504;
                        break;
                    case 2: // PMI Jakarta Selatan
                        $pmi->latitude = -6.2550;
                        $pmi->longitude = 106.8422;
                        break;
                    case 3: // PMI Bandung
                        $pmi->latitude = -6.9032;
                        $pmi->longitude = 107.6186;
                        break;
                    case 4: // PMI Surabaya
                        $pmi->latitude = -7.2647;
                        $pmi->longitude = 112.7458;
                        break;
                    case 5: // PMI Yogyakarta
                        $pmi->latitude = -7.8012;
                        $pmi->longitude = 110.3778;
                        break;
                    case 6: // PMI Semarang
                        $pmi->latitude = -6.9847;
                        $pmi->longitude = 110.4082;
                        break;
                    case 7: // PMI Medan
                        $pmi->latitude = 3.5897;
                        $pmi->longitude = 98.6738;
                        break;
                    case 8: // PMI Makassar
                        $pmi->latitude = -5.1347;
                        $pmi->longitude = 119.4125;
                        break;
                    case 9: // PMI Denpasar
                        $pmi->latitude = -8.6546;
                        $pmi->longitude = 115.2196;
                        break;
                    case 10: // PMI Palembang
                        $pmi->latitude = -2.9761;
                        $pmi->longitude = 104.7754;
                        break;
                    default:
                        // Default to center of Indonesia if no match
                        $pmi->latitude = -0.7893;
                        $pmi->longitude = 113.9213;
                }
                
                // Calculate distance using Haversine formula
                $pmi->distance = $this->calculateDistance($userLat, $userLng, $pmi->latitude, $pmi->longitude);
                return $pmi;
            })
            ->sortBy('distance')
            ->values();

        return response()->json($pmiLocations);
    }

    /**
     * Calculate distance between two points using Haversine formula.
     *
     * @param float $lat1 User latitude
     * @param float $lng1 User longitude
     * @param float $lat2 PMI latitude
     * @param float $lng2 PMI longitude
     * @return float Distance in kilometers
     */
    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // Radius of the earth in km

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng/2) * sin($dLng/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c; // Distance in km

        return round($distance, 2);
    }
}
