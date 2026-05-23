<section class="grid stats-grid">
    <article class="card stat-card">
        <h2>Productos</h2>
        <strong><?= e($summary['products']) ?></strong>
    </article>
    <article class="card stat-card">
        <h2>Existencias</h2>
        <strong><?= e($summary['stock_total']) ?></strong>
    </article>
    <article class="card stat-card">
        <h2>Movimientos</h2>
        <strong><?= e($summary['movements']) ?></strong>
    </article>
    <article class="card stat-card">
        <h2>Stock bajo</h2>
        <strong><?= e($summary['low_stock']) ?></strong>
    </article>
</section>

<section class="grid two-columns">
    <article class="card">
        <div class="section-header">
            <h2>Accesos rapidos</h2>
        </div>
        <p>Administra el inventario con una base de datos local en archivos de texto.</p>
        <div class="actions-row">
            <a class="button-link" href="?route=/products/create">Crear producto</a>
            <a class="button-link secondary" href="?route=/movements/create">Registrar movimiento</a>
        </div>
    </article>

    <article class="card">
        <div class="section-header">
            <h2>Productos con menos stock</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Producto</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($lowStockProducts === []): ?>
                    <tr>
                        <td colspan="3">Aun no hay productos registrados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($lowStockProducts as $product): ?>
                        <tr>
                            <td><?= e($product['sku']) ?></td>
                            <td><?= e($product['name']) ?></td>
                            <td><?= e($product['stock']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </article>
</section>
