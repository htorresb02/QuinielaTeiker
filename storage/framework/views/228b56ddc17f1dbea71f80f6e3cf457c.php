<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Posiciones</title>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('logo-liga_mx.png')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> 
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
    
    <?php if($phase): ?>
        <h2 class="text-center">Ranking - <?php echo e(is_numeric($phase) ? 'Jornada ' . $phase : ucfirst($phase)); ?></h2>
        <table class="table table-bordered table-striped text-center mt-4">
            <thead>
                <tr>
                    <th>Posición</th>
                    <th>Usuario</th>
                    <th>Puntos</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $rankings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($user['name']); ?></td>
                        <td><?php echo e($user['points']); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
    <!-- Rankings -->
    <h2 class="text-center">Puntos Acumulados</h2>
    <table class="table table-bordered table-striped text-center mt-4">
        <thead>
            <tr>
                <th></th>
                <th>Posición</th>
                <th>Usuario</th>
                <th>Puntos Totales</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $overallRankings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Determinar el color según la posición
                    $borderColor = '';
                    if ($index < 4) {
                        $borderColor = 'border-bottom: 4px solid #007bff;'; // Azul
                    } elseif ($index < 7) {
                        $borderColor = 'border-bottom: 4px solid #ffc107;'; // Naranja
                    } elseif ($index < 9) {
                        $borderColor = 'border-bottom: 4px solid #28a745;'; // Verde
                    } elseif ($index >= count($overallRankings) - 2) {
                        $borderColor = 'border-bottom: 4px solid #dc3545;'; // Rojo
                    }
                ?>
                <tr >
                    <td style="width: 10px; height: 100%;" ><div style="width: 10px; height: 100%; <?php echo e($borderColor); ?> border-radius: 2px;"></div></td>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($user['name']); ?></td>
                    <td><?php echo e($user['total_points']); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <!-- Partidos por fase -->
    <?php $__currentLoopData = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18, 'Quarters', 'Semifinals', 'Final']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <h2 class="text-center mt-5">
	   <?php if($phase == 1 ): ?> Jornada 1
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
            <?php elseif($phase == 'Quarters'): ?> Cuartos de Final
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php /**PATH /home/ubuntu/QuinielaTeiker/resources/views/quiniela/ranking.blade.php ENDPATH**/ ?>