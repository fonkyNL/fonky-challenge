<?php

namespace Console\Commands;

use Tests\TestCase;

class CreateUserTest extends TestCase
{
    public function testItCanMakeAUser()
    {
        $this->artisan('make:user')
            ->expectsQuestion('Name', 'Test')
            ->expectsQuestion('Email', 'test@test.com')
            ->expectsQuestion('Password', 'testtest')
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'name' => 'Test',
            'email' => 'test@test.com',
        ]);
    }
}
