<section class="card">
    <div class="section-header">
        <div>
            <h2>Productos</h2>
            <p>Tabla local de productos e inventario actual.</p>
        </div>
        <a class="button-link" href="?route=/products/create">Nuevo producto</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>SKU</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($products === []): ?>
                <tr>
                    <td colspan="7">No hay productos registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= e($product['id']) ?></td>
                        <td><?= e($product['sku']) ?></td>
                        <td><?= e($product['name']) ?></td>
                        <td>$<?= e(number_format((float) $product['price'], 2)) ?></td>
                        <td><?= e($product['stock']) ?></td>
                        <td><?= (bool) $product['active'] ? 'Activo' : 'Inactivo' ?></td>
                        <td><a href="?route=/products/edit&id=<?= e($product['id']) ?>">Editar</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</section>
