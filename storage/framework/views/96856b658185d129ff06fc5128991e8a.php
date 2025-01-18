<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Posiciones</title>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('logo-liga_mx.png')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .match-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
        }
        .match-logo {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }
        .team-name {
            font-size: 14px;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="container my-5">
     <!-- Botón para ver el ranking -->
    <div class="text-left mt-3">
        <a href="<?php echo e(route('quiniela.form')); ?>" class="btn btn-secondary"><- Regresar</a>
    </div>
    <h1 class="text-center">Tabla de Posiciones</h1>

    <!-- Rankings -->
    <table class="table table-bordered table-striped text-center mt-4">
        <thead>
            <tr>
                <th>Posición</th>
                <th>Usuario</th>
                <th>Puntos</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $rankings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ranking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($ranking['name']); ?></td>
                    <td><?php echo e($ranking['points']); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <!-- Partidos por fase -->
    <?php $__currentLoopData = ['Quarters', 'Semifinals', 'Final']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <h2 class="text-center mt-5">
            <?php if($phase == 'Quarters'): ?> Cuartos de Final
            <?php elseif($phase == 'Semifinals'): ?> Semifinales
            <?php elseif($phase == 'Final'): ?> Final
            <?php endif; ?>
        </h2>
        <div class="row">
            <?php $__currentLoopData = $matches[$phase] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6">
                    <div class="match-card d-flex align-items-center justify-content-between">
                        <div class="team d-flex align-items-center">
                            <img src="<?php echo e($match->team_a_logo); ?>" alt="<?php echo e($match->team_a); ?>" class="match-logo me-2">
                            <div>
                                <p class="team-name"><?php echo e($match->team_a); ?></p>
                            </div>
                        </div>
                        <div class="score">
                            <h5 class="mb-0"><?php echo e($match->score_a ?? '-'); ?></h5>
                        </div>
                        <div class="vs text-muted">VS</div>
                        <div class="score">
                            <h5 class="mb-0"><?php echo e($match->score_b ?? '-'); ?></h5>
                        </div>
                        <div class="team d-flex align-items-center">
                            <img src="<?php echo e($match->team_b_logo); ?>" alt="<?php echo e($match->team_b); ?>" class="match-logo me-2">
                            <div>
                                <p class="team-name"><?php echo e($match->team_b); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php if(!isset($match->score_a) && !isset($match->score_b)): ?>
                        <p class="text-muted">Pronósticos aún habilitados</p>
                    <?php else: ?>
                        <p class="text-muted">Pronósticos cerrados</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script><?php /**PATH /Users/hectortorres/Proyectos/quinielaTeiker/resources/views/quiniela/ranking.blade.php ENDPATH**/ ?>