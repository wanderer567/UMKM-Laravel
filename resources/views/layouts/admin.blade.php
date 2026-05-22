<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

   <style>
    :root {
        --primary-gradient: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        --sidebar-bg: #1e1e2f;
        --main-bg: #f4f7fe;
    }
    
    body { background-color: var(--main-bg); font-family: 'figtree', sans-serif; }
    
    /* Sidebar Styling */
    .sidebar { 
        width: 260px; 
        height: 100vh; 
        position: fixed; 
        top: 0; 
        left: 0; 
        background: var(--sidebar-bg); 
        z-index: 1000;
        transition: all 0.3s;
    }

    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.7);
        margin: 5px 15px;
        border-radius: 10px;
        padding: 12px 15px;
        transition: 0.3s;
    }

    .sidebar .nav-link:hover, .sidebar .nav-link.active {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .sidebar .nav-link i { margin-right: 10px; }

    /* Main Content */
    .main-content { 
        margin-left: 260px;
        padding: 30px;
        min-height: 100vh;
    }

    .logout-btn {
        background: rgba(255, 59, 48, 0.1);
        color: #ff3b30;
        border: none;
        transition: 0.3s;
    }

    .logout-btn:hover { background: #ff3b30; color: white; }

    @media (max-width: 768px) {
        .sidebar { margin-left: -260px; }
        .main-content { margin-left: 0; }
    }
</style>
</head>
<body>

    @include('components.sidebar')

    <div class="main-content">
        <div class="container-fluid"> {{-- Pakai container-fluid agar tabel simetris --}}
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>