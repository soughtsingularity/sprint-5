<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(PassportSeeder::class);

        if (!User::where('email', 'test@example.com')->exists()) {
            $user = User::factory()->create([
                'username' => 'test_user',
                'email' => 'test@example.com',
                'password' => bcrypt('password123!'), 
            ]);

            $user->assignRole('user');

            $token = $user->createToken('Postman Token')->accessToken;

            $this->command->info("Passport token for Postman:");
            $this->command->info($token);
        }
    }
}
