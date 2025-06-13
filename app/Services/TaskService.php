<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    /**
     * Create a new class instance.
     */
    protected $model;
    public function __construct()
    {
        $this->model = Task::class;
    }

    public function limit(int $pagination_num = 10, array $conditions = [], array $scopes = [])
    {
        $query = $this->model::query();
        $query->when(!empty($conditions), function ($query) use ($conditions) {
            $query->where($conditions);
        })
            ->when(!empty($scopes), function ($query) use ($scopes) {
                foreach ($scopes as $scope) {
                    if (method_exists($this->model, 'scope' . ucfirst($scope))) {
                        $query->$scope();
                    }
                }
            })
            ->paginate($pagination_num);
        return $query;
    }

    public function create($data)
    {
        return $this->model::create($data);
    }

    public function edit($model, $data)
    {
        $model->update($data);
        return $model->refresh();
    }
    public function delete($model)
    {
        return $model->delete();
    }
}
