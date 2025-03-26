<?php require_once __DIR__ . '/incl/header.php'; ?>
<body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#!">Shop</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#!">
                                Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>

<main class="container mt-4">
<body>
  <div class="row">
    <aside class="col-lg-3 mb-4">
      <?php require_once __DIR__ . '/components/CategoryDisplay.php'; ?>
    </aside>
    <section class="col-lg-9">
      <div class="col-lg-9">
        <?php require_once __DIR__ . '/components/SlideDisplay.php'; ?>
      </div>
      <?php require_once __DIR__ . '/components/ProductDisplay.php'; ?>
    </section>

  </div>
</main>

<?php require_once __DIR__ . '/incl/footer.php'; ?>