<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - KelasKita 2.0</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Admin Panel</span>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 bg-light vh-100">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.kelola.kelas') }}">Kelola Kelas</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-10">
                @yield('content')
            </div>
        </div>
    </div>

</body>
</html>