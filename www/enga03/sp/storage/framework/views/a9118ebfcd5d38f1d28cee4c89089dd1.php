<h1>Seznam kurzů</h1>
<a href="<?php echo e(route('courses.create')); ?>">Nový kurz</a>
<ul>
<?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li><?php echo e($course->name); ?> – <?php echo e($course->description); ?></li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/semestralka/resources/views/courses/index.blade.php ENDPATH**/ ?>