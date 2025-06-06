

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
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?php echo e($user->name); ?>" readonly>

                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="<?php echo e($user->email); ?>" readonly>

                        </div>
                        <button type="button" class="btn btn-outline-danger">Smazat účet</button>
                        <div class="text-end">
                            <!--<button type="button" class="btn btn-secondary">Zrušit</button>
                                            <button type="submit" class="btn btn-primary">Změnit</button> -->
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
                    <h2>Aktivní Rezervace</h2>
                    <hr>

                    <?php $__empty_1 = true; $__currentLoopData = $activeReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="border rounded p-3 mb-3 bg-white shadow-sm">
                            <p><strong>ID rezervace:</strong> <?php echo e($reservation->id); ?></p>
                            <p><strong>Status:</strong> <?php echo e($statusTranslations[$reservation->status] ?? 'Neznámý'); ?></p>
                            <p><strong>Vytvořeno:</strong>
                                <?php echo e($reservation->created_at?->format('d.m.Y H:i') ?? 'N/A'); ?>

                            </p>

                            <?php if($reservation->timeslot): ?>
                                <p><strong>Čas rezervace:</strong>
                                    <?php echo e($reservation->timeslot->start_time->format('d.m.Y H:i')); ?>

                                    –
                                    <?php echo e($reservation->timeslot->end_time->format('H:i')); ?>

                                </p>
                                <p><strong>Business:</strong>
                                    <?php echo e($reservation->timeslot->service->business->name ?? 'Neznámý business'); ?>

                                </p>
                                <p><strong>Služba:</strong>
                                    <?php echo e($reservation->timeslot->service->name ?? 'Neznámá služba'); ?>

                                </p>
                            <?php else: ?>
                                <p class="text-muted">Tato rezervace nemá přiřazený časový slot.</p>
                            <?php endif; ?>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p>Nemáte žádné aktivní rezervace.</p>
                    <?php endif; ?>

                    <h2>Minulé Rezervace</h2>
                    <hr>

                    <?php $__empty_1 = true; $__currentLoopData = $pastReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="border rounded p-3 mb-3 bg-white shadow-sm">
                            <p><strong>ID rezervace:</strong> <?php echo e($reservation->id); ?></p>

                            <p><strong>Status:</strong> <?php echo e($statusTranslations[$reservation->status] ?? 'Neznámý'); ?></p>
                            <p><strong>Vytvořeno:</strong>
                                <?php echo e($reservation->created_at?->format('d.m.Y H:i') ?? 'N/A'); ?>

                            </p>

                            <?php if($reservation->timeslot): ?>
                                <p><strong>Čas rezervace:</strong>
                                    <?php echo e($reservation->timeslot->start_time->format('d.m.Y H:i')); ?>

                                    –
                                    <?php echo e($reservation->timeslot->end_time->format('H:i')); ?>

                                </p>
                                <p><strong>Business:</strong>
                                    <?php echo e($reservation->timeslot->service->business->name ?? 'Neznámý business'); ?>

                                </p>
                                <p><strong>Služba:</strong>
                                    <?php echo e($reservation->timeslot->service->name ?? 'Neznámá služba'); ?>

                                </p>
                            <?php else: ?>
                                <p class="text-muted">Tato rezervace nemá přiřazený časový slot.</p>
                            <?php endif; ?>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p>Nemáte žádné předešlé rezervace.</p>
                    <?php endif; ?>
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
                        <a href="<?php echo e(route('business.create')); ?>" type="button" class="btn btn-primary w-100">Vytvořit
                            Business</a>
                    <?php endif; ?>
                    <?php if(Auth::user()->ownedBusiness()): ?>
                        <a href="<?php echo e(route('business.show', Auth::user()->ownedBusiness()->id)); ?>"
                            class="d-flex align-items-center icon-link btn btn-secondary">
                            <i class="fa-solid fa-briefcase"></i>
                            <?php echo e(Auth::user()->ownedBusiness()->name); ?>

                        </a>
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