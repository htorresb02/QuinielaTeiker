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
	    <?php $__currentLoopData = ['Quarters', 'Semifinals', 'Final', 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($matches[$phase])): ?>
		    <h2 class="text-center mt-5">
                        <?php if($phase == 'Quarters'): ?> Cuartos de Final
                        <?php elseif($phase == 'Semifinals'): ?> Semifinales
                        <?php elseif($phase == 'Final'): ?> Final
                        <?php elseif($phase == 1 ): ?> Jornada 1
                        <?php elseif($phase == 2 ): ?> Jornada 2
                        <?php elseif($phase == 3 ): ?> Jornada 3
                        <?php elseif($phase == 4 ): ?> Jornada 4
                        <?php elseif($phase == 5 ): ?> Jornada 5
                        <?php elseif($phase == 6 ): ?> Jornada 6
                        <?php elseif($phase == 7 ): ?> Jornada 7
                        <?php elseif($phase == 8 ): ?> Jornada 8
                        <?php elseif($phase == 9 ): ?> Jornada 9
                        <?php elseif($phase == 10 ): ?> Jornada 10
                        <?php elseif($phase == 11 ): ?> Jornada 11
                        <?php elseif($phase == 12 ): ?> Jornada 12
                        <?php elseif($phase == 13 ): ?> Jornada 13
                        <?php elseif($phase == 14 ): ?> Jornada 14
                        <?php elseif($phase == 15 ): ?> Jornada 15
                        <?php elseif($phase == 16 ): ?> Jornada 16
                        <?php elseif($phase == 17 ): ?> Jornada 17
                        <?php elseif($phase == 18 ): ?> Jornada 18
                        <?php endif; ?>
                    </h2>

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
</html
<?php /**PATH /home/ubuntu/QuinielaTeiker/resources/views/admin/results.blade.php ENDPATH**/ ?>