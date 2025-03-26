<?php 

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Database\Seeders\RolesAndPermissionsSeeder;

class ApiTestCase extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->seed();
        $this->seed(RolesAndPermissionsSeeder::class);

        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null, 'Test Personal Access Client', 'http://localhost'
        );

        config(['passport.personal_access_client.id' => $client->id]);
        config(['passport.personal_access_client.secret' => $client->secret]);
    }
}