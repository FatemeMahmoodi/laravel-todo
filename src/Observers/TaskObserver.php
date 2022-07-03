<?php

namespace FatemeMahmoodi\LaravelToDo\Observers;

use FatemeMahmoodi\LaravelToDo\Mail\SendEmailTaskStatusUpdated;
use FatemeMahmoodi\LaravelToDo\Mail\TaskStatusChangedNotification;
use FatemeMahmoodi\LaravelToDo\Models\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TaskObserver
{

    public function updated(Task $task)
    {
        if ($task->wasChanged('status')) {
            Log::info('task :' . $task->id . 'updated in ' . $task->updated_at);
            try {
                Mail::to($task->user->email)->send(new SendEmailTaskStatusUpdated($task));
            } catch (\Exception $e) {
                Log::error('mail error:' . $e->getMessage());
            }
        }
    }

}
