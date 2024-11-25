<li class="list-group-item task-item my-1 d-block" data-id="{{ $task->id }}">
    <p><strong>{{ $task->name }}</strong><p>
    <p>
        <span class="badge text-{{ $task->priority_color }} float-start">Priorytet: {{ ucfirst($task->priority) }}</span>
        <span class="badge text-{{ $task->status_color }} float-end">Status: {{ ucfirst($task->status) }}</span>
    </p>
</li>
