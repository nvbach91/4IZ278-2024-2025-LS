

<?php $__env->startSection('title', 'Rezervační systém'); ?>

<?php $__env->startSection('content'); ?>

<div class="container mt-5">
    <div class="row">
        <?php for($i = 0; $i < 5; $i++): ?>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://placehold.co/300x150" class="card-img-top" alt="Business image">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Název Businessu</h5>
                        
                        <p class="card-text">Popisek</p>
                        <p class="text-muted mb-1">Vlastník: <strong>Jméno vlastníka</strong></p>
                        <!-- Rating (Static Stars) -->
                        <div class="mb-2 text-warning">
                            ★★★★☆ <span class="text-muted small">(4.0)</span>
                        </div>

                        <a href="#" class="btn btn-primary mt-auto">View Profile</a>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezervacni system\rezervacni_system\resources\views/home.blade.php ENDPATH**/ ?>