<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;

class PassportSeeder extends Seeder
{
    public function run()
    {
        Client::create([
            'id' => 2,
            'name' => 'Password Grant Client',
            'redirect' => 'http://localhost',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
            'secret' => env('PASSPORT_PASSWORD_SECRET', 'fallback-secret'),
        ]);

        Client::create([
            'id' => 1,
            'name' => 'Personal Access Client',
            'redirect' => 'http://localhost',
            'personal_access_client' => true,
            'password_client' => false,
            'revoked' => false,
            'secret' => env('PASSPORT_PERSONAL_SECRET', 'fallback-personal'),
        ]);
    }
}
