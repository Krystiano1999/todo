<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="createTaskForm" data-url="{{ route('tasks.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">Dodaj zadanie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nazwa zadania</label>
                        <input type="text" name="name" id="name" class="form-control" maxlength="255" required>
                        <div class="invalid-feedback" id="error-name"></div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Opis</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                        <div class="invalid-feedback" id="error-description"></div>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priorytet</label>
                        <select name="priority" id="priority" class="form-select" required>
                            <option value="low" selected>Niski</option>
                            <option value="medium">Średni</option>
                            <option value="high">Wysoki</option>
                        </select>
                        <div class="invalid-feedback" id="error-priority"></div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="to-do" selected>Do zrobienia</option>
                            <option value="in-progress">W trakcie</option>
                            <option value="done">Zakończone</option>
                        </select>
                        <div class="invalid-feedback" id="error-status"></div>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Termin wykonania</label>
                        <input type="date" name="due_date" id="due_date" class="form-control" required>
                        <div class="invalid-feedback" id="error-due_date"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                    <button type="submit" class="btn btn-primary">Dodaj zadanie</button>
                </div>
            </form>
        </div>
    </div>
</div>