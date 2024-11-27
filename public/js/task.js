document.addEventListener('DOMContentLoaded', function () {
    const taskList = document.getElementById('task-list');
    const taskDetails = document.getElementById('task-details');

    async function fetchHtml(url) {
        try {
            const response = await fetch(url);
            return await response.text();
        } catch (error) {
            console.error('Błąd podczas pobierania danych:', error);
        }
    }

    async function fetchJson(url) {
        try {
            const response = await fetch(url);
            return await response.json();
        } catch (error) {
            console.error('Błąd podczas pobierania JSON:', error);
        }
    }

    async function refreshTaskList() {
        const html = await fetchHtml('/tasks-list');
        if (html) {
            taskList.innerHTML = html;
            attachTaskItemClickListeners();
        }
    }

    async function refreshTaskDetails(taskId) {
        const data = await fetchJson(`/tasks/${taskId}`);
        if (data) {
            taskDetails.innerHTML = `
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">${data.name}</h3>
                        <span class="badge bg-${data.priority_color}">${data.priority}</span>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Status:</strong>
                                <span class="badge bg-${data.status_color}">${data.status}</span>
                            </li>
                            <li class="mb-2">
                                <strong>Utworzone:</strong>
                                <span>${data.created_at}</span>
                            </li>
                            <li class="mb-2">
                                <strong>Opis:</strong>
                                <span>${data.description || 'Brak opisu'}</span>
                            </li>
                            <li class="mb-2">
                                <strong>Termin:</strong>
                                <span class="text-danger">${data.due_date}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-end">
                        <button class="btn btn-sm btn-warning me-2" id="edit-task" data-id="${data.id}">
                            <i class="fas fa-edit"></i> Edytuj
                        </button>
                        <button class="btn btn-sm btn-danger" id="delete-task" data-id="${data.id}">
                            <i class="fas fa-trash"></i> Usuń
                        </button>
                    </div>
                </div>
            `;
        } else {
            taskDetails.innerHTML = '<p class="text-muted">Zadanie nie istnieje.</p>';
        }
    }

    function attachTaskItemClickListeners() {
        const taskItems = document.querySelectorAll('.task-item');
        taskItems.forEach(item => {
            item.addEventListener('click', function () {
                taskItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                refreshTaskDetails(this.dataset.id);
            });
        });
    }

    document.body.addEventListener('click', async function (e) {
        if (e.target && e.target.id === 'delete-task') {
            const taskId = e.target.dataset.id;

            Swal.fire({
                title: 'Czy na pewno chcesz usunąć?',
                text: 'Nie będziesz mógł tego cofnąć!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Usuń',
                cancelButtonText: 'Anuluj',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/tasks/${taskId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                        });

                        if (!response.ok) throw new Error('Błąd podczas usuwania zadania.');

                        toastr.success("Zadanie zostało usunięte");
                        await refreshTaskList();

                        const firstTask = document.querySelector('.task-item');
                        if (firstTask) {
                            firstTask.classList.add('active');
                            refreshTaskDetails(firstTask.dataset.id);
                        } else {
                            taskDetails.innerHTML = '<p class="text-muted">Brak zadań do wyświetlenia.</p>';
                        }
                    } catch (error) {
                        console.error('Błąd:', error);
                        Swal.fire('Błąd!', 'Nie udało się usunąć zadania.', 'error');
                    }
                }
            });
        }
    });

    attachTaskItemClickListeners();

    // Updated task
    document.body.addEventListener('click', async function (e) {
        if (e.target && e.target.id === 'edit-task') {
            const taskId = e.target.dataset.id;
            openEditModal(taskId);
        }
    });

    async function openEditModal(taskId) {
        const task = await fetchJson(`/tasks/${taskId}`);
        
        if (task) {
            const form = document.getElementById('editTaskForm');
            document.getElementById('edit-id').value = task.id || '';
            document.getElementById('edit-name').value = task.name || '';
            document.getElementById('edit-description').value = task.description || '';
            document.getElementById('edit-priority').value = task.priority || 'low';
            document.getElementById('edit-status').value = task.status || 'pending';
            document.getElementById('edit-due-date').value = convertDateToISO(task.due_date);
            new bootstrap.Modal(document.getElementById('editTaskModal')).show();
        }
    }

    document.getElementById('editTaskForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const id = formData.get('id');
        const url = `/tasks/${id}`;
    
        const formObject = Object.fromEntries(formData.entries());
    
        try {
            const response = await fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(formObject),
            });
    
            const result = await response.json();
    
            if (response.ok) {
                toastr.success(result.message);
    
                if (result.task_list_html) {
                    taskList.innerHTML = result.task_list_html;
                    attachTaskItemClickListeners();
                }
    
                refreshTaskDetails(result.data.id);
    
                const modal = bootstrap.Modal.getInstance(document.getElementById('editTaskModal'));
                modal.hide();
            } else if (result.errors) {
                handleValidationErrors(result.errors);
            } else {
                toastr.error(result.message || 'Wystąpił nieoczekiwany błąd.');
            }
        } catch (error) {
            toastr.error('Wystąpił błąd podczas przetwarzania żądania.');
        }
    });
    
    function handleValidationErrors(errors) {
        Object.keys(errors).forEach(key => {
            const input = document.getElementById(`edit-${key}`);
            const errorDiv = document.getElementById(`error-edit-${key}`);
            input.classList.add('is-invalid');
            errorDiv.textContent = errors[key][0];
        });
    }

    function convertDateToISO(date) {
        if (!date) return '';
        const [day, month, year] = date.split('/');
        return `${year}-${month}-${day}`; //YYYY-MM-DD
    }


    document.getElementById('filterForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        applyFilters(formData);


        bootstrap.Modal.getInstance(document.getElementById('filterModal')).hide();
    });

    async function applyFilters(formData) {
        const queryString = new URLSearchParams(formData).toString();
        const url = `/tasks-list?${queryString}`;
    
        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });
    
            if (!response.ok) throw new Error('Error fetching filtered tasks.');
    
            const result = await response.json();
    
            if (result.success) {
                taskList.innerHTML = result.html;
    
                attachTaskItemClickListeners();
    
                const firstTask = document.querySelector('.task-item');
                if (firstTask) {
                    firstTask.classList.add('active');
                    refreshTaskDetails(firstTask.dataset.id);
                } else {
                    taskDetails.innerHTML = '<p class="text-muted">Brak zadań do wyświetlenia.</p>';
                }
            } else {
                toastr.error('Failed to load filtered tasks.');
            }
        } catch (error) {
            console.error('Error:', error);
            toastr.error('An error occurred while fetching filtered tasks.');
        }
    }
    
    
});
