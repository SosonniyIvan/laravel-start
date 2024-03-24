<?php

namespace Tests\Feature\Admin;

use App\Enums\Roles;
use App\Models\User;
use Database\Factories\UserFactory;
use Database\Seeders\AdminSeeder;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
    protected function afterRefreshingDatabase()
    {
        $this->seed(PermissionSeeder::class);
        $this->seed(AdminSeeder::class);
    }
    /**
     * A basic feature test example.
     */
    public function test_register_with_valid_data(): void
    {
        $user = User::factory(2)->create();

        $response = $this->actingAs($this->getUser(Roles::CUSTOMER)->get(route('/home')));


    }
}
