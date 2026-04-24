<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IRDCRP - Integrated Rurban Development and Climate Resilience Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background:#0A3D62;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            IRDCRP
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="/components">Components</a></li>
                <li class="nav-item"><a class="nav-link" href="/areas">Project Areas</a></li>
                <li class="nav-item"><a class="nav-link" href="/news">News</a></li>
                <li class="nav-item"><a class="nav-link" href="/procurement">Procurement</a></li>
                <li class="nav-item"><a class="nav-link" href="/downloads">Downloads</a></li>
                <li class="nav-item"><a class="nav-link" href="/grm">GRM</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer class="text-white mt-5 py-4" style="background:#0A3D62;">
    <div class="container text-center">
        <p class="mb-1 fw-bold">Integrated Rurban Development and Climate Resilience Project</p>
        <p class="mb-0">© {{ date('Y') }} IRDCRP. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>