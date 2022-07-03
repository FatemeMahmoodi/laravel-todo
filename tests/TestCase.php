<?php
namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
  use CreatesApplication, RefreshDatabase;

    protected $faker;

    public function setUp(): void
    {

        $this->faker = \Faker\Factory::create();
        parent::setUp();

    }

    public function createAuthUser()
    {
        $user = factory(User::class)->create();
        $this->withToken($user->token);
        return $user;
    }

}

