<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column">
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <a href="#" class="navbar-brand">MyCRM</a>
        </div>
    </nav>

    <section class="container mb-5">
        <div id="welcomeCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="carousel-item {{ $i === 1 ? 'active' : '' }}">
                        <img src="{{ asset("images/landing-$i.jpg") }}" class="d-block w-100" alt="slide {{ $i }}" style="height: 360px; object-fit: cover;">
                    </div>
                @endfor
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section class="container text-center">
        <h1 class="display-5 mb-3">Welcome</h1>
        <p class="lead">Your Laravel application is running.</p>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('welcomeCarousel');
            if (el) new bootstrap.Carousel(el);
        });
    </script>
</body>
</html>
