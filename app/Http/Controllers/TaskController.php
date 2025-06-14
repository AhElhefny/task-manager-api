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
     * Get all tasks with sorting and filtering.
     *
     * @queryParam status string One of: pending, in_progress, completed, overdue. Example: pending
     * @queryParam due_date_range string Date range in the format of "YYYY-MM-DD,YYYY-MM-DD". Example: 2023-03-01,2023-03-31
     * @queryParam text_search string Search query. Example: task
     * @queryParam sorting string One of: priority, due_date, created_at. Example: priority
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = $this->taskService->limit(scopes: ['status', 'dueDateRange', 'textSearch', 'sorting']);
        return TaskResource::collection($tasks)
            ->additional([
                'message' => 'Tasks retrieved successfully',
                'status' => Response::HTTP_OK,
            ]);
    }


    /**
     * Store a newly created task in storage.
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Task  $task
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
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

    /**
     * Display the specified task.
     *
     * @param \App\Models\Task $task The task instance to be displayed.
     * @return \Illuminate\Http\Response The response containing the task data.
     */

    public function show(Task $task)
    {
        return $this->apiResponse(
            msg: 'Task retrieved successfully',
            data: TaskResource::make($task),
            code: Response::HTTP_OK
        );
    }


    /**
     * Remove the specified task from storage.
     *
     * @param \App\Models\Task $task The task instance to be deleted.
     * @return \Illuminate\Http\Response The response containing the task deletion status.
     */
    public function destroy(Task $task)
    {
        $this->taskService->delete($task);
        return $this->apiResponse(
            msg: 'Task deleted successfully',
            code: Response::HTTP_OK
        );
    }

    /**
     * Update the status of a task.
     *
     * @param \App\Models\Task $task The task instance to be updated.
     * @param \App\Http\Requests\UpdateTaskStatusRequest $request The request instance containing the new task status.
     *
     * @return \Illuminate\Http\Response The response containing the task with the updated status.
     */
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
