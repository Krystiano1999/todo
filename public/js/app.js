document.addEventListener('DOMContentLoaded', function () {
    if (window.sessionSuccess) {
        toastr.success(window.sessionSuccess);
    }

    if (window.sessionError) {
        toastr.error(window.sessionError);
    }

    if (window.validationErrors && window.validationErrors.length) {
        window.validationErrors.forEach(function (error) {
            toastr.error(error);
        });
    }


    document.getElementById('createTaskForm').addEventListener('submit', async function (e) {
        e.preventDefault();
    
        const formData = new FormData(this);
        const url = this.getAttribute('data-url'); 
    
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData,
            });
    
            const result = await response.json();
    
            if (response.ok) {
                toastr.success(result.message);
                const modal = bootstrap.Modal.getInstance(document.getElementById('createTaskModal'));
                modal.hide();
                this.reset();
                addTaskToList(result.data);
            } else if (result.errors) {
                Object.keys(result.errors).forEach(key => {
                    const input = document.getElementById(key);
                    const errorDiv = document.getElementById(`error-${key}`);
                    input.classList.add('is-invalid');
                    errorDiv.textContent = result.errors[key][0];
                });
            } else {
                toastr.error(result.message || 'Wystąpił nieoczekiwany błąd.');
            }
        } catch (error) {
            toastr.error('Wystąpił błąd podczas przetwarzania żądania.');
        }
    });
    
    function addTaskToList(task) {
        const taskList = document.getElementById('task-list');

        const taskItem = document.createElement('li');
        taskItem.className = 'list-group-item task-item my-1 d-block';
        taskItem.setAttribute('data-id', task.id);
        taskItem.innerHTML = `
            <p><strong>${task.name}</strong></p>
            <p>
                <span class="badge text-${task.priority_color || 'primary'} float-start">Priorytet: ${task.priority}</span>
                <span class="badge text-${task.status_color || 'secondary'} float-end">Status: ${task.status}</span>
            </p>
        `;

        taskItem.addEventListener('click', function () {
            const taskItems = document.querySelectorAll('.task-item');
            taskItems.forEach(item => item.classList.remove('active'));
            this.classList.add('active');
            refreshTaskDetails(task.id);
        });

        taskList.prepend(taskItem);

        refreshTaskDetails(task.id);
    }

    async function refreshTaskDetails(taskId) {
        const data = await fetchJson(`/tasks/${taskId}`);
        if (data) {
            const taskDetails = document.getElementById('task-details');
            taskDetails.innerHTML = `
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">${data.name}</h3>
                        <span class="badge bg-${data.priority_color || 'primary'}">${data.priority}</span>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Status:</strong>
                                <span class="badge bg-${data.status_color || 'secondary'}">${data.status}</span>
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
        }
    }

    async function fetchJson(url) {
        try {
            const response = await fetch(url);
    
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
    
            return await response.json();
        } catch (error) {
            console.error('Błąd podczas pobierania JSON:', error);
            toastr.error('Błąd podczas przetwarzania żądania.');
        }
    }
    
});
