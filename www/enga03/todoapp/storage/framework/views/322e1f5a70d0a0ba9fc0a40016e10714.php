<h1>Todo list</h1>


<form method="POST" action="<?php echo e(route('saveTodo')); ?>" style="margin-bottom: 1.5em; display: flex; gap: 0.5em;">
    <?php echo csrf_field(); ?>
    <input 
        type="text" 
        name="title" 
        placeholder="Zadej název úkolu" 
        style="flex: 1; padding: 0.5em; border: 1px solid #ccc; border-radius: 4px;"
    >
    <button type="submit" style="padding: 0.5em 1em; border:none; background:#007bff; color:white; border-radius:4px;">
        Přidat
    </button>
</form>

<?php if($errors->has('title')): ?>
    <p style="color:red"><?php echo e($errors->first('title')); ?></p>
<?php endif; ?>

<ul style="list-style: none; padding: 0;">
    <?php $__currentLoopData = $todos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $todo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li style="margin-bottom: 1em;">
            
            <div 
                style="
                    padding: 0.75em; 
                    border-radius: 4px;
                    background-color: <?php echo e($todo->finished ? '#d4edda' : '#f8f9fa'); ?>;
                    border: 1px solid <?php echo e($todo->finished ? '#c3e6cb' : '#ddd'); ?>;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                "
            >
                <span><?php echo e($todo->id); ?>. <?php echo e($todo->title); ?></span>

                <div style="display: flex; gap: 0.5em;">
                    
                    <form method="POST" action="<?php echo e(route('deleteTodo', $todo->id)); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" style="padding: 0.25em 0.5em; border:none; background:#dc3545; color:white; border-radius:4px;">
                            Delete
                        </button>
                    </form>

                    
                    <?php if($todo->finished): ?>
                        <form method="POST" action="<?php echo e(route('unfinishTodo', $todo->id)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <button type="submit" style="padding: 0.25em 0.5em; border:none; background:#17a2b8; color:white; border-radius:4px;">
                                Unfinish
                            </button>
                        </form>
                    <?php else: ?>
                        <form method="POST" action="<?php echo e(route('finishTodo', $todo->id)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <button type="submit" style="padding: 0.25em 0.5em; border:none; background:#28a745; color:white; border-radius:4px;">
                                Finish
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/cv12/todoapp/resources/views/todos.blade.php ENDPATH**/ ?>