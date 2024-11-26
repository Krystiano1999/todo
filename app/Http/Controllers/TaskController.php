<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task; 
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class TaskController extends Controller
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Store a newly created task in storage.
     *
     * @param StoreTaskRequest $request
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $task = Task::create(array_merge(
                $request->validated(),
                ['user_id' => auth()->id()]
            ));

            $task->priority_color = $task->priority_color;
            $task->status_color = $task->status_color;

            return response()->json([
                'success' => true,
                'message' => 'Zadanie zostało stworzone.',
                'data' => $task,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Coś poszło nie tak, spróbuj ponownie później.',
            ], 500);
        }
    }

    /**
     * Display the list of tasks in the main view.
     *
     * @return View
     */
    public function index(): View
    {
        $tasks = $this->taskService->getUserTasks();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Return the HTML list of tasks for dynamic refreshing via AJAX.
     *
     * @return string
     */
    public function list(): string
    {
        $tasks = $this->taskService->getUserTasks();
        return view('tasks.partials.task_list', compact('tasks'))->render();
    }

    /**
     * Return details of the selected task in JSON format.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $task = $this->taskService->getTaskDetails($id);

        return response()->json([
            'id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'priority' => $task->priority,
            'priority_color' => $task->priority_color,
            'status' => $task->status,
            'status_color' => $task->status_color,
            'created_at' => $task->created_at->format('d/m/Y'),
            'due_date' => $task->due_date->format('d/m/Y'),
        ]);
    }

    /**
     * Delete the selected task.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->taskService->deleteTask($id);

        return response()->json(['message' => 'Zadanie pomyślnie usunięte.']);
    }

    /**
     * Update the specified task in storage.
     *
     * @param UpdateTaskRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        try {
            $task = $this->taskService->updateTask($id, $request->validated());

            $task->priority_color = $task->priority_color;
            $task->status_color = $task->status_color;

            return response()->json([
                'success' => true,
                'message' => 'Zadanie zostało zaktualizowane.',
                'data' => $task,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Coś poszło nie tak, spróbuj ponownie później.',
            ], 500);
        }
    }
}
