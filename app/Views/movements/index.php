<section class="card">
    <div class="section-header">
        <div>
            <h2>Movimientos</h2>
            <p>Tabla de ventas y reabastecimientos con actualizacion de existencias.</p>
        </div>
        <a class="button-link" href="?route=/movements/create">Nuevo movimiento</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>SKU</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Antes</th>
                <th>Despues</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($movements === []): ?>
                <tr>
                    <td colspan="9">Aun no hay movimientos registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($movements as $movement): ?>
                    <tr>
                        <td><?= e($movement['id']) ?></td>
                        <td><?= e($movement['created_at']) ?></td>
                        <td><?= e($movement['product_sku']) ?></td>
                        <td><?= e($movement['product_name']) ?></td>
                        <td><?= $movement['type'] === 'sale' ? 'Venta' : 'Reabastecimiento' ?></td>
                        <td><?= e($movement['quantity']) ?></td>
                        <td><?= e($movement['stock_before']) ?></td>
                        <td><?= e($movement['stock_after']) ?></td>
                        <td><?= e($movement['note']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</section>
