

<?php $__env->startSection('title', 'Můj profil | Rezervační systém'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-8">
                        <div class="border rounded p-4 bg-light shadow-sm">
<h2>Můj Profil</h2>
<hr>
<form class="row g-3">
     <div class="col-12">
    <label for="name" class="form-label">Jméno</label>
    <input type="text" class="form-control" id="name" name="name" readonly>
  </div> 
  <div class="col-12">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" readonly>
  </div>
  <button type="button" class="btn btn-outline-danger">Smazat účet</button>
  <div class="text-end">
    <button type="button" class="btn btn-secondary">Zrušit</button>
    <button type="submit" class="btn btn-primary">Změnit</button>
  </div>
</form>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-8">
                        <div class="border rounded p-4 bg-light shadow-sm">
<h2>Moje Rezervace</h2>
<hr>

            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-8">
                        <div class="border rounded p-4 bg-light shadow-sm">
<h2>Můj Business</h2>
<hr>

<?php if (! (Auth::user()->ownedBusiness())): ?>
    <a href="<?php echo e(route('business.create')); ?>" type="button" class="btn btn-primary w-100">Vytvořit Business</a>
<?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/profile.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezervacni system\rezervacni_system\resources\views/user/profile.blade.php ENDPATH**/ ?>