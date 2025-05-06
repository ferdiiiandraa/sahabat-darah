<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UpdateSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds to ensure the super admin user is properly configured.
     */
    public function run(): void
    {
        // Super admin email
        $superAdminEmail = 'sahabatdarah@superadmin.co.id';
        
        // Find the super admin user
        $superAdmin = User::where('email', $superAdminEmail)->first();
        
        if ($superAdmin) {
            // Update the super admin user if needed
            $superAdmin->update([
                'name' => 'Super Admin',
                'password' => Hash::make('superadminsahabatdarah1'),
                'status' => User::STATUS_APPROVED,
                'is_verified' => true,
            ]);
            
            // Get the super-admin role
            $superAdminRole = Role::where('slug', 'super-admin')->first();
            
            if ($superAdminRole) {
                // Check if the role assignment already exists
                $roleAssignmentExists = DB::table('user_roles')
                    ->where('user_id', $superAdmin->id)
                    ->where('role_id', $superAdminRole->id)
                    ->exists();
                
                if (!$roleAssignmentExists) {
                    // Assign the super-admin role to the user
                    DB::table('user_roles')->insert([
                        'user_id' => $superAdmin->id,
                        'role_id' => $superAdminRole->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    
                    $this->command->info('Super Admin role assigned successfully!');
                } else {
                    $this->command->info('Super Admin already has the correct role!');
                }
            } else {
                $this->command->error('Super Admin role not found in the database!');
            }
            
            $this->command->info('Super Admin user updated successfully!');
        } else {
            $this->command->error('Super Admin user not found! Please run the SuperAdminSeeder first.');
        }
    }
}
