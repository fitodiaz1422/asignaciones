<?php if(session()->has('info')): ?>
    <div class="alert <?php echo e(session('color')); ?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?php echo e(session('info')); ?>

    </div>    
<?php endif; ?>  
<?php if(session()->has('errors')): ?>
    <div class="alert bg-red alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($message); ?><br>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>    
<?php endif; ?>   

 <?php /**PATH /app/resources/views/layouts/info-error.blade.php ENDPATH**/ ?>