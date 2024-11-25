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
     * @return Collection
     */
    public function getUserTasks(): Collection
    {
        return Task::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
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
}
