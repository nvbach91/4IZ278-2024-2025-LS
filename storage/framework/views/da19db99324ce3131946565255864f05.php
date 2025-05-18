<h1>Nový kurz</h1>
<form method="POST" action="<?php echo e(route('courses.store')); ?>">
    <?php echo csrf_field(); ?>
    <input type="text" name="name" placeholder="Název kurzu">
    <textarea name="description" placeholder="Popis kurzu"></textarea>
    <button type="submit">Uložit</button>
</form><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/semestralka/resources/views/courses/create.blade.php ENDPATH**/ ?>