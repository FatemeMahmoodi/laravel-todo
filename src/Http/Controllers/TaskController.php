<?php

namespace FatemeMahmoodi\LaravelToDo\Http\Controllers;

use FatemeMahmoodi\LaravelToDo\Http\Requests\Task\DestroyRequest;
use FatemeMahmoodi\LaravelToDo\Http\Requests\Task\IndexRequest;
use FatemeMahmoodi\LaravelToDo\Http\Requests\Task\ShowRequest;
use FatemeMahmoodi\LaravelToDo\Http\Requests\Task\StoreRequest;
use FatemeMahmoodi\LaravelToDo\Http\Requests\Task\UpdateRequest;
use FatemeMahmoodi\LaravelToDo\Http\Resources\OperationResource;
use FatemeMahmoodi\LaravelToDo\Http\Resources\TaskResource;
use FatemeMahmoodi\LaravelToDo\Interfaces\Repositories\TaskRepositoryInterface;
use FatemeMahmoodi\LaravelToDo\Models\Task;
use FatemeMahmoodi\LaravelToDo\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    private $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param StoreRequest $request
     * @return TaskResource
     */
    public function store(StoreRequest $request): TaskResource
    {
        return new TaskResource($this->taskRepository->create($request->all()));
    }

    /**
     * @param Task $task
     * @param UpdateRequest $request
     * @return TaskResource
     */
    public function update(Task $task, UpdateRequest $request): TaskResource
    {
        return new TaskResource($this->taskRepository->update($task, $request->all()));
    }

    /**
     * @param IndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexRequest $request)
    {
        return TaskResource::collection($this->taskRepository->list($request->all()));
    }

    /**
     * @param Task $task
     * @param ShowRequest $request
     * @return TaskResource
     */
    public function show(Task $task, ShowRequest $request): TaskResource
    {
        return new TaskResource($this->taskRepository->find($task));

    }

    /**
     * @param Task $task
     * @param DestroyRequest $request
     * @return OperationResource
     */
    public function destroy(Task $task, DestroyRequest $request): OperationResource
    {
        $result = $this->taskRepository->delete($task);
        return new OperationResource([
            'operation' => 'task delete',
            'status' => $result,
        ]);
    }

}
