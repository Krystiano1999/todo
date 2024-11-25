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

                        //Swal.fire('Usunięto!', 'Zadanie zostało usunięte.', 'success');
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
});
