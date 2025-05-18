<?php
     $userName = session('username');
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo e(route('home')); ?>">Rezervační Systém</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if(session()->has('user_id')): ?>

          <li class="nav-item dropdown ms-auto">
        <a class="dropdown-toggle d-flex align-items-center icon-link btn btn-secondary" href="#" role="button" data-bs-toggle="dropdown">
            <i class="fa-solid fa-user"></i>
            <?php echo e($userName); ?>

        </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?php echo e(route('user.profile')); ?>">Můj Profil</a></li>
                <li><a class="dropdown-item" href="/reservations">Moje Rezervace</a></li>
                <li><a class="dropdown-item" href="/reservations">Můj Business</a></li>
                     <li><hr class="dropdown-divider"></li>
                <li>
                    
                    <a class="dropdown-item icon-link" href="<?php echo e(route('logout')); ?>"><i class="fa-solid fa-right-from-bracket"></i> Odhlásit se</a>
                </li>
            </ul>
        </li>
        <?php else: ?>
          <li class="nav-item">
           
            <a class="nav-link icon-link" href="<?php echo e(route('login')); ?>"> <i class="fa-solid fa-right-to-bracket"></i> Přihlášení</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav><?php /**PATH C:\xampp\htdocs\rezervacni system\rezervacni_system\resources\views/partials/nav.blade.php ENDPATH**/ ?>