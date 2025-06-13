<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    use HelperTrait;

    public function __construct(protected TaskService $taskService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = $this->taskService->limit(scopes: ['status', 'dueDateRange','textSearch','sorting']);
        return $this->apiResponse(
            msg: 'Tasks retrieved successfully',
            data: TaskResource::collection($tasks),
            code: Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->create(data: $request->validated());
        return $this->apiResponse(
            msg: 'Task created successfully',
            data: TaskResource::make($task),
            code: Response::HTTP_CREATED
        );
    }

    /**
     * update an old created resource in storage.
     */
    public function update(Task $task, StoreTaskRequest $request)
    {
        $task = $this->taskService->edit(model: $task, data: $request->validated());
        return $this->apiResponse(
            msg: 'Task updated successfully',
            data: TaskResource::make($task),
            code: Response::HTTP_OK
        );
    }

    public function show(Task $task)
    {
        return $this->apiResponse(
            msg: 'Task retrieved successfully',
            data: TaskResource::make($task),
            code: Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->taskService->delete($task);
        return $this->apiResponse(
            msg: 'Task deleted successfully',
            code: Response::HTTP_NO_CONTENT
        );
    }

    public function updateStatus(Task $task, UpdateTaskStatusRequest $request)
    {
        $task = $this->taskService->edit($task, $request->validated());
        return $this->apiResponse(
            msg: 'Task status updated successfully',
            data: TaskResource::make($task),
            code: Response::HTTP_OK
        );
    }
}
