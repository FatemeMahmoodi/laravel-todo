# laravel-todo

todo list 

## Description

laravel todo is a package that can use for todo list on your project
you also can filter your tasks by define labels for them 

 

## Getting Started

### Dependencies

- php7.4
- laravel 7.x

### Installing
```
composer require FatemeMahmoodi/laravel-todo
```

### Publishing File Groups
```
#### Views
php artisan vendor:publish --tag=laravel_todo-views
#### Config
php artisan vendor:publish --tag=laravel_todo-config
#### Migrations
php artisan vendor:publish --tag=laravel_todo-migrations
```

### Set up
#### Config
1. if you have your own user model please change `task_owner` in laravel_todo.php to yours
```
'task_owner' => \FatemeMahmoodi\LaravelToDo\Models\User::class,

```
2. we use `token` driver for Authentication with a middleware named `TokenAuthorize` if you use another driver for api auth  change this in  the  `middlewares`  in laravel_todo.php
``` 
'middlewares' => ['api', \FatemeMahmoodi\LaravelToDo\Http\Middleware\TokenAuthorize::class]

```

## Authors
 fatememahmoodi77527@gmail.com

## Version History
* 0.1
    * Initial Release

 ## Run Test
```
 composer run test
```

## License
MIT
