<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class TaskService
{
    /**
     * Create a new task.
     *
     * @param array<string, mixed> $data
     * @return Task
     */
    public function createTask(array $data): Task
    {
        $data['user_id'] = auth()->id();
        return Task::create($data);
    }

    /**
     * Get the list of tasks for the authenticated user.
     *
     * @param array<string, mixed> $filters Optional filters for tasks
     * @return Collection
     */
    public function getUserTasks(array $filters = []): Collection
    {
        $query = Task::where('user_id', auth()->id());
    
        if (!empty($filters['priority'])) {
            $query->whereIn('priority', $filters['priority']);
        }

        if (!empty($filters['status'])) {
            $query->whereIn('status', $filters['status']);
        }

        if (!empty($filters['due_date_from'])) {
            $query->where('due_date', '>=', $filters['due_date_from']);
        }
        if (!empty($filters['due_date_to'])) {
            $query->where('due_date', '<=', $filters['due_date_to']);
        }

        return $query->orderBy('due_date', 'desc')->get();
    }

    /**
     * Get the details of the selected task.
     *
     * @param int $id
     * @return Task
     *
     * @throws ModelNotFoundException
     */
    public function getTaskDetails(int $id): Task
    {
        try {
            return Task::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404, 'Zadanie nie zostało znalezione.');
        }
    }

    /**
     * Delete the selected task for the authenticated user.
     *
     * @param int $id
     * @return void
     *
     * @throws ModelNotFoundException
     */
    public function deleteTask(int $id): void
    {
        $task = $this->getTaskDetails($id);
        $task->delete();
    }

    /**
     * Update the specified task.
     *
     * @param int $id
     * @param array<string, mixed> $data
     * @return Task
     *
     * @throws ModelNotFoundException
     */
    public function updateTask(int $id, array $data): Task
    {
        $task = $this->getTaskDetails($id);
        $task->update($data);
        return $task;
    }

}
