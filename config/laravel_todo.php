<?php


return [
    'task_owner' => \FatemeMahmoodi\LaravelToDo\Models\User::class,
    'middlewares' => ['api', \FatemeMahmoodi\LaravelToDo\Http\Middleware\TokenAuthorize::class]
];
