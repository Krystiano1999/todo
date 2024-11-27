<li class="list-group-item task-item my-1 d-block" data-id="{{ $task->id }}">
    <p class="d-flex align-items-center justify-content-between">
        <strong >{{ $task->name }}</strong>
        <strong class="date">{{ $task->due_date->format('d-m-Y') }}</strong>
    <p>
    <p class="d-flex align-items-center justify-content-between">
        <span class="badge text-{{ $task->priority_color }} ">Priorytet: {{ ucfirst($task->priority) }}</span>
        <span class="badge text-{{ $task->status_color }} ">Status: {{ ucfirst($task->status) }}</span>
    </p>
</li>
