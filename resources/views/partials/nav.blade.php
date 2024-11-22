
<div class="nav flex-column h-100 p-3 position-relative bg-primary ">
    <div class="text-center mb-4 user-data">
        <div class="user-photo d-flex justify-content-center align-items-center bg-primary text-white rounded-circle">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

        <h5 class="user-name mt-2 mb-1">{{ auth()->user()->name }}</h5>
        <p class="user-email mb-0">{{ auth()->user()->email }}</p>
    </div>
    <nav>
        <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a href="" class="nav-link d-flex align-items-center">
            <i class="fas fa-list me-2"></i> Lista zadań
        </a>
        <a href="#" class="nav-link d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createTaskModal">
            <i class="fas fa-plus-circle me-2"></i> Dodaj zadanie
        </a>
        @include('tasks.create_modal')
        <a href="" class="nav-link d-flex align-items-center">
            <i class="fas fa-user-circle me-2"></i> Profil
        </a>
        <a href="{{ route('logout') }}" class="nav-link d-flex align-items-center logout">
            <i class="fas fa-sign-out-alt me-2"></i> Wyloguj się
        </a>
    </nav>
    
</div>
