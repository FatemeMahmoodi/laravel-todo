<?php

namespace FatemeMahmoodi\LaravelToDo;

use FatemeMahmoodi\LaravelToDo\Interfaces\Repositories\LabelRepositoryInterface;
use FatemeMahmoodi\LaravelToDo\Interfaces\Repositories\TaskRepositoryInterface;
use FatemeMahmoodi\LaravelToDo\Repositories\LabelRepository;
use FatemeMahmoodi\LaravelToDo\Repositories\TaskRepository;
use FatemeMahmoodi\LaravelToDo\Models\Label;
use FatemeMahmoodi\LaravelToDo\Models\Task;
use FatemeMahmoodi\LaravelToDo\Observers\LabelObserver;
use FatemeMahmoodi\LaravelToDo\Observers\TaskObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LaravelTodoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerBindings();
        $this->registerObservers();
        $this->registerPublishes();
        $this->registerRoutes();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel_todo.php', 'laravel_todo'
        );
    }


    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . "/../routes/api.php");
    }

    private function registerBindings()
    {
        $this->app->bind(LabelRepositoryInterface::class, function () {
            return new LabelRepository();
        });

        $this->app->bind(TaskRepositoryInterface::class, function () {
            return new TaskRepository();
        });
    }

    private function registerObservers()
    {
        Task::observe(TaskObserver::class);
        Label::observe(LabelObserver::class);
    }

    protected function registerPublishes()
    {
        $this->publishes([
            __DIR__ . '/../config/laravel_todo.php' => config_path('laravel_todo.php'),
        ], 'laravel_todo');

        $this->publishes([

            __DIR__ . '/../resources/views/emails' => resource_path('views/vendor/laravelTodo/emails'),

        ], 'laravel_todo');
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel_todo');
    }


}
