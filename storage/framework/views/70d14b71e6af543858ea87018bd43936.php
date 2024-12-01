<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predicciones</title>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('logo-liga_mx.png')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Captura de Resultados</h1>
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <form method="POST" action="<?php echo e(route('admin.results.submit')); ?>">
            <?php echo csrf_field(); ?>
            <?php $__currentLoopData = ['Quarters', 'Semifinals', 'Final']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($matches[$phase])): ?>
                    <h2 class="text-center mt-5"><?php echo e($phase); ?></h2>
                    <div class="row">
                        <?php $__currentLoopData = $matches[$phase]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <h4><?php echo e($match->team_a); ?> VS <?php echo e($match->team_b); ?></h4>
                                        <div class="row mt-3">
                                            <div class="col-5">
                                                <label><?php echo e($match->team_a); ?></label>
                                                <input type="number" class="form-control" name="results[<?php echo e($match->id); ?>][score_a]" value="<?php echo e($match->score_a ?? ''); ?>">
                                            </div>
                                            <div class="col-2 text-center align-self-center">VS</div>
                                            <div class="col-5">
                                                <label><?php echo e($match->team_b); ?></label>
                                                <input type="number" class="form-control" name="results[<?php echo e($match->id); ?>][score_b]" value="<?php echo e($match->score_b ?? ''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <button type="submit" class="btn btn-success">Guardar Resultados</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html<?php /**PATH /Users/hectortorres/Proyectos/quinielaTeiker/resources/views/admin/results.blade.php ENDPATH**/ ?>