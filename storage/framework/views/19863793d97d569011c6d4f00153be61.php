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
    <!-- Instrucciones de la Quiniela -->
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title text-center">Instrucciones de la Quiniela</h2>
            <p class="card-text">
                Bienvenido a la quiniela Teiker de la Liga MX. Aquí encontrarás las reglas y detalles para participar:
            </p>
            <ul>
                <li><strong>Costo de participación:</strong> $100 MXN. </li>
                <li><strong>Reglas de puntuación:</strong></li>
                <ul>
                    <li>3 puntos por acertar el marcador exacto.</li>
                    <li>1 punto por acertar que el partido termina en empate (aunque no sea el marcador exacto).</li>
                    <li>1 punto por acertar al equipo ganador (sin importar el marcador exacto).</li>
                </ul>
                <li><strong>Importante:</strong> Una vez que hayas ingresado tus predicciones, no podrás editarlas.</li>
            </ul>
            <p class="card-text text-center text-muted">
                ¡Buena suerte y que gane el mejor!
            </p>
        </div>
    </div>

    <!-- Formulario de Predicciones -->
    <form id="uniqueKeyForm" method="GET" action="<?php echo e(route('quiniela.form')); ?>">
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="unique_key" class="form-label">Ingresa tu clave única</label>
            <input type="text" class="form-control" id="unique_key" name="unique_key" placeholder="Ej. ABC123" required>
        </div>
        <button type="submit" class="btn btn-primary">Acceder</button>
    </form>

    <form method="POST" action="<?php echo e(route('quiniela.submit')); ?>">
        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php echo csrf_field(); ?>
        <!-- <div class="mb-3">
            <label for="unique_key" class="form-label">Tu clave única</label>
            <input type="text" class="form-control" id="unique_key" name="unique_key"
                   value="<?php echo e($user->unique_key ?? ''); ?>" <?php echo e($user ? 'readonly' : ''); ?> placeholder="Ej. ABC123" required>
        </div> -->
        <!-- Incluye la clave única como campo oculto -->
        <input type="hidden" name="unique_key" value="<?php echo e(request('unique_key')); ?>">

        <?php $__currentLoopData = ['Quarters', 'Semifinals', 'Final']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($matches[$phase])): ?>
                <h2 class="text-center mt-5">
                    <?php if($phase == 'Quarters'): ?> Cuartos de Final
                    <?php elseif($phase == 'Semifinals'): ?> Semifinales
                    <?php elseif($phase == 'Final'): ?> Final
                    <?php endif; ?>
                </h2>

                <!-- Partidos de Ida -->
                <h3 class="mt-4">Ida</h3>
                <div class="row">
                    <?php $__currentLoopData = $matches[$phase]->where('is_first_leg', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="row">
                                        <div class="col-5">
                                            <img src="<?php echo e($match->team_a_logo); ?>" alt="<?php echo e($match->team_a); ?>" class="img-fluid mb-2">
                                            <p><?php echo e($match->team_a); ?></p>
                                            <?php
                                                $prediction = $userPredictions[$match->id] ?? null;
                                            ?>
                                            <?php if($prediction): ?>
                                                <p class="text-muted">Pronóstico enviado</p>
                                                <input type="number" class="form-control mb-2" value="<?php echo e($prediction->predicted_score_a); ?>" disabled>
                                                <p class="text-muted">Resultado: <?php echo e($match->score_a); ?></p>
                                            <?php elseif(!isset($match->score_a) && !isset($match->score_b)): ?>
                                                <input type="number" class="form-control" name="predictions[<?php echo e($match->id); ?>][score_a]" placeholder="Marcador" required>
                                            <?php else: ?>
                                                <p class="text-muted">Predicción cerrada</p>
                                                <p class="text-muted">Resultado: <?php echo e($match->score_a); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-2 align-self-center">
                                            <h4>VS</h4>
                                        </div>
                                        <div class="col-5">
                                            <img src="<?php echo e($match->team_b_logo); ?>" alt="<?php echo e($match->team_b); ?>" class="img-fluid mb-2">
                                            <p><?php echo e($match->team_b); ?></p>
                                            <?php if($prediction): ?>
                                                <p class="text-muted">Pronóstico enviado</p>
                                                <input type="number" class="form-control mb-2" value="<?php echo e($prediction->predicted_score_b); ?>" disabled>
                                                <p class="text-muted">Resultado: <?php echo e($match->score_b); ?></p>
                                            <?php elseif(!isset($match->score_a) && !isset($match->score_b)): ?>
                                                <input type="number" class="form-control" name="predictions[<?php echo e($match->id); ?>][score_b]" placeholder="Marcador" required>
                                            <?php else: ?>
                                                <p class="text-muted">Predicción cerrada</p>
                                                <p class="text-muted">Resultado: <?php echo e($match->score_b); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Partidos de Vuelta -->
                <h3 class="mt-4">Vuelta</h3>
                <div class="row">
                    <?php $__currentLoopData = $matches[$phase]->where('is_first_leg', false); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="row">
                                        <div class="col-5">
                                            <img src="<?php echo e($match->team_a_logo); ?>" alt="<?php echo e($match->team_a); ?>" class="img-fluid mb-2">
                                            <p><?php echo e($match->team_a); ?></p>
                                            <?php
                                                $prediction = $userPredictions[$match->id] ?? null;
                                            ?>
                                            <?php if($prediction): ?>
                                                <p class="text-muted">Pronóstico enviado</p>
                                                <input type="number" class="form-control mb-2" value="<?php echo e($prediction->predicted_score_a); ?>" disabled>
                                                <p class="text-muted">Resultado: <?php echo e($match->score_a); ?></p>
                                            <?php elseif(!isset($match->score_a) && !isset($match->score_b)): ?>
                                                <input type="number" class="form-control" name="predictions[<?php echo e($match->id); ?>][score_a]" placeholder="Marcador" required>
                                            <?php else: ?>
                                                <p class="text-muted">Predicción cerrada</p>
                                                <p class="text-muted">Resultado: <?php echo e($match->score_a); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-2 align-self-center">
                                            <h4>VS</h4>
                                        </div>
                                        <div class="col-5">
                                            <img src="<?php echo e($match->team_b_logo); ?>" alt="<?php echo e($match->team_b); ?>" class="img-fluid mb-2">
                                            <p><?php echo e($match->team_b); ?></p>
                                            <?php if($prediction): ?>
                                                <p class="text-muted">Pronóstico enviado</p>
                                                <input type="number" class="form-control mb-2" value="<?php echo e($prediction->predicted_score_b); ?>" disabled>
                                                <p class="text-muted">Resultado: <?php echo e($match->score_b); ?></p>
                                            <?php elseif(!isset($match->score_a) && !isset($match->score_b)): ?>
                                                <input type="number" class="form-control" name="predictions[<?php echo e($match->id); ?>][score_b]" placeholder="Marcador" required>
                                            <?php else: ?>
                                                <p class="text-muted">Predicción cerrada</p>
                                                <p class="text-muted">Resultado: <?php echo e($match->score_b); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Enviar Predicciones</button>
        </div>
    </form>

    <!-- Botón para ver el ranking -->
    <div class="text-center mt-3">
        <a href="<?php echo e(route('quiniela.ranking')); ?>" class="btn btn-secondary">Ver Puntuaciones</a>
        <a href="<?php echo e(route('quiniela.quinielas-capturadas')); ?>" class="btn btn-secondary">Ver Quinielas</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html<?php /**PATH /Users/hectortorres/Proyectos/quinielaTeiker/resources/views/quiniela/form.blade.php ENDPATH**/ ?>