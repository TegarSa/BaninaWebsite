<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel BANINA</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --admin-black: #0a0a0a;
            --admin-black-light: #1e1e1e;
            --admin-gold: #7a8c2a;
            --admin-gold-light: #9aad3a;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        /* Layout Admin Structure */
        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        #main-content {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }

        .container-fluid-content {
            flex: 1;
            padding: 2rem;
        }

        /* Custom Global Elements */
        .btn-gold {
            background: linear-gradient(135deg, var(--admin-black), var(--admin-black-light));
            color: var(--admin-gold-light);
            border: 1px solid rgba(122, 140, 42, 0.3);
            font-weight: 500;
        }
        .btn-gold:hover {
            opacity: 0.9;
            color: var(--admin-gold);
        }
        
        .badge-gold {
            background-color: #fef9c3;
            color: #713f12;
            border: 1px solid #fef08a;
        }

        /* Responsiveness Fix */
        @media (max-width: 768px) {
            .container-fluid-content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

    <div id="wrapper">
        <!-- Sidebar -->
        @include('dashboard.layouts.sidebar')

        <!-- Right Side (Navbar + Content + Footer) -->
        <div id="main-content">
            <!-- Navbar -->
            @include('dashboard.layouts.navbar')

            <!-- Main Dynamic Content -->
            <div class="container-fluid-content">
                <h2 class="fw-bold text-dark mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: 0.5px;">@yield('title')</h2>
                @yield('content')
            </div>

            <!-- Footer -->
            @include('dashboard.layouts.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>
