<?php
namespace FatemeMahmoodi\LaravelToDo\Tests;

use FatemeMahmoodi\LaravelToDo\LaravelTodoServiceProvider;
use FatemeMahmoodi\LaravelToDo\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends Orchestra\Testbench\TestCase
{
    /**
     *  use package https://www.larablocks.com/package/orchestra/testbench
     */
  use CreatesApplication, RefreshDatabase;

    protected $faker;

    public function setUp(): void
    {

        $this->faker = \Faker\Factory::create();
        parent::setUp();
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../migrations'),
        ]);
        $this->withFactories(__DIR__.'/factories');

    }

    protected function getPackageProviders($app)
    {
        return [LaravelTodoServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        # Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    public function createAuthUser()
    {
        $user = factory(User::class)->create();
        $this->withToken($user->token);
        return $user;
    }

}

