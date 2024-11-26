<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editTaskForm">
                @csrf
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edytuj Zadanie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nazwa</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                        <div class="invalid-feedback" id="error-edit-name"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-description" class="form-label">Opis</label>
                        <textarea class="form-control" id="edit-description" name="description"></textarea>
                        <div class="invalid-feedback" id="error-edit-description"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-priority" class="form-label">Priorytet</label>
                        <select class="form-select" id="edit-priority" name="priority" required>
                            <option value="low">Niski</option>
                            <option value="medium">Średni</option>
                            <option value="high">Wysoki</option>
                        </select>
                        <div class="invalid-feedback" id="error-edit-priority"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-status" class="form-label">Status</label>
                        <select class="form-select" id="edit-status" name="status" required>
                            <option value="to-do">Do zrobienia</option>
                            <option value="in-progress">W trakcie</option>
                            <option value="done">Zakończone</option>
                        </select>
                        <div class="invalid-feedback" id="error-edit-status"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-due-date" class="form-label">Termin</label>
                        <input type="date" class="form-control" id="edit-due-date" name="due_date" required>
                        <div class="invalid-feedback" id="error-edit-due-date"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                </div>
            </form>
        </div>
    </div>
</div>
