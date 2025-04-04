<?php require_once __DIR__ . '/incl/header.php'; ?>

<main class="container mt-4">
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