<?php

namespace FatemeMahmoodi\LaravelToDo\Tests\Feature\Controllers;


use FatemeMahmoodi\LaravelToDo\Models\Task;
use FatemeMahmoodi\LaravelToDo\Tests\TestCase;
use Illuminate\Support\Str;
use FatemeMahmoodi\LaravelToDo\Models\Label;

class LabelControllerTest extends TestCase
{
    //todo label filter

    public function testCreateLabel()
    {
        $this->createAuthUser();
        $result = $this->post("api/laravel_todo/labels", [
            "title" => Str::random(10),
        ]);
        $result->assertSuccessful();

        $result->assertJsonStructure([
            "data" => ["id", "title", "tasks_count"],
        ]);

    }

    public function testIndexLabel()
    {
        $user = $this->createAuthUser();
        $labelsTasks = [];
        $labels = factory(Label::class, 10)->create();
        foreach ($labels as $label) {
            $tasks = factory(Task::class, rand(5 ,10))->create(['user_id' => $user->id])
                ->pluck('id')->toArray();
            $label->tasks()->sync($tasks);
            $labelsTasks[$label->id]['count'] = count($tasks);
        }
        $response = $this->get('api/laravel_todo/labels');
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                ["id", "title", "tasks_count"],
            ],
            "links" => [
                "first",
                "last",
                "prev",
                "next",
            ],
            "meta",
        ]);
        foreach ($response->decodeResponseJson()['data'] as $label){
            $this->assertTrue($label['tasks_count'] == $labelsTasks[$label['id']]['count']);
        }
    }


}
