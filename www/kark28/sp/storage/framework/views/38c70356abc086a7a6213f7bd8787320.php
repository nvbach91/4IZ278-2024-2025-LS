<?php $__env->startSection('title', 'Můj profil | Rezervační systém'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="border rounded p-4 bg-light shadow-sm">
                    <h2 id="profile">Můj Profil</h2>
                    <hr>
                    <form class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Jméno</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?php echo e($user->name); ?>" readonly disabled>

                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="<?php echo e($user->email); ?>" readonly
                                disabled>

                        </div>
                        <button type="button" class="btn btn-outline-danger" onclick="confirmAccountDeletion()">Smazat
                            účet</button>
                        <div class="text-end">

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
                    <h2 id="reservations">Aktivní Rezervace</h2>
                    <hr>

                    <?php $__empty_1 = true; $__currentLoopData = $activeReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="border rounded p-3 mb-3 bg-white shadow-sm">

                            
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="mb-0">
                                    <span>ID rezervace:</span> <?php echo e($reservation->id); ?>

                                </p>
                                <span
                                    class="badge bg-<?php echo e(match ($reservation->status) {
                                        'pending' => 'warning',
                                        'confirmed' => 'success',
                                        'completed' => 'primary',
                                        'cancelled' => 'danger',
                                        default => 'light',
                                    }); ?>">
                                    <?php echo e(ucfirst($reservation->status)); ?>

                                </span>
                            </div>

                            
                            <p class="fw-semibold fs-5 mb-1">
                                <?php echo e($reservation->timeslot->service->business->name ?? 'Neznámý business'); ?>

                            </p>
                            <p class="mb-2">
                                <?php echo e($reservation->timeslot->service->name ?? 'Neznámá služba'); ?>

                            </p>

                            
                            <?php if(!empty($reservation->timeslot->service->price)): ?>
                                <p class="mb-2">
                                    Cena: <?php echo e(number_format($reservation->timeslot->service->price, 0, ',', ' ')); ?> Kč
                                </p>
                            <?php endif; ?>


                            
                            <?php if($reservation->timeslot): ?>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0 fw-semibold text-primary">
                                        <span>Čas rezervace:</span>
                                        <?php echo e($reservation->timeslot->start_time->format('d.m.Y H:i')); ?> –
                                        <?php echo e($reservation->timeslot->end_time->format('H:i')); ?>

                                    </p>
                                    <p class="mb-0 text-muted fst-italic small">
                                        Vytvořeno: <?php echo e($reservation->created_at?->format('d.m.Y H:i') ?? 'N/A'); ?>

                                    </p>
                                </div>
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
                            <div class="opacity-50">
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="mb-0">
                                        <span>ID rezervace:</span> <?php echo e($reservation->id); ?>

                                    </p>
                                    <span
                                        class="badge bg-<?php echo e(match ($reservation->status) {
                                            'pending' => 'warning',
                                            'confirmed' => 'success',
                                            'completed' => 'primary',
                                            'cancelled' => 'danger',
                                            default => 'light',
                                        }); ?>">
                                        <?php echo e(ucfirst($reservation->status)); ?>

                                    </span>
                                </div>

                                
                                <p class="fw-semibold fs-5 mb-1">
                                    <?php echo e($reservation->timeslot->service->business->name ?? 'Neznámý business'); ?>

                                </p>
                                <p class="mb-2">
                                    <?php echo e($reservation->timeslot->service->name ?? 'Neznámá služba'); ?>

                                </p>

                                
                                <?php if($reservation->timeslot): ?>
                                    <div class="d-flex justify-content-between align-items-start">
                                        <p class="mb-0 fw-semibold">
                                            <span>Čas rezervace:</span>
                                            <?php echo e($reservation->timeslot->start_time->format('d.m.Y H:i')); ?> –
                                            <?php echo e($reservation->timeslot->end_time->format('H:i')); ?>

                                        </p>

                                        <div class="text-end">
                                            <p class="mb-1 text-muted fst-italic small">
                                                Vytvořeno: <?php echo e($reservation->created_at?->format('d.m.Y H:i') ?? 'N/A'); ?>

                                            </p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">Tato rezervace nemá přiřazený časový slot.</p>
                                <?php endif; ?>
                            </div>

                            <?php if(!empty($reservation->show_review_button)): ?>
                                <div class="text-end mt-2">
                                    <a href="<?php echo e(route('reviews.create', ['business_id' => $reservation->timeslot->service->business->id])); ?>"
                                        class="btn btn-primary">
                                        Leave a Review
                                    </a>
                                </div>
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
                    <h2 id="business">Můj Business</h2>
                    <hr>

                    <?php
                        $myBusiness = Auth::user()->ownedBusiness();
                        $managed = Auth::user()->managedBusinesses();
                    ?>

                    
                    <?php if (! ($myBusiness)): ?>
                        <a href="<?php echo e(route('business.create')); ?>" type="button" class="btn btn-primary w-100 mb-3 text-center">
                            Vytvořit Business
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('business.show', $myBusiness->id)); ?>"
                            class="btn btn-secondary w-100 mb-3 text-center">
                            <i class="fa-solid fa-briefcase me-2"></i>
                            <?php echo e($myBusiness->name); ?>

                        </a>
                    <?php endif; ?>

                    
                    <h2 class="mt-4">Spravuji</h2>
                    <hr>

                    <?php $__empty_1 = true; $__currentLoopData = $managed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $biz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('business.show', $biz->id)); ?>"
                            class="btn btn-outline-secondary w-100 mb-2 text-center">
                            <i class="fa-solid fa-briefcase me-2"></i>
                            <?php echo e($biz->name); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted">Nejste manažerem žádného businessu.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.confirmAccountDeletion = async function() {
                const params = {
                    title: 'Smazat účet',
                    message: 'Opravdu chcete svůj účet smazat? Tato akce je nevratná.',
                    action: deleteProfileEndpoint,
                    method: 'DELETE',
                    confirmText: 'Smazat účet'
                };

                try {
                    const overlayUrl = new URL(overlayConfirmEndpoint, window.location.origin);
                    overlayUrl.search = new URLSearchParams(params).toString();

                    const response = await fetch(overlayUrl);
                    if (!response.ok) throw new Error(`Chyba: ${response.status}`);
                    const html = await response.text();
                    showOverlay(html);

                } catch (err) {
                    console.error(err);
                    alert('Nepodařilo se načíst potvrzovací dialog.');
                }
            };

            const overlayConfirmEndpoint = "<?php echo e(route('overlay.confirm')); ?>";
            const deleteProfileEndpoint = "<?php echo e(route('profile.destroy')); ?>";
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezervacni system\rezervacni_system\resources\views/user/profile.blade.php ENDPATH**/ ?>