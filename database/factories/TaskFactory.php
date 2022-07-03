<?php

use Faker\Generator as Faker;
use FatemeMahmoodi\LaravelToDo\Models\Task;
use FatemeMahmoodi\LaravelToDo\Models\User;
use FatemeMahmoodi\LaravelToDo\Enums\TaskStatus;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->sentence,
        "status" => Arr::random(TaskStatus::ALL),
        'user_id' => factory(User::class)
    ];
});
