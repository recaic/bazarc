<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Faker\Factory;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function non_authenticated_users_cannot_access_the_following_endpoints_for_the_product_api()
    {
        $index = $this->json('GET', '/api/v1/users');
        $index->assertStatus(401);

        $store = $this->json('POST', '/api/v1/users');
        $store->assertStatus(401);

        $show = $this->json('GET', '/api/v1/users/-1');
        $show->assertStatus(401);

        $update = $this->json('PUT', '/api/v1/users/-1');
        $update->assertStatus(401);

        $destroy = $this->json('DELETE', '/api/v1/users/-1');
        $destroy->assertStatus(401);
    }

    /**
     * @test
     * @return void
     */
    public function can_get_users_without_authenticated()
    {
        $response = $this->json('GET', 'api/v1/users');

//        $this->expectOutputString('Unauthenticated');

        $response
//            ->assertJsonStructure(['error', 'code'])
//            ->assertJson([
//                'error' => "Unauthenticated.",
//                'code' => 401
//            ])
            ->assertStatus(401);
    }

    /**
     * @test
     * @return void
     */
    public function can_create_a_user()
    {
        $faker = Factory::create();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('POST', 'api/v1/users', [
                'name' => $name = $faker->company,
                'email' => $email = $faker->email,
                'password' => $password = 'secret12345*'
            ]);

        $response->assertJsonStructure([
            'id', 'name', 'slug', 'email', 'created_at'
        ])->assertJson([
            'name' => $name,
            'slug' => Str::slug($name),
            'email' => $email
        ])->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'slug' => Str::slug($name),
            'email' => $email
        ]);
    }
}
