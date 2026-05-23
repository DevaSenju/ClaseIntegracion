<?php
/** @var string $content */
/** @var array|null $flash */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($this->config['app_name']) ?></title>
    <link rel="stylesheet" href="<?= e(APP_ASSET_PREFIX) ?>assets/css/style.css">
</head>
<body>
    <header class="topbar">
        <div>
            <h1><?= e($this->config['app_name']) ?></h1>
            <p>Registro de productos, existencias y movimientos.</p>
        </div>
        <nav>
            <a href="?route=/">Inicio</a>
            <a href="?route=/products">Productos</a>
            <a href="?route=/movements">Movimientos</a>
            <a class="button-link" href="?route=/movements/create">Nuevo movimiento</a>
        </nav>
    </header>

    <main class="container">
        <?php if (!empty($flash)): ?>
            <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
        <?php endif; ?>

        <?= $content ?>
    </main>
</body>
</html>
