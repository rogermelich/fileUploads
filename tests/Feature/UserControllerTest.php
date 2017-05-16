<?php

namespace Tests\Feature;

use App\User;
use Faker\Factory;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUsersAddCreatedTest()
    {
        // Prepare
        Storage::fake('general');
        $faker = factory::create();

        $user = [
            'name' => $name = $faker->name,
            'email' => $email = $faker->email,
            'password' => $password = bcrypt('secret'),
            'file' => $file = UploadedFile::fake()->image('file.png')];
        //Login as autorized
        $authorizeUser = factory(User::class)->create();
        // Execute
        $response = $this->actingAs($authorizeUser, 'api')->json('POST', 'api/v1/user', $user);

        // Assert
        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);

        $this->assertDatabaseHas('users', [
            'name'      => $name,
            'email'     => $email,
            'password'  => $password,
            'file'      => $file
        ]);
    }
}
