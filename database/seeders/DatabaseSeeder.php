use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role; // Pastikan Anda punya model Role
use Illuminate\Support\Facades\DB; // Jika menggunakan DB facade untuk tabel pivot

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // \App\Models\User::factory(10)->create(); // Opsional: Komentari atau hapus jika tidak dibutuhkan

        // Buat atau cari role 'super-admin'
        $superAdminRole = Role::firstOrCreate(['slug' => 'super-admin'], ['name' => 'Super Admin']); // Asumsikan model Role ada dengan field 'slug' dan 'name'

        // Buat atau cari Pengguna Super Admin
        $superAdminUser = User::firstOrCreate(
            ['email' => 'sahabatdarah@superadmin.co.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('superadminsahabatdarah1'), // Hash password
                // Tambahkan field lain yang dibutuhkan untuk model User Anda jika ada dan sesuai dengan migrasi Anda.
                // Pastikan field-field ini ada di tabel users dan terdaftar di property $fillable di model User.
                'email_verified_at' => now(), // Asumsikan email diverifikasi secara default
            ]
        );

        // Kaitkan role 'super-admin' ke Pengguna Super Admin
        // Asumsikan Anda menggunakan relasi many-to-many dengan tabel pivot 'user_roles'
        // Pastikan User model punya relasi 'roles()' yang menggunakan tabel pivot user_roles
        if (!$superAdminUser->roles->contains($superAdminRole->id)) {
             $superAdminUser->roles()->attach($superAdminRole->id);
        }

        // Opsional: Seed data lain
        // $this->call([
        //     OtherSeeders::class,
        // ]);
    }
} 