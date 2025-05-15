<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        li {
            list-style: none;
            margin-bottom: 10px;
        }

        .todo-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .todo-item form {
            display: inline;
            margin: 0;
        }

        .todo-item button {
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <h1>My todo list</h1>
    <form method="POST" action="<?php echo e(route('saveTodo')); ?>">
        <?php echo csrf_field(); ?>
        <input placeholder="title" name="title">
        <button>Submit</button>
    </form>

    <?php if($errors->has('title')): ?>
        <p style="background-color: red"><?php echo e($errors->first('title')); ?></p>
    <?php endif; ?>

    <ul>
    <?php $__currentLoopData = $todos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $todo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <div class="todo-item">
                <form method="POST" action="<?php echo e(route('deleteTodo', $todo->id)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button>Delete</button>
                </form>

                <div><?php echo e($todo->id); ?> <?php echo e($todo->title); ?></div>

                <?php if($todo->finished == 1): ?>
                    <form method="POST" action="<?php echo e(route('unfinishTodo', $todo->id)); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                        <button>Unfinish</button>
                    </form>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('finishTodo', $todo->id)); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                        <button>Finish</button>
                    </form>
                <?php endif; ?>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</body>
</html><?php /**PATH C:\xampp\htdocs\cvičení\cv12\laravel\resources\views/todo.blade.php ENDPATH**/ ?>