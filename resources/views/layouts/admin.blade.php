<!DOCTYPE html>
<html>
<head>
    <title>Sun City's Polyclinic & Family Clinic</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            border: none;
        }
        .card-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            background-color: #fff;
            border-bottom: 1px solid #f0f0f0;
        }
        .text-danger {
            color: #e74a3b !important;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-secondary {
            background-color: #858796;
            border-color: #858796;
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <main role="main">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>