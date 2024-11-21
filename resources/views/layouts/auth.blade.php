<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth d-flex justify-content-center align-items-center">
    <div class="auth-container">
        <div class="auth-content">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script>toastr.options={progressBar:true,}</script>
    <script>
        window.sessionSuccess = @json(session('success'));
        window.sessionError = @json(session('error'));
        window.validationErrors = @json($errors->all());
    </script>
    
    @stack('scripts')
</body>
</html>
