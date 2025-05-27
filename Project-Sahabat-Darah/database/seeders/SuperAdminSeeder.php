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
            try {
                // Create super admin user
                $superAdmin = User::create([
                    'name' => 'Super Admin',
                    'email' => $superAdminEmail,
                    'password' => Hash::make('superadminsahabatdarah1'),
                    'status' => 'approved',
                    'is_verified' => true,
                ]);

                // Get or create the super-admin role
                $superAdminRole = Role::firstOrCreate(
                    ['slug' => 'super-admin'],
                    [
                        'name' => 'Super Admin',
                        'slug' => 'super-admin',
                        'description' => 'Super Administrator with full access',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                // Assign the super-admin role to the user
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

                $this->command->info('Super Admin user created successfully with role assignment!');
            } catch (\Exception $e) {
                $this->command->error('Error creating Super Admin: ' . $e->getMessage());
            }
        } else {
            try {
                // If super admin already exists, update their status and verification state
                if ($existingSuperAdmin->status !== 'approved' || !$existingSuperAdmin->is_verified) {
                    $existingSuperAdmin->update([
                        'status' => 'approved',
                        'is_verified' => true,
                    ]);
                    
                    // Ensure role assignment
                    $superAdminRole = Role::firstOrCreate(
                        ['slug' => 'super-admin'],
                        [
                            'name' => 'Super Admin',
                            'slug' => 'super-admin',
                            'description' => 'Super Administrator with full access',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );

                    $roleAssignmentExists = DB::table('user_roles')
                        ->where('user_id', $existingSuperAdmin->id)
                        ->where('role_id', $superAdminRole->id)
                        ->exists();

                    if (!$roleAssignmentExists) {
                        DB::table('user_roles')->insert([
                            'user_id' => $existingSuperAdmin->id,
                            'role_id' => $superAdminRole->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    $this->command->info('Existing Super Admin user status and verification updated with role assignment!');
                } else {
                    $this->command->info('Super Admin user already exists and is approved!');
                }
            } catch (\Exception $e) {
                $this->command->error('Error updating Super Admin: ' . $e->getMessage());
            }
        }
    }
}
