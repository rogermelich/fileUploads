<?php

namespace Tests\Browser;

use Faker\Factory;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileController extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $faker = Factory::create();
        $user = [
            'name' => $name = $faker->name,
            'email' => $email = $faker->email,
            'password' => $password = bcrypt('secret'),
            'file' => $file = UploadedFile::fake()->image('file.png')];
        ];

        $this->browse(function (Browser $browser) use $user {
            $browser->visit('/profile')
                ->type('name', $user['name'])
                ->type('email', $user['email'])
                ->type('password', $user['password'])
                ->attach('file',__DIR__.'/photo/guapo.png')
                ->assertSee('Laravel');
        });
    }
}
