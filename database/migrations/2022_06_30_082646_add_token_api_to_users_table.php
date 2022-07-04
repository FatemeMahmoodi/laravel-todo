<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use FatemeMahmoodi\LaravelToDo\Http\Middleware\TokenAuthorize;

class AddTokenApiToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (
            in_array(TokenAuthorize::class, config('laravel_todo.middlewares'))
            &&
            !Schema::hasColumn('users', 'token')
        )
            Schema::table('users', function (Blueprint $table) {
                $table->string('token')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
