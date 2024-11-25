@extends('layouts.app')

@section('title', 'Lista zadań')

@section('content')
<div class="row">
    <div class="col-md-4 p-3 shadow-sm overflow-auto me-4 custom-border ">
        <h2 class="mb-3">Moje zadania</h2>
        <ul class="list-group" id="task-list">
            @each('tasks.partials.task_item', $tasks, 'task')
        </ul>
    </div>

    <div class="col-md-7 p-3 shadow-sm d-flex flex-column justify-content-between custom-border" id="task-details">
        @if($tasks->isNotEmpty())
            @include('tasks.partials.task_details', ['task' => $tasks->first()])
        @else
            <p class="text-muted">Brak zadań do wyświetlenia.</p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/task.js') }}"></script>
@endpush