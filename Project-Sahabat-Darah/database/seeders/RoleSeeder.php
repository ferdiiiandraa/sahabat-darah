<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
            ],
            [
                'name' => 'Admin Rumah Sakit',
                'slug' => 'admin-rs',
            ],
            [
                'name' => 'Admin PMI',
                'slug' => 'admin-pmi',
            ],
        ];
        
        // Create roles if they don't exist
        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['slug' => $roleData['slug']],
                ['name' => $roleData['name']]
            );
            
            $this->command->info('Created role: ' . $roleData['name']);
        }
    }
}
