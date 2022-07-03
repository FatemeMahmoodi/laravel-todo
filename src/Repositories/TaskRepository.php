<?php

namespace FatemeMahmoodi\LaravelToDo\Repositories;

use FatemeMahmoodi\LaravelToDo\Http\Requests\Task\ShowRequest;
use FatemeMahmoodi\LaravelToDo\Interfaces\Repositories\TaskRepositoryInterface;
use FatemeMahmoodi\LaravelToDo\Models\Label;
use FatemeMahmoodi\LaravelToDo\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository implements TaskRepositoryInterface
{
    public function create(array $input)
    {
        $userId = 1;//Auth::id();
        $task = Task::create(array_merge($input, ['user_id' => $userId]));
        if (!empty($input['labels'])) {
            $task->labels()->sync($input['labels']);
        }
        return $task;
    }

    public function update(Task $task, array $input)
    {
        if (!empty($input['labels'])) {
            $task->labels()->sync($input['labels']);
        }
        $task->update($input);
        return $task;
    }

    public function find(Task $task)
    {
        $task['labels'] = $task->labels;
        return $task;
    }

    public function  list(array $filters)
    {
        $query = Task::query()
            ->creator(Auth::user())
            ->with(['labels']);
        if (isset($filters['labels'])) {
            $labels = $filters['labels'];
            $query->whereHas('labels', function ($q) use ($labels) {
                $q->whereIn('label_id', $labels);
            });
        }
        return $query->paginate();
    }

    public function delete(Task $task)
    {
        $task->labels()->sync([]);
        return $task->delete();
    }

}
