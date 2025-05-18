<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Vítej v CRM platformě!</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white shadow rounded-2xl p-4 border border-gray-200">
                <h2 class="text-xl font-semibold mb-2"><?php echo e($course->name ?? 'Název kurzu'); ?></h2>
                <p class="text-gray-600 mb-2"><?php echo e($course->description ?? 'Popis není dostupný'); ?></p>
                <p class="text-sm text-gray-500">Lekcí: <?php echo e($course->lessons->count()); ?></p>

                <?php
                    $homeworkCount = $course->lessons->reduce(fn($carry, $lesson) => $carry + $lesson->homework->count(), 0);
                ?>
                <p class="text-sm text-gray-500">Domácích úkolů: <?php echo e($homeworkCount); ?></p>

                <a href="<?php echo e(route('courses.index')); ?>" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-medium">Zobrazit všechny kurzy</a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/semestralka/resources/views/home.blade.php ENDPATH**/ ?>