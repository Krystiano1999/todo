<div class="card shadow-sm h-100">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h3 class="mb-0">{{ $task->name }}</h3>
        <span class="badge bg-{{ $task->priority_color }}">{{ ucfirst($task->priority) }}</span>
    </div>
    <div class="card-body">
        <ul class="list-unstyled">
            <li class="mb-2">
                <strong>Status:</strong> 
                <span class="badge bg-{{ $task->status_color }}">{{ ucfirst(str_replace('-', ' ', $task->status)) }}</span>
            </li>
            <li class="mb-2">
                <strong>Utworzone:</strong> 
                <span>{{ $task->created_at->format('d/m/Y') }}</span>
            </li>
            <li class="mb-2">
                <strong>Opis:</strong> 
                <span>{{ $task->description ?: 'Brak opisu' }}</span>
            </li>
            <li class="mb-2">
                <strong>Termin:</strong> 
                <span class="text-danger">{{ $task->due_date->format('d/m/Y') }}</span>
            </li>
        </ul>
    </div>
    <div class="card-footer bg-light d-flex justify-content-end">
        <button class="btn btn-sm btn-warning me-2" id="edit-task" data-id="{{ $task->id }}">
            <i class="fas fa-edit"></i> Edytuj
        </button>
        <button class="btn btn-sm btn-danger" id="delete-task" data-id="{{ $task->id }}">
            <i class="fas fa-trash"></i> Usuń
        </button>
    </div>
</div>
