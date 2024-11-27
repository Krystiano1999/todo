@extends('layouts.app')

@section('title', 'Lista zadań')

@section('content')
<div class="row">
    <div class="col-md-4 p-3 shadow-sm overflow-auto me-4 custom-border ">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Moje zadania</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter"></i> Filtruj
            </button>
        </div>
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
@include('tasks.filter_modal')
@include('tasks.edit_modal')
@endsection

@push('scripts')
<script src="{{ asset('js/task.js') }}"></script>
@endpush