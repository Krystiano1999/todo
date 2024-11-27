<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="filterForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filtruj zadania</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="filter-priority" class="form-label">Priorytet</label>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="priority[]" value="low" id="priorityLow">
                                <label class="form-check-label" for="priorityLow">Niski</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="priority[]" value="medium" id="priorityMedium">
                                <label class="form-check-label" for="priorityMedium">Średni</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="priority[]" value="high" id="priorityHigh">
                                <label class="form-check-label" for="priorityHigh">Wysoki</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="filter-status" class="form-label">Status</label>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="to-do" id="statusPending">
                                <label class="form-check-label" for="statusPending">Oczekujące</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="in-progress" id="statusInProgress">
                                <label class="form-check-label" for="statusInProgress">W trakcie</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]" value="done" id="statusCompleted">
                                <label class="form-check-label" for="statusCompleted">Zakończone</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="filter-due-date-from" class="form-label">Termin od</label>
                        <input type="date" class="form-control" name="due_date_from" id="filter-due-date-from">
                    </div>
                    <div class="mb-3">
                        <label for="filter-due-date-to" class="form-label">Termin do</label>
                        <input type="date" class="form-control" name="due_date_to" id="filter-due-date-to">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Filtruj</button>
                </div>
            </form>
        </div>
    </div>
</div>
