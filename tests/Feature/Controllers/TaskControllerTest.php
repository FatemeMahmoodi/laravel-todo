<?php

namespace FatemeMahmoodi\LaravelToDo\Tests\Feature\Controllers;


use FatemeMahmoodi\LaravelToDo\Enums\TaskStatus;
use FatemeMahmoodi\LaravelToDo\Mail\SendEmailTaskStatusUpdated;
use FatemeMahmoodi\LaravelToDo\Models\Task;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use FatemeMahmoodi\LaravelToDo\Tests\TestCase;
use Illuminate\Support\Str;
use FatemeMahmoodi\LaravelToDo\Models\Label;

class TaskControllerTest extends TestCase
{
    //todo label filter

    public function testCreateTask()
    {
       // $this->withExceptionHandling();
        $user = $this->createAuthUser();
        $labels = factory(Label::class, 5)->create()
            ->pluck('id')->toArray();
        $result = $this->postJson("api/laravel_todo/tasks", [
            "title" => Str::random(10),
            "description" => Str::random(100),
            "labels" => $labels
        ]);

        $result->assertSuccessful();

        $result->assertJsonStructure([
            "data" => ["title", "description", "status"],
        ]);
        $this->assertTrue($result->original->user_id == $user->id);
        $this->assertTrue($result->original->labels()->pluck('label_id')->toArray() == $labels);
    }

    public function testUpdateTask()
    {
        $user = $this->createAuthUser();

        $task = factory(Task::class)->create(['user_id' => $user->id]);
        $labels = factory(Label::class, 10)->create()->pluck('id')->toArray();
        $status = Arr::random(TaskStatus::ALL);
        $result = $this->put("api/laravel_todo/tasks/" . $task->id, [
            "title" => Str::random(10),
            "description" => Str::random(100),
            "status" => $status,
            "labels" => $labels
        ]);
        $result->assertSuccessful();
        $this->withoutExceptionHandling();
        Mail::fake();
        Mail::to($user->email)->send(
            new SendEmailTaskStatusUpdated($result->original));
        Mail::assertSent(SendEmailTaskStatusUpdated::class);
        $result->assertJsonStructure([
            "data" => ["title", "description", "status"],
        ]);

        $this->assertTrue($result->original->user_id == $user->id);
        $this->assertTrue($result->original->status == $status);
        $this->assertTrue($result->original->labels()->pluck('label_id')->toArray() == $labels);

    }

    public function testDeleteTask()
    {
       // $this->withoutExceptionHandling();
        $user = $this->createAuthUser();
        $task = factory(Task::class)->create(['user_id' => $user->id]);
        $response = $this->delete('api/laravel_todo/tasks/'.$task->id);
        $response->assertSuccessful();
        $this->assertNull(Task::find($task->id));

    }

    public function testIndexTask()
    {
        $user = $this->createAuthUser();
        $labels = factory(Label::class, 10)->create()
            ->pluck('id')->toArray();
        $task = factory(Task::class)->create(['user_id' => $user->id]);
        $task->labels()->sync($labels);
        $response = $this->get('api/laravel_todo/tasks', [
            "labels" => [$labels[0]]
        ]);
        $response->assertSuccessful();
        $this->assertTrue($response->original[0]->id == $task->id);
        $response->assertJsonStructure([
            'data' => [
                ["labels", "title", "description", "status"],

            ],
            "links" => [
                "first",
                "last",
                "prev",
                "next",
            ],
            "meta",
        ]);
    }

    public function testShowTask()
    {
        $user = $this->createAuthUser();
        $task = factory(Task::class)->create(['user_id' => $user->id]);
        $labels = factory(Label::class, 5)->create()
            ->pluck('id')->toArray();
        $task->labels()->sync($labels);
        $response = $this->get('api/laravel_todo/tasks/' . $task->id);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            "data" => ["labels", "title", "description", "status"]
        ]);
        $this->assertTrue($response->original->user_id == $user->id);
        $this->assertTrue($response->original->labels()->pluck('label_id')->toArray() == $labels);

    }


}
