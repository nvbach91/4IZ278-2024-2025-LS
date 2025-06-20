<?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
    window.SERVER_NOW = <?php echo json_encode(\Carbon\Carbon::now()->toIso8601String(), 15, 512) ?>;
    const BASE_URL = "<?php echo e(url('')); ?>";
    const CONFIRM_RESERVATION_URL = "<?php echo e(route('reservation.confirm')); ?>";
</script>
<?php echo $__env->make('partials.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Zavřít"></button>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Zavřít"></button>
    </div>
<?php endif; ?>

<div class="container mt-4">
    <?php echo $__env->yieldContent('content'); ?>
</div>

<?php echo $__env->make('layouts.overlay', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php echo $__env->yieldPushContent('scripts'); ?>
<?php /**PATH C:\xampp\htdocs\rezervacni system\rezervacni_system\resources\views/layouts/app.blade.php ENDPATH**/ ?>