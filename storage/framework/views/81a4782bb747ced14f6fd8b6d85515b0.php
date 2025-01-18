<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('logo-liga_mx.png')); ?>">
    <title>Resultados Capturados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .team-logo {
            width: 40px;
            height: 40px;
            object-fit: contain;
            border-radius: 50%;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="text-left mt-3">
        <a href="<?php echo e(route('quiniela.form')); ?>" class="btn btn-secondary"><- Regresar</a>
    </div>
    <h1 class="text-center">Resultados Capturados</h1>
    
    <div class="row">
        <?php $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($match->activo == 1): ?>
	     <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Título del partido con imágenes -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo e($match->team_a_logo); ?>" alt="<?php echo e($match->team_a); ?>" class="team-logo me-2">
                                <span><?php echo e($match->team_a); ?></span>
                            </div>
                            <span class="text-muted">VS</span>
                            <div class="d-flex align-items-center">
                                <span><?php echo e($match->team_b); ?></span>
                                <img src="<?php echo e($match->team_b_logo); ?>" alt="<?php echo e($match->team_b); ?>" class="team-logo ms-2">
                            </div>
                        </div>
                        
                        <p class="text-center text-muted mt-3">
                            Resultado oficial: <?php echo e($match->score_a ?? '-'); ?> - <?php echo e($match->score_b ?? '-'); ?>

                        </p>

                        <!-- Pronósticos de los usuarios -->
                        <h5>Pronósticos de los usuarios:</h5>
                        <?php if($match->predictions->isEmpty()): ?>
                            <p class="text-muted">No hay pronósticos capturados.</p>
                        <?php else: ?>
                            <ul class="list-group">
                                <?php $__currentLoopData = $match->predictions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prediction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><?php echo e($prediction->user->name ?? 'Usuario desconocido'); ?></span>
                                        <span><?php echo e($prediction->predicted_score_a); ?> - <?php echo e($prediction->predicted_score_b); ?></span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
	   <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /home/ubuntu/QuinielaTeiker/resources/views/quiniela/captured-results.blade.php ENDPATH**/ ?>