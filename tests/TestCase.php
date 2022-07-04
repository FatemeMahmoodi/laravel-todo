<?php
namespace FatemeMahmoodi\LaravelToDo\Tests;

use FatemeMahmoodi\LaravelToDo\LaravelTodoServiceProvider;
use FatemeMahmoodi\LaravelToDo\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;
    /**
     *  use package https://www.larablocks.com/package/orchestra/testbench
     */


    protected $faker;

    public function setUp(): void
    {
        $this->faker = \Faker\Factory::create();
        parent::setUp();
        $this->withFactories(__DIR__.'/../database/factories');
       // $this->loadLaravelMigrations(["--database" => "testbench"]);
        $this->loadMigrationsFrom([
            "--database" => "testbench",
            "--path" => realpath(__DIR__ . "/../database/migrations"),
        ]);


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

