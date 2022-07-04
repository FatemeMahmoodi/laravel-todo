<?php


return [
    'task_owner_moder' => \FatemeMahmoodi\LaravelToDo\Models\User::class,
     'middlewares' => ['api' , \FatemeMahmoodi\LaravelToDo\Http\Middleware\TokenAuthorize::class]
];
