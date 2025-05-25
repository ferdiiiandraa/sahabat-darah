<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the super admin user already exists
        $superAdminEmail = 'sahabatdarah@superadmin.co.id';
        $existingSuperAdmin = User::where('email', $superAdminEmail)->first();

        if (!$existingSuperAdmin) {
            // Create super admin user
            $superAdmin = User::create([
                'name' => 'Super Admin',
                'email' => $superAdminEmail,
                'password' => Hash::make('superadminsahabatdarah1'),
                'status' => 'approved',
                'is_verified' => true,
            ]);

            // Get the super-admin role
            $superAdminRole = Role::where('slug', 'super-admin')->first();

            // Assign the super-admin role to the user
            if ($superAdminRole) {
                // Check if the role assignment already exists
                $roleAssignmentExists = DB::table('user_roles')
                    ->where('user_id', $superAdmin->id)
                    ->where('role_id', $superAdminRole->id)
                    ->exists();

                if (!$roleAssignmentExists) {
                    DB::table('user_roles')->insert([
                        'user_id' => $superAdmin->id,
                        'role_id' => $superAdminRole->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            $this->command->info('Super Admin user created successfully!');
        } else {
            // If super admin already exists, update their status and verification state
            if ($existingSuperAdmin->status !== 'approved' || !$existingSuperAdmin->is_verified) {
                 $existingSuperAdmin->update([
                     'status' => 'approved',
                     'is_verified' => true,
                 ]);
                 $this->command->info('Existing Super Admin user status and verification updated!');
            } else {
                $this->command->info('Super Admin user already exists and is approved!');
            }
        }
    }
}
