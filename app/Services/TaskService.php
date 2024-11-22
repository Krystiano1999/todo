<?php

namespace App\Services;

use App\Models\Task;

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
}
