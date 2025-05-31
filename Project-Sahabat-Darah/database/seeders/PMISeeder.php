<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PMISeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pmis = [
            [
                'namainstitusi' => 'PMI Kota Jakarta Pusat',
                'email' => 'pmi.jakartapusat@example.com',
                'password' => bcrypt('password'),
                'alamat' => 'Jl. Kramat Raya No.47, RT.3/RW.4, Kramat, Kec. Senen, Kota Jakarta Pusat',
                'telepon' => '(021) 3906666',
                'is_verified' => true,
                'latitude' => -6.1844,
                'longitude' => 106.8504
            ],
            [
                'namainstitusi' => 'PMI Kota Jakarta Selatan',
                'email' => 'pmi.jakartaselatan@example.com',
                'password' => bcrypt('password'),
                'alamat' => 'Jl. Warung Jati Barat No.15, RT.1/RW.7, Kalibata, Kec. Pancoran, Kota Jakarta Selatan',
                'telepon' => '(021) 7974943',
                'is_verified' => true,
                'latitude' => -6.2550,
                'longitude' => 106.8422
            ],
            [
                'namainstitusi' => 'PMI Kota Bandung',
                'email' => 'pmi.bandung@example.com',
                'password' => bcrypt('password'),
                'alamat' => 'Jl. Aceh No.79, Cihapit, Kec. Bandung Wetan, Kota Bandung',
                'telepon' => '(022) 4239907',
                'is_verified' => true,
                'latitude' => -6.9032,
                'longitude' => 107.6186
            ],
            [
                'namainstitusi' => 'PMI Kota Surabaya',
                'email' => 'pmi.surabaya@example.com',
                'password' => bcrypt('password'),
                'alamat' => 'Jl. Embong Ploso No.7-15, Embong Kaliasin, Kec. Genteng, Kota Surabaya',
                'telepon' => '(031) 5322216',
                'is_verified' => true,
                'latitude' => -7.2647,
                'longitude' => 112.7458
            ],
            [
                'namainstitusi' => 'PMI Kota Yogyakarta',
                'email' => 'pmi.yogyakarta@example.com',
                'password' => bcrypt('password'),
                'alamat' => 'Jl. Taman Siswa No.13, Wirogunan, Kec. Mergangsan, Kota Yogyakarta',
                'telepon' => '(0274) 376741',
                'is_verified' => true,
                'latitude' => -7.8012,
                'longitude' => 110.3778
            ],
            [
                'namainstitusi' => 'PMI Kota Semarang',
                'email' => 'pmi.semarang@example.com',
                'password' => bcrypt('password'),
                'alamat' => 'Jl. Mgr Sugiyopranoto No.31, Pendrikan Kidul, Kec. Semarang Tengah, Kota Semarang',
                'telepon' => '(024) 3515050',
                'is_verified' => true,
                'latitude' => -6.9847,
                'longitude' => 110.4082
            ],
            [
                'namainstitusi' => 'PMI Kota Medan',
                'email' => 'pmi.medan@example.com',
                'password' => bcrypt('password'),
                'alamat' => 'Jl. Palang Merah No.17, Aur, Kec. Medan Maimun, Kota Medan',
                'telepon' => '(061) 4515190',
                'is_verified' => true,
                'latitude' => 3.5897,
                'longitude' => 98.6738
            ],
            [
                'namainstitusi' => 'PMI Kota Makassar',
                'email' => 'pmi.makassar@example.com',
                'password' => bcrypt('password'),
                'alamat' => 'Jl. Kandea No.16, Baraya, Kec. Bontoala, Kota Makassar',
                'telepon' => '(0411) 3624576',
                'is_verified' => true,
                'latitude' => -5.1347,
                'longitude' => 119.4125
            ],
            [
                'namainstitusi' => 'PMI Kota Denpasar',
                'email' => 'pmi.denpasar@example.com',
                'password' => bcrypt('password'),
                'alamat' => 'Jl. Kartini No.2, Dangin Puri Klod, Kec. Denpasar Tim., Kota Denpasar',
                'telepon' => '(0361) 225160',
                'is_verified' => true,
                'latitude' => -8.6546,
                'longitude' => 115.2196
            ],
            [
                'namainstitusi' => 'PMI Kota Palembang',
                'email' => 'pmi.palembang@example.com',
                'password' => bcrypt('password'),
                'alamat' => 'Jl. Jend. Sudirman No.KM. 4,5, 20 Ilir D. IV, Kec. Ilir Tim. I, Kota Palembang',
                'telepon' => '(0711) 351014',
                'is_verified' => true,
                'latitude' => -2.9761,
                'longitude' => 104.7754
            ]
        ];

        foreach ($pmis as $pmi) {
            \App\Models\PMI::create($pmi);
        }
    }
}
