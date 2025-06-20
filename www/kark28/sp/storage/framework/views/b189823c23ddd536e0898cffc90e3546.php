


<?php $__env->startSection('title', 'Rezervační systém'); ?>
<?php $__env->startSection('content'); ?>

    <div class="container mt-5">
        <form method="GET" action="<?php echo e(route('home')); ?>" class="mb-4">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Hledat podnik..."
                        value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-4">
                    <select name="sort" class="form-select">
                        <option value="newest" <?php echo e(request('sort', 'newest') == 'newest' ? 'selected' : ''); ?>>Nejnovější
                        </option>
                        <option value="name_asc" <?php echo e(request('sort') == 'name_asc' ? 'selected' : ''); ?>>Název A-Z</option>
                        <option value="name_desc" <?php echo e(request('sort') == 'name_desc' ? 'selected' : ''); ?>>Název Z-A</option>
                        <option value="rating_desc" <?php echo e(request('sort') == 'rating_desc' ? 'selected' : ''); ?>>Nejlépe
                            hodnocené</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filtrovat</button>
                </div>
            </div>
        </form>

        <div class="row">
            <?php $__currentLoopData = $businesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://placehold.co/300x150" class="card-img-top" alt="Business image">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo e($business->name); ?></h5>

                            <p class="card-text"><?php echo e(Str::limit($business->description, 100)); ?></p>
                            <p class="text-muted mb-1">Vlastník:
                                <strong><?php echo e($business->business_managers->first()?->user->name ?? 'Neznámý'); ?></strong></p>
                            <?php
                                $avgRating = $business->reviews->avg('rating');
                            ?>

                            <div class="mb-2 text-warning">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= round($avgRating)): ?>
                                        ★
                                    <?php else: ?>
                                        ☆
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span class="text-muted small">(<?php echo e(number_format($avgRating, 1) ?? '0.0'); ?>)</span>
                            </div>


                            <a href="<?php echo e(route('business.show', ['id' => $business->id])); ?>"
                                class="btn btn-primary mt-auto">View Profile</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($businesses->appends(request()->query())->links()); ?>


            </div>

        </div>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezervacni system\rezervacni_system\resources\views/home.blade.php ENDPATH**/ ?>