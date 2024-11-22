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
    
    
});
