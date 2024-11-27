<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task; 
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Illuminate\Http\Request;

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
     * Display the list of tasks in the main view with optional filters.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['priority', 'status', 'due_date_from', 'due_date_to']);
        $tasks = $this->taskService->getUserTasks($filters);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Return the HTML list of tasks for dynamic refreshing via AJAX with filters.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $filters = $request->only(['priority', 'status', 'due_date_from', 'due_date_to']);
        $tasks = $this->taskService->getUserTasks($filters);
        $html = view('tasks.partials.task_list', compact('tasks'))->render();
        
        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    /**
     * Return details of the selected task in JSON format.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $task = $this->taskService->getTaskDetails((int) $id);

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

            $filters = []; 
            $tasks = $this->taskService->getUserTasks($filters);
            $taskListHtml = view('tasks.partials.task_list', compact('tasks'))->render();

            return response()->json([
                'success' => true,
                'message' => 'Zadanie zostało zaktualizowane.',
                'task_list_html' => $taskListHtml,
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
